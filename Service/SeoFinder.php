<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Service;

use Doctrine\ORM\EntityManager;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\Content;
use ONGR\OXIDConnectorBundle\Entity\Seo;

/**
 * Class SeoFinder.
 */
class SeoFinder
{
    /**
     * @var string
     */
    private $shopId;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $repository;

    /**
     * @param Category|Content|Article $entity
     * @param int|null                 $languageId
     *
     * @return Seo[]
     *
     * @throws \InvalidArgumentException
     */
    public function getEntitySeo($entity, $languageId = null)
    {
        if ($entity instanceof Category) {
            $type = 'oxcategory';
        } elseif ($entity instanceof Article) {
            $type = 'oxarticle';
        } elseif ($entity instanceof Content) {
            $type = 'oxcontent';
        } else {
            throw new \InvalidArgumentException();
        }

        $queryBuilder = $this
            ->getEntityManager()->getRepository($this->getRepository())
            ->createQueryBuilder('s');

        $queryBuilder
            ->where('s.type = :type')
            ->andWhere('s.objectId = :id')
            ->andWhere('s.shopId = :shopId');
        $parameters = [
            'type' => $type,
            'id' => $entity->getId(),
            'shopId' => $this->getShopId(),
        ];

        if ($languageId !== null) {
            $queryBuilder->andWhere('s.lang = :lang');
            $parameters['lang'] = $languageId;
        }

        $query = $queryBuilder
            ->getQuery()
            ->setParameters($parameters);

        return $query->getResult();
    }

    /**
     * @return EntityManager
     *
     * @throws \LogicException
     */
    public function getEntityManager()
    {
        if ($this->entityManager === null) {
            throw new \LogicException('setEntityManager must be called before getEntityManager');
        }

        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param string $shopId
     *
     * @return $this
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param string $repository
     *
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }
}
