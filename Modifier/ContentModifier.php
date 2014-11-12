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

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\Content;

/**
 * Converts OXID content to ONGR content document
 */
class ContentModifier implements ModifierInterface
{
    /**
     * {@inheritDoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        /** @var Content $entity */

        $document->id = $entity->getId();
        $document->title = $entity->getTitle();
        $document->content = $entity->getContent();
        $document->folder = $entity->getFolder();
        $document->slug = $entity->getLoadId();
    }
}
