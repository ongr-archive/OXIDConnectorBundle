<?php

/*
 *************************************************************************
 * NFQ eXtremes CONFIDENTIAL
 * [2013] - [2014] NFQ eXtremes UAB
 * All Rights Reserved.
 *************************************************************************
 * NOTICE: 
 * All information contained herein is, and remains the property of NFQ eXtremes UAB.
 * Dissemination of this information or reproduction of this material is strictly forbidden
 * unless prior written permission is obtained from NFQ eXtremes UAB.
 *************************************************************************
 */

namespace ONGR\OXIDConnectorBundle\Modifier;

use Doctrine\ORM\EntityNotFoundException;
use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ObjectToCategory;

/**
 * Converts OXID article to ONGR product document
 */
class ProductModifier implements ModifierInterface
{
    /**
     * {@inheritDoc}
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
     * Retrieves article extension data
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
     * Retrieves vendor title
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
     * Retrieves manufacturer title
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
     * Converts Article categories to ProductModel categories
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
