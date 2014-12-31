<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for table "oxseohistory".
 *
 * @ORM\MappedSuperclass
 */
class SeoHistory
{
    /**
     * @var string
     *
     * @ORM\Column(name="OXOBJECTID", type="string")
     */
    protected $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="OXIDENT", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $ident;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSHOPID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $shopId;

    /**
     * @var int
     *
     * @ORM\Column(name="OXLANG", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $lang;

    /**
     * @var int
     *
     * @ORM\Column(name="OXHITS", type="bigint")
     */
    protected $hits;

    /**
     * Sets mapped object ID.
     *
     * @param string $objectId
     *
     * @return SeoHistory
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Returns mapped object ID.
     *
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Sets identifier.
     *
     * @param string $identifier
     *
     * @return SeoHistory
     */
    public function setIdent($identifier)
    {
        $this->ident = $identifier;

        return $this;
    }

    /**
     * Returns identifier.
     *
     * @return string
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * Sets shop ID.
     *
     * @param int $shopId
     *
     * @return SeoHistory
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * Returns shop ID.
     *
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * Sets language ID.
     *
     * @param int $lang
     *
     * @return SeoHistory
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Returns language ID.
     *
     * @return int
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Sets hits.
     *
     * @param int $hits
     *
     * @return SeoHistory
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    /**
     * Returns number of hits.
     *
     * @return int
     */
    public function getHits()
    {
        return $this->hits;
    }
}
