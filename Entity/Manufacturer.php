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
 * Entity for table "oxmanufacturers".
 *
 * @ORM\MappedSuperclass
 */
abstract class Manufacturer
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
     * @var bool
     *
     * @ORM\Column(name="OXACTIVE", type="boolean")
     */
    protected $active;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTITLE@lang_tag", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="OXSHORTDESC@lang_tag", type="string")
     */
    protected $shortDesc;

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return Manufacturer
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
     * Sets activity state.
     *
     * @param bool $active
     *
     * @return Manufacturer
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Checks if manufacturer is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets title.
     *
     * @param string $title
     *
     * @return Manufacturer
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
     * @return Manufacturer
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
}
