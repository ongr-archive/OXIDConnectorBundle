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
 * Entity for table "oxobject2seodata".
 *
 * @ORM\MappedSuperclass
 */
abstract class ObjectToSeoData
{
    /**
     * @var string
     *
     * @ORM\Column(name="OXOBJECTID", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $objectId;

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
     * @var string
     *
     * @ORM\Column(name="OXKEYWORDS", type="text")
     */
    protected $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="OXDESCRIPTION", type="text")
     */
    protected $description;

    /**
     * Sets mapped object ID.
     *
     * @param string $objectId
     *
     * @return ObjectToSeoData
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
     * Sets shop ID.
     *
     * @param int $shopId
     *
     * @return ObjectToSeoData
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
     * @return ObjectToSeoData
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
     * Sets keywords.
     *
     * @param string $keywords
     *
     * @return ObjectToSeoData
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Returns keywords.
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Sets description.
     *
     * @param string $description
     *
     * @return ObjectToSeoData
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
