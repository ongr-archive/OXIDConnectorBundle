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

namespace ONGR\OXIDConnectorBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Entity\Seo;
use ONGR\OXIDConnectorBundle\Modifier\Traits\EntityAliasAwareTrait;
use ONGR\OXIDConnectorBundle\Modifier\Traits\LanguageAwareTrait;
use ONGR\OXIDConnectorBundle\Modifier\Traits\ShopAwareTrait;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\SeoHistory;

/**
 * This class is able to load seo urls for given entity
 */
class SeoUrlService
{
    /**
     * This modifier uses custom queries so we need to know which Entities we are using
     */
    use EntityAliasAwareTrait;

    /**
     * Language for queries
     */
    use LanguageAwareTrait;

    /**
     * Shop id for queries
     */
    use ShopAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get Active urls, if an object is of type Article we must prioritise the first Category's  url
     *
     * @param Article|Category|Content|object $entity
     * @return array
     */
    public function getActiveUrlList($entity)
    {
        $seoList = $this->getSeo($entity);
        $result = [];

        /** @var ArticleToCategory $topPriority */
        $topPriority = $entity instanceof Article?$entity->getCategories()->first():null;

        foreach ($seoList as $seo) {
            if ($topPriority && $topPriority->getCategory()->getId() == $seo->getParams()) {
                array_unshift($result, $this->getSingleActiveUrl($seo));

            } else {
                array_push($result, $this->getSingleActiveUrl($seo));
            }
        }
        return $result;
    }

    /**
     * Returns an array with seo properties
     *
     * @param Seo $seo
     * @return array
     */
    protected function getSingleActiveUrl(Seo $seo)
    {
        return ['url' => $seo->getSeoUrl(), 'key' => $seo->getParams()];
    }

    /**
     * Get SEO object from database for entity
     *
     * @param object $entity
     * @return Seo[]
     */
    protected function getSeo($entity)
    {
        /** @var Query $query */
        $query = $this->entityManager->createQuery(
            'SELECT s ' .
            'FROM ' . $this->getEntityAlias() . ':Seo s ' .
            'WHERE s.objectId = :id' .
            ($this->shopId !== null ? ' AND s.shopId = :shopId' : '') .
            ($this->languageId !== null ? ' AND s.lang = :lang' : '')
        );

        $query->setParameter('id', $entity->getId());
        if ($this->shopId !== null) {
            $query->setParameter('shopId', $this->shopId);
        }
        if ($this->languageId !== null) {
            $query->setParameter('lang', $this->languageId);
        }

        return $query->getResult();
    }

    /**
     * Get expired SEO links from database for entity
     *
     * @param object $entity
     * @return array
     */
    public function getSeoHistoryHashes($entity)
    {
        /** @var Query $query */
        $query = $this->entityManager->createQuery(
            'SELECT h ' .
            'FROM ' . $this->getEntityAlias() . ':SeoHistory h ' .
            'WHERE h.objectId = :id' .
            ($this->shopId !== null ? ' AND h.shopId = :shopId' : '') .
            ($this->languageId !== null ? ' AND h.lang = :lang' : '')
        );

        $query->setParameter('id', $entity->getId());
        if ($this->shopId !== null) {
            $query->setParameter('shopId', $this->shopId);
        }
        if ($this->languageId !== null) {
            $query->setParameter('lang', $this->languageId);
        }

        /** @var SeoHistory[] $result */
        $result = $query->getResult();

        $out = [];

        foreach ($result as $item) {
            $out[] = $item->getIdent();
        }

        return $out;
    }
}
