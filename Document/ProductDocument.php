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

use ONGR\ContentBundle\Document\AbstractProductDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Product document.
 *
 * @ES\Document(type="product")
 */
class ProductDocument extends AbstractProductDocument
{
    /**
     * @var string
     *
     * @ES\Property(name="parent_id", type="string")
     */
    private $parentId;

    /**
     * @var bool
     *
     * @ES\Property(name="active", type="boolean")
     */
    private $active;

    /**
     * @var float
     *
     * @ES\Property(name="old_price", type="float")
     */
    private $oldPrice;

    /**
     * @var float
     *
     * @ES\Property(name="stock", type="float")
     */
    private $stock;

    /**
     * @var string
     *
     * @ES\Property(name="vendor", type="string")
     */
    private $vendor;

    /**
     * @var string
     *
     * @ES\Property(name="manufacturer", type="string")
     */
    private $manufacturer;

    /**
     * @var string[]
     *
     * @ES\Property(name="categories", type="string")
     */
    private $categories;

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
    private $attributes;

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function getActive()
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
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     *
     * @return $this
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     *
     * @return $this
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return int[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param int[] $categories
     *
     * @return $this
     */
    public function setCategories($categories = null)
    {
        $this->categories = $categories;

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
    public function setAttributes($attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     *
     * @return $this
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }
}
