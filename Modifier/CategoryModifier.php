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
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\RouterBundle\Document\UrlObject;

/**
 * Converts OXID category to ONGR category document.
 */
class CategoryModifier extends AbstractImportModifyEventListener
{
    /**
     * @var AttributesToDocumentsService
     */
    private $attrToDocService;

    /**
     * @var int
     */
    private $languageId = 0;

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
    public function modify(AbstractImportItem $importItem, ItemPipelineEvent $event)
    {
        /** @var Category $category */
        $category = $importItem->getEntity();
        /** @var CategoryDocument $document */
        $document = $importItem->getDocument();

        $this->transformCategoryToDocument($category, $document);
    }

    /**
     * Transforms Category entity into ES document.
     *
     * @param Category         $category
     * @param CategoryDocument $document
     */
    public function transformCategoryToDocument(Category $category, CategoryDocument $document)
    {
        $document->setId($category->getId());
        $document->setActive($category->isActive());
        $document->setHidden($category->isHidden());
        $document->setLeft($category->getLeft());
        $document->setRight($category->getRight());
        $document->setRootId($category->getRoot()->getId());
        $document->setSort($category->getSort());
        $document->setTitle($category->getTitle());
        $document->setDescription($category->getDesc());
        $document->setLongDescription($category->getLongDesc());
        $document->setAttributes($this->attrToDocService->transform($category->getAttributes()));
        $this->extractUrls($category, $document);

        $parent = $category->getParent();
        $parentId = $parent ? $parent->getId() : null;
        if (empty($parentId) === false) {
            $document->setParentId($parentId);
        } else {
            $document->setParentId('oxrootid');
        }
    }

    /**
     * Extract category seo urls.
     *
     * @param Category         $category
     * @param CategoryDocument $document
     */
    private function extractUrls(Category $category, $document)
    {
        $urls = [];
        $seoUrls = $category->getSeoUrls();
        if (count($seoUrls) > 0) {
            foreach ($seoUrls as $seo) {
                if ($seo->getLang() === $this->languageId) {
                    /** @var Seo $seo */
                    $urlObject = new UrlObject();
                    $urlObject->url = $seo->getSeoUrl();
                    $urls[] = $urlObject;
                }
            }
        }

        $document->url = $urls;
        $document->expiredUrl = [];
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
}
