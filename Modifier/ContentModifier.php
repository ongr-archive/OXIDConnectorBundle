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

use ONGR\ConnectionsBundle\EventListener\AbstractImportModifyEventListener;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\OXIDConnectorBundle\Document\ContentDocument;
use ONGR\OXIDConnectorBundle\Entity\Content;

/**
 * Converts OXID content to ONGR content document.
 */
class ContentModifier extends AbstractImportModifyEventListener
{
    /**
     * {@inheritdoc}
     */
    public function modify(AbstractImportItem $eventItem)
    {
        /** @var Content $content */
        $content = $eventItem->getEntity();
        /** @var ContentDocument $document */
        $document = $eventItem->getDocument();

        $this->transformContentToDocument($content, $document);
    }

    /**
     * Transforms Content entity into ES document.
     *
     * @param Content         $content
     * @param ContentDocument $document
     */
    public function transformContentToDocument(Content $content, ContentDocument $document)
    {
        $document->setId($content->getId());
        $document->setTitle($content->getTitle());
        $document->setContent($content->getContent());
        $document->setFolder($content->getFolder());
        $document->setSlug($content->getLoadId());
        $document->setSnippet($content->isSnippet());
        $document->setType($content->getType());
        $document->setActive($content->isActive());
        $document->setPosition($content->getPosition());
    }
}
