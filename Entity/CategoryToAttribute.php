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
 * Entity for table "oxcategory2attribute".
 *
 * @ORM\MappedSuperclass
 */
class CategoryToAttribute
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="attributes")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXOBJECTID", referencedColumnName="OXID")
     * })
     */
    protected $category;

    /**
     * @var Attribute
     *
     * @ORM\OneToOne(targetEntity="Attribute")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXATTRID", referencedColumnName="OXID")
     * })
     */
    protected $attribute;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSORT", type="integer")
     */
    protected $sort;

    /**
     * Sets CategoryToAttribute ID.
     *
     * @param string $id
     *
     * @return CategoryToAttribute
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns CategoryToAttribute ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Category.
     *
     * @param Category $category
     *
     * @return CategoryToAttribute
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Returns Category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets attribute.
     *
     * @param Attribute $attribute
     *
     * @return CategoryToAttribute
     */
    public function setAttribute(Attribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Returns attribute.
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Sets sort order.
     *
     * @param int $sort
     *
     * @return CategoryToAttribute
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
}
