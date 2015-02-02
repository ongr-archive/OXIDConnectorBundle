<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Modifier;

use Doctrine\ORM\EntityNotFoundException;
use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\ConnectionsBundle\Pipeline\ItemSkipper;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Document\VariantObject;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ObjectToCategory;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;

/**
 * Converts OXID article to ONGR product document.
 */
class ProductModifier extends AbstractImportModifyEventListener
{
    /**
     * @var AttributesToDocumentsService
     */
    private $attrToDocService;

    /**
     * Dependency injection.
     *
     * @param AttributesToDocumentsService $attrToDocService
     */
    public function __construct(AttributesToDocumentsService $attrToDocService)
    {
        $this->attrToDocService = $attrToDocService;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(AbstractImportItem $eventItem, ItemPipelineEvent $event)
    {
        /** @var Article $article */
        $article = $eventItem->getEntity();

        $parent = $article->getParent();
        if ($parent && $parent->getId()) {
            ItemSkipper::skip($event, 'Ignore item variants');

            return;
        }

        /** @var ProductDocument $document */
        $document = $eventItem->getDocument();

        $document->setId($article->getId());
        $document->setActive($article->isActive());
        $document->setSku($article->getArtNum());
        $document->setTitle($article->getTitle());
        $document->setDescription($article->getShortDesc());
        $document->setPrice($article->getPrice());
        $document->setOldPrice($article->getTPrice());
        $document->setStock($article->getStock());
        $document->setAttributes($this->attrToDocService->transform($article->getAttributes()));

        $this->extractExtensionData($article, $document);
        $this->extractVendor($article, $document);
        $this->extractManufacturer($article, $document);
        $this->extractCategories($article, $document);

        $variants = $article->getVariants();
        if ($variants) {
            foreach ($variants as $variant) {
                $this->modifyVariant($document, $variant);
            }
        }
    }

    /**
     * Retrieves article extension data.
     *
     * @param Article                       $entity
     * @param ProductDocument|VariantObject $document
     */
    protected function extractExtensionData(Article $entity, $document)
    {
        try {
            $document->setLongDescription($entity->getExtension()->getLongDesc());
        } catch (EntityNotFoundException $exception) {
            // No extension. Just ignore.
        }
    }

    /**
     * Retrieves vendor title.
     *
     * @param Article         $entity
     * @param ProductDocument $document
     */
    protected function extractVendor(Article $entity, ProductDocument $document)
    {
        try {
            $document->setVendor($entity->getVendor()->getTitle());
        } catch (EntityNotFoundException $exception) {
            // No vendor. Just ignore.
        }
    }

    /**
     * Retrieves manufacturer title.
     *
     * @param Article         $entity
     * @param ProductDocument $document
     */
    protected function extractManufacturer(Article $entity, ProductDocument $document)
    {
        try {
            $document->setManufacturer($entity->getManufacturer()->getTitle());
        } catch (EntityNotFoundException $exception) {
            // No manufacturer. Just ignore.
        }
    }

    /**
     * Converts Article categories to ProductModel categories.
     *
     * @param Article         $entity
     * @param ProductDocument $document
     */
    protected function extractCategories(Article $entity, ProductDocument $document)
    {
        try {
            $categories = [];

            /** @var ObjectToCategory $relation */
            foreach ($entity->getCategories() as $relation) {
                if ($relation->getCategory()->isActive()) {
                    $categories[] = $relation->getCategory()->getId();
                }
            }

            $document->setCategories($categories);
        } catch (EntityNotFoundException $exception) {
            // No categories. Just ignore.
        }
    }

    /**
     * Adds product variant to document.
     *
     * @param ProductDocument $document
     * @param Article         $variant
     */
    protected function modifyVariant($document, $variant)
    {
        $variantObject = new VariantObject();

        $variantObject->setId($variant->getId());
        $variantObject->setActive($variant->isActive());
        $variantObject->setSku($variant->getArtNum());
        $variantObject->setTitle($variant->getTitle());
        $variantObject->setDescription($variant->getShortDesc());
        $variantObject->setPrice($variant->getPrice());
        $variantObject->setOldPrice($variant->getTPrice());
        $variantObject->setStock($variant->getStock());
        $variantObject->setAttributes($this->attrToDocService->transform($variant->getAttributes()));

        $this->extractExtensionData($variant, $variantObject);

        $document->addVariant($variantObject);
    }
}
