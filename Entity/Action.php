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
 * Entity for table "oxactions".
 *
 * @ORM\MappedSuperclass
 */
abstract class Action
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
     * @ORM\Column(name="OXTYPE", type="smallint")
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTITLE", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="OXLONGDESC", type="text")
     */
    protected $longDesc;

    /**
     * @var bool
     *
     * @ORM\Column(name="OXACTIVE", type="boolean")
     */
    protected $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="OXACTIVEFROM", type="datetime")
     */
    protected $activeFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="OXACTIVETO", type="datetime")
     */
    protected $activeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="OXPIC", type="string")
     */
    protected $pic;

    /**
     * @var string
     *
     * @ORM\Column(name="OXLINK", type="string")
     */
    protected $link;

    /**
     * @var int
     *
     * @ORM\Column(name="OXSORT", type="integer")
     */
    protected $sort;

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return Action
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
     * Sets type.
     *
     * @param int $type
     *
     * @return Action
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return Action
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
     * Sets long description.
     *
     * @param string $description
     *
     * @return Action
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
     * Sets activity state.
     *
     * @param bool $active
     *
     * @return Action
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
     * Sets the date action is active from.
     *
     * @param \DateTime $activeFrom
     *
     * @return Action
     */
    public function setActiveFrom(\DateTime $activeFrom = null)
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    /**
     * Returns the date action is active from.
     *
     * @return \DateTime
     */
    public function getActiveFrom()
    {
        return $this->activeFrom;
    }

    /**
     * Sets the date action is active to.
     *
     * @param \DateTime $activeTo
     *
     * @return Action
     */
    public function setActiveTo(\DateTime $activeTo = null)
    {
        $this->activeTo = $activeTo;

        return $this;
    }

    /**
     * Returns the date action is active to.
     *
     * @return \DateTime
     */
    public function getActiveTo()
    {
        return $this->activeTo;
    }

    /**
     * Sets picture.
     *
     * @param string $picture
     *
     * @return Action
     */
    public function setPic($picture)
    {
        $this->pic = $picture;

        return $this;
    }

    /**
     * Returns picture.
     *
     * @return string
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Sets link.
     *
     * @param string $link
     *
     * @return Action
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Returns link.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets sort order.
     *
     * @param int $sort
     *
     * @return Action
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
