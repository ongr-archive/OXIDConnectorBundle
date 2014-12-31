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
 * Entity for table "oxobject2category".
 *
 * @ORM\MappedSuperclass
 */
abstract class ObjectToCategory
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
     * @var string
     *
     * @ORM\Column(name="OXOBJECTID", type="string")
     */
    protected $objectId;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXCATNID", referencedColumnName="OXID")
     * })
     */
    protected $category;

    /**
     * @var int
     *
     * @ORM\Column(name="OXPOS", type="integer")
     */
    protected $pos;

    /**
     * @var int
     *
     * @ORM\Column(name="OXTIME", type="integer")
     */
    protected $time;

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return ObjectToCategory
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
     * Sets mapped object ID.
     *
     * @param string $objectId
     *
     * @return ObjectToCategory
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
     * Sets category object.
     *
     * @param string $category
     *
     * @return ObjectToCategory
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Returns category object.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets position.
     *
     * @param int $position
     *
     * @return ObjectToCategory
     */
    public function setPos($position)
    {
        $this->pos = $position;

        return $this;
    }

    /**
     * Returns position.
     *
     * @return int
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Sets time.
     *
     * @param int $time
     *
     * @return ObjectToCategory
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Returns time.
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }
}
