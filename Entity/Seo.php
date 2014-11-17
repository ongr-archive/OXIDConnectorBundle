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
 * Entity for table "oxseo".
 *
 * @ORM\MappedSuperclass
 */
class Seo
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
     * @var string
     *
     * @ORM\Column(name="OXSEOURL", type="string")
     */
    protected $seoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTYPE", type="string")
     */
    protected $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXFIXED", type="boolean")
     */
    protected $fixed;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXEXPIRED", type="boolean")
     */
    protected $expired;

    /**
     * @var string
     *
     * @ORM\Column(name="OXPARAMS", type="string")
     */
    protected $params;

    /**
     * Sets mapped object ID.
     *
     * @param string $objectId
     *
     * @return Seo
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
     * @return Seo
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
     * @return Seo
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
     * @return Seo
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
     * Sets SEO URL.
     *
     * @param string $seoUrl
     *
     * @return Seo
     */
    public function setSeoUrl($seoUrl)
    {
        $this->seoUrl = $seoUrl;

        return $this;
    }

    /**
     * Returns SEO URL.
     *
     * @return string
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    /**
     * Sets type.
     *
     * @param string $type
     *
     * @return Seo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets fixed state.
     *
     * @param bool $fixed
     *
     * @return Seo
     */
    public function setFixed($fixed)
    {
        $this->fixed = $fixed;

        return $this;
    }

    /**
     * Check if link is fixed.
     *
     * @return bool
     */
    public function isFixed()
    {
        return $this->fixed;
    }

    /**
     * Sets expired state.
     *
     * @param bool $expired
     *
     * @return Seo
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Check if link is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * Sets parameters.
     *
     * @param string $parameters
     *
     * @return Seo
     */
    public function setParams($parameters)
    {
        $this->params = $parameters;

        return $this;
    }

    /**
     * Returns parameters.
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }
}
