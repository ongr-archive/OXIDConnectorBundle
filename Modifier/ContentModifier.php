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
use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\AbstractImportItem;
use ONGR\OXIDConnectorBundle\Document\ContentDocument;
use ONGR\OXIDConnectorBundle\Entity\Content;
use ONGR\OXIDConnectorBundle\Entity\Seo;
use ONGR\OXIDConnectorBundle\Service\SeoFinder;
use ONGR\RouterBundle\Document\UrlNested;

/**
 * Converts OXID content to ONGR content document.
 */
class ContentModifier extends AbstractImportModifyEventListener
{
    /**
     * @var int
     */
    private $languageId = 0;

    /**
     * @var SeoFinder
     */
    private $seoFinderService;

    /**
     * {@inheritdoc}
     */
    public function modify(AbstractImportItem $eventItem, ItemPipelineEvent $event)
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

        $this->extractUrls($content, $document);
    }

    /**
     * Extract content seo urls.
     *
     * @param Content         $content
     * @param ContentDocument $document
     */
    private function extractUrls(Content $content, $document)
    {
        $urls = [];
        $seoUrls = $this->getSeoFinderService()->getEntitySeo($content, $this->languageId);
        if (count($seoUrls) > 0) {
            foreach ($seoUrls as $seo) {
                /** @var Seo $seo */
                $urlObject = new UrlNested();
                $urlObject->setUrl($seo->getSeoUrl());
                $urls[] = $urlObject;
            }
        }

        $document->setUrls(new \ArrayIterator($urls));
        $document->setExpiredUrls([]);
    }

    /**
     * Set language id.
     *
     * @param int $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * @return SeoFinder
     */
    public function getSeoFinderService()
    {
        return $this->seoFinderService;
    }

    /**
     * @param SeoFinder $seoFinderService
     *
     * @return $this
     */
    public function setSeoFinderService(SeoFinder $seoFinderService)
    {
        $this->seoFinderService = $seoFinderService;

        return $this;
    }
}
