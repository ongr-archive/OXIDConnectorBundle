<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Variant object.
 *
 * @ES\Object
 */
class VariantObject
{
    /**
     * @var string
     *
     * @ES\Property(name="id", type="string")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ES\Property(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var float
     *
     * @ES\Property(name="old_price", type="float")
     */
    protected $oldPrice;

    /**
     * @var float
     *
     * @ES\Property(name="stock", type="float")
     */
    protected $stock;

    /**
     * @var AttributeObject[]
     *
     * @ES\Property(
     *     name="attributes",
     *     objectName="ONGROXIDConnectorBundle:AttributeObject",
     *     multiple=true,
     *     type="object"
     * )
     */
    protected $attributes;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="title", fields={@ES\MultiField(name="raw", type="string")})
     */
    protected $title;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="description")
     */
    protected $description;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="long_description")
     */
    protected $longDescription;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="sku")
     */
    protected $sku;

    /**
     * @var float
     *
     * @ES\Property(type="float", name="price")
     */
    protected $price;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return float
     */
    public function getOldPrice()
    {
        return $this->oldPrice;
    }

    /**
     * @param float $oldPrice
     *
     * @return $this
     */
    public function setOldPrice($oldPrice)
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param float $stock
     *
     * @return $this
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return AttributeObject[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param AttributeObject[] $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $longDescription
     *
     * @return $this
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     *
     * @return $this
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
