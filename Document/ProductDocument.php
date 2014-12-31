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

use ONGR\ContentBundle\Document\Traits\ProductTrait;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\ElasticsearchBundle\Document\DocumentTrait;

/**
 * Product document.
 *
 * @ES\Document(type="product")
 */
class ProductDocument implements DocumentInterface
{
    use DocumentTrait;
    use ProductTrait;

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
     * @var int[]|\Iterator
     *
     * @ES\Property(name="categories", type="array", multiple=true)
     */
    private $categories;

    /**
     * @var AttributeObject[]|\Iterator
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
     * @return int[]|\Iterator
     */
    public function getCategories()
    {
        if (empty($this->categories)) {
            return [];
        }

        return $this->categories;
    }

    /**
     * @param int[]|\Iterator $categories
     *
     * @return $this
     */
    public function setCategories(array $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return AttributeObject[]|\Iterator
     */
    public function getAttributes()
    {
        if (empty($this->attributes)) {
            return [];
        }

        return $this->attributes;
    }

    /**
     * @param AttributeObject[]|\Iterator $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
