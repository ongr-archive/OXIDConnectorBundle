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
use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ObjectToCategory;

/**
 * Converts OXID article to ONGR product document.
 */
class ProductModifier implements ModifierInterface
{
    /**
     * {@inheritdoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        /** @var Article $entity */

        $document->id = $entity->getId();
        $document->active = $entity->isActive();
        $document->sku = $entity->getArtNum();
        $document->title = $entity->getTitle();
        $document->description = $entity->getShortDesc();
        $document->price = $entity->getPrice();
        $document->oldPrice = $entity->getTPrice();
        $document->parentId = $entity->getParent()->getId();
        $document->stock = $entity->getStock();

        $this->getExtensionData($entity, $document);
        $this->getVendor($entity, $document);
        $this->getManufacturer($entity, $document);
        $this->getCategories($entity, $document);
    }

    /**
     * Retrieves article extension data.
     *
     * @param Article           $entity
     * @param DocumentInterface $document
     */
    protected function getExtensionData(Article $entity, DocumentInterface $document)
    {
        try {
            $document->longDescription = $entity->getExtension()->getLongDesc();
        } catch (EntityNotFoundException $exception) {
            // No extension. Just ignore.
        }
    }

    /**
     * Retrieves vendor title.
     *
     * @param Article           $entity
     * @param DocumentInterface $document
     */
    protected function getVendor(Article $entity, DocumentInterface $document)
    {
        try {
            $document->vendor = $entity->getVendor()->getTitle();
        } catch (EntityNotFoundException $exception) {
            // No vendor. Just ignore.
        }
    }

    /**
     * Retrieves manufacturer title.
     *
     * @param Article           $entity
     * @param DocumentInterface $document
     */
    protected function getManufacturer(Article $entity, DocumentInterface $document)
    {
        try {
            $document->manufacturer = $entity->getManufacturer()->getTitle();
        } catch (EntityNotFoundException $exception) {
            // No manufacturer. Just ignore.
        }
    }

    /**
     * Converts Article categories to ProductModel categories.
     *
     * @param Article           $entity
     * @param DocumentInterface $document
     */
    protected function getCategories(Article $entity, DocumentInterface $document)
    {
        try {
            /** @var ObjectToCategory $relation */
            foreach ($entity->getCategories() as $relation) {
                if ($relation->getCategory()->isActive()) {
                    $document->categories[] = $relation->getCategory()->getId();
                }
            }
        } catch (EntityNotFoundException $exception) {
            // No categories. Just ignore.
        }
    }
}
