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
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
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
    public function modify(AbstractImportItem $eventItem)
    {
        /** @var Article $article */
        $article = $eventItem->getEntity();
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

        $parent_id = $article->getParent()->getId();
        if (empty($parent_id) === false) {
            $document->setParentId($parent_id);
        } else {
            $document->setParentId('oxrootid');
        }

        $this->extractExtensionData($article, $document);
        $this->extractVendor($article, $document);
        $this->extractManufacturer($article, $document);
        $this->extractCategories($article, $document);
    }

    /**
     * Retrieves article extension data.
     *
     * @param Article         $entity
     * @param ProductDocument $document
     */
    protected function extractExtensionData(Article $entity, ProductDocument $document)
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
}
