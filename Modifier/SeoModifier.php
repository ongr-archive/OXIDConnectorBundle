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

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\ObjectToSeoData;
use ONGR\OXIDConnectorBundle\Modifier\Traits\EntityAliasAwareTrait;
use ONGR\OXIDConnectorBundle\Modifier\Traits\LanguageAwareTrait;
use ONGR\OXIDConnectorBundle\Modifier\Traits\ShopAwareTrait;

/**
 * Gets necessary SEO data for new entity from OXID.
 */
class SeoModifier implements ModifierInterface
{
    use EntityAliasAwareTrait;
    use LanguageAwareTrait;
    use ShopAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $mapping = ['getKeywords' => 'metaKeywords', 'getDescription' => 'metaDescription'];

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param array                  $mapping
     */
    public function __construct(EntityManagerInterface $entityManager, array $mapping = null)
    {
        $this->entityManager = $entityManager;

        if ($mapping !== null) {
            $this->mapping = $mapping;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        $seoData = $this->getSeoData($entity);
        if (!$seoData) {
            return;
        }

        foreach ($this->mapping as $entityField => $objectField) {
            $document->{$objectField} = $seoData->{$entityField}();
        }
    }

    /**
     * Returns SeoData of the entity.
     *
     * @param object $entity
     *
     * @return ObjectToSeoData|bool
     */
    protected function getSeoData($entity)
    {
        /** @var Query $query */
        $query = $this->entityManager->createQuery(
            'SELECT sd
            FROM ' . $this->getEntityAlias() . ':ObjectToSeoData sd
            WHERE sd.objectId = :id' .
            ($this->shopId !== null ? ' AND sd.shopId = :shopId' : '') .
            ($this->languageId !== null ? ' AND sd.lang = :lang' : '')
        );

        $query->setParameter('id', $entity->getId());
        if ($this->shopId !== null) {
            $query->setParameter('shopId', $this->shopId);
        }
        if ($this->languageId !== null) {
            $query->setParameter('lang', $this->languageId);
        }
        $result = $query->getResult();

        return reset($result);
    }
}
