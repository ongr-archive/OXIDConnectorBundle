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

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\Content;

/**
 * Converts OXID content to ONGR content document.
 */
class ContentModifier implements ModifierInterface
{
    /**
     * {@inheritdoc}
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
