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
 * Entity for table "oxcategories".
 *
 * @ORM\MappedSuperclass
 */
class Category
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXPARENTID", referencedColumnName="OXID")
     * })
     */
    protected $parent;

    /**
     * @var int
     *
     * @ORM\Column(name="OXLEFT", type="integer")
     */
    protected $left;

    /**
     * @var int
     *
     * @ORM\Column(name="OXRIGHT", type="integer")
     */
    protected $right;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXROOTID", referencedColumnName="OXID")
     * })
     */
    protected $root;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSORT", type="integer")
     */
    protected $sort;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXACTIVE", type="boolean")
     */
    protected $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXHIDDEN", type="boolean")
     */
    protected $hidden;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTITLE@lang_tag", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="OXDESC@lang_tag", type="string")
     */
    protected $desc;

    /**
     * @var string
     *
     * @ORM\Column(name="OXLONGDESC@lang_tag", type="text")
     */
    protected $longDesc;

    /**
     * @var Category[]
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
     * @var CategoryToAttribute[]
     *
     * @ORM\OneToMany(targetEntity="CategoryToAttribute", mappedBy="category")
     * @ORM\OrderBy({"sort"="ASC"})
     */
    protected $attributes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return Category
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
     * Sets parent category.
     *
     * @param Category $parent
     *
     * @return Category
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Returns parent category.
     *
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets left position number.
     *
     * @param int $left
     *
     * @return Category
     */
    public function setLeft($left)
    {
        $this->left = $left;

        return $this;
    }

    /**
     * Returns left position number.
     *
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * Sets right position number.
     *
     * @param int $right
     *
     * @return Category
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Returns right position number.
     *
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Returns attributes.
     *
     * @return CategoryToAttribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets attributes.
     *
     * @param CategoryToAttribute[] $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Adds attribute.
     *
     * @param CategoryToAttribute $attribute
     *
     * @return Category
     */
    public function addAttribute(CategoryToAttribute $attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * Removes attribute.
     *
     * @param CategoryToAttribute $attribute
     *
     * @return Category
     */
    public function removeAttribute(CategoryToAttribute $attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * Sets root category.
     *
     * @param Category $root
     *
     * @return Category
     */
    public function setRoot(Category $root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Returns root category.
     *
     * @return Category
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Sets sort order.
     *
     * @param int $sort
     *
     * @return Category
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
     * Sets activity state.
     *
     * @param bool $active
     *
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Checks if category is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets visibility state.
     *
     * @param bool $hidden
     *
     * @return Category
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Checks if category is hidden.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return Category
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
     * Sets description.
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDesc($description)
    {
        $this->desc = $description;

        return $this;
    }

    /**
     * Returns description.
     *
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * Sets long description.
     *
     * @param string $description
     *
     * @return Category
     */
    public function setLongDesc($description)
    {
        $this->longDesc = $description;

        return $this;
    }

    /**
     * Returns long description.
     *
     * @return string
     */
    public function getLongDesc()
    {
        return $this->longDesc;
    }

    /**
     * Returns children categories.
     *
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Sets children categories.
     *
     * @param Category[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * Adds child category.
     *
     * @param Category $category
     *
     * @return Category
     */
    public function addChild(Category $category)
    {
        $this->children->add($category);

        return $this;
    }

    /**
     * Removes child category.
     *
     * @param Category $category
     *
     * @return Category
     */
    public function removeChild(Category $category)
    {
        $this->children->removeElement($category);

        return $this;
    }
}
