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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for table "oxarticles".
 *
 * @ORM\MappedSuperclass
 */
abstract class Article
{
    /**
     * @var string
     *
     * @ORM\Column(name="OXID", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSHOPID", type="integer")
     */
    protected $shopId;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXACTIVE", type="boolean")
     */
    protected $active;

    /**
     * @var string
     *
     * @ORM\Column(name="OXARTNUM", type="string")
     */
    protected $artNum;

    /**
     * @var string
     *
     * @ORM\Column(name="OXMPN", type="string")
     */
    protected $mpn;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTITLE", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="OXSHORTDESC", type="string")
     */
    protected $shortDesc;

    /**
     * @var float
     *
     * @ORM\Column(name="OXPRICE", type="float")
     */
    protected $price;

    /**
     * @var float
     *
     * @ORM\Column(name="OXTPRICE", type="float")
     */
    protected $tPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSORT", type="integer")
     */
    protected $sort;

    /**
     * @var Vendor
     *
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXVENDORID", referencedColumnName="OXID")
     * })
     */
    protected $vendor;

    /**
     * @var ArticleToAttribute[]
     *
     * @ORM\OneToMany(targetEntity="ArticleToAttribute", mappedBy="article")
     * @ORM\OrderBy({"pos"="ASC"})
     */
    protected $attributes;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXPARENTID", referencedColumnName="OXID")
     * })
     */
    protected $parent;

    /**
     * @var Manufacturer
     *
     * @ORM\ManyToOne(targetEntity="Manufacturer")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXMANUFACTURERID", referencedColumnName="OXID")
     * })
     */
    protected $manufacturer;

    /**
     * @var ArticleExtension
     *
     * @ORM\OneToOne(targetEntity="ArticleExtension")
     * @ORM\JoinColumn(name="OXID", referencedColumnName="OXID")
     */
    protected $extension;

    /**
     * @var ArticleToCategory[]
     *
     * @ORM\OneToMany(targetEntity="ArticleToCategory", mappedBy="article")
     * @ORM\OrderBy({"time"="ASC"})
     */
    protected $categories;

    /**
     * @var float
     *
     * @ORM\Column(name="OXSTOCK", type="float")
     */
    protected $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSTOCKFLAG", type="integer")
     */
    protected $stockFlag;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns object ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $shopId
     *
     * @return $this
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * Sets activity state.
     *
     * @param bool $active
     *
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Checks if article is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set article number.
     *
     * @param string $artNum
     *
     * @return Article
     */
    public function setArtNum($artNum)
    {
        $this->artNum = $artNum;

        return $this;
    }

    /**
     * Returns article number.
     *
     * @return string
     */
    public function getArtNum()
    {
        return $this->artNum;
    }

    /**
     * Sets manufacturer part number (MPN).
     *
     * @param string $mpn
     *
     * @return Article
     */
    public function setMpn($mpn)
    {
        $this->mpn = $mpn;

        return $this;
    }

    /**
     * Returns manufacturer part number (MPN).
     *
     * @return string
     */
    public function getMpn()
    {
        return $this->mpn;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets short description.
     *
     * @param string $shortDesc
     *
     * @return Article
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;

        return $this;
    }

    /**
     * Returns short description.
     *
     * @return string
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * Sets price.
     *
     * @param float $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Returns price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets old price.
     *
     * @param float $price
     *
     * @return Article
     */
    public function setTPrice($price)
    {
        $this->tPrice = $price;

        return $this;
    }

    /**
     * Returns old price.
     *
     * @return float
     */
    public function getTPrice()
    {
        return $this->tPrice;
    }

    /**
     * Sets sort order.
     *
     * @param int $sort
     *
     * @return Article
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Returns sort order.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Sets vendor.
     *
     * @param Vendor $vendor
     *
     * @return Article
     */
    public function setVendor(Vendor $vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Returns vendor.
     *
     * @return Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Sets manufacturer.
     *
     * @param Manufacturer $manufacturer
     *
     * @return Article
     */
    public function setManufacturer(Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Returns manufacturer.
     *
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Sets article extension object.
     *
     * @param ArticleExtension $extension
     *
     * @return Article
     */
    public function setExtension(ArticleExtension $extension = null)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Returns article extension object.
     *
     * @return ArticleExtension
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Returns categories.
     *
     * @return ArticleToCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets categories.
     *
     * @param ArticleToCategory[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Adds category.
     *
     * @param ArticleToCategory $category
     *
     * @return Article
     */
    public function addCategory(ArticleToCategory $category)
    {
        $this->categories->add($category);

        return $this;
    }

    /**
     * Removes category.
     *
     * @param ArticleToCategory $category
     *
     * @return Article
     */
    public function removeCategory(ArticleToCategory $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * Returns attributes.
     *
     * @return ArticleToAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets attributes.
     *
     * @param ArticleToAttribute[] $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Adds attribute.
     *
     * @param ArticleToAttribute $attribute
     *
     * @return Article
     */
    public function addAttribute(ArticleToAttribute $attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * Removes attribute.
     *
     * @param ArticleToAttribute $attribute
     *
     * @return Article
     */
    public function removeAttribute(ArticleToAttribute $attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * Sets parent.
     *
     * @param Article $parent
     *
     * @return Article
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Returns parent.
     *
     * @return Article
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets stock.
     *
     * @param float $stock
     *
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

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
     * Sets stockFlag.
     *
     * @param int $stockFlag
     *
     * @return Article
     */
    public function setStockFlag($stockFlag)
    {
        $this->stockFlag = $stockFlag;

        return $this;
    }

    /**
     * @return int
     */
    public function getStockFlag()
    {
        return $this->stockFlag;
    }
}
