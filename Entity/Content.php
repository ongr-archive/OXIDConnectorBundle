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
 * Entity for table "oxcontents"
 *
 * @ORM\MappedSuperclass
 */
abstract class Content
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
     * @ORM\Column(name="OXLOADID", type="string")
     */
    protected $loadId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OXSNIPPET", type="boolean")
     */
    protected $snippet;

    /**
     * @var integer
     *
     * @ORM\Column(name="OXTYPE", type="smallint")
     */
    protected $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OXACTIVE", type="boolean")
     */
    protected $active;

    /**
     * @var string
     *
     * @ORM\Column(name="OXPOSITION", type="string")
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTITLE", type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="OXCONTENT", type="text")
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(name="OXFOLDER", type="string")
     */
    protected $folder;

    /**
     * Sets object ID
     *
     * @param string $id
     *
     * @return Content
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns object ID
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets load ID
     *
     * @param string $loadId
     *
     * @return Content
     */
    public function setLoadId($loadId)
    {
        $this->loadId = $loadId;

        return $this;
    }

    /**
     * Returns load ID
     *
     * @return string
     */
    public function getLoadId()
    {
        return $this->loadId;
    }

    /**
     * Sets snippet indication
     *
     * @param boolean $snippet
     *
     * @return Content
     */
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
     * Checks if content is snippet
     *
     * @return boolean
     */
    public function isSnippet()
    {
        return $this->snippet;
    }

    /**
     * Sets type
     *
     * @param integer $type
     *
     * @return Content
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets activity state
     *
     * @param boolean $active
     *
     * @return Content
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Checks if article is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets position
     *
     * @param string $position
     *
     * @return Content
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Returns position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets title
     *
     * @param string $title
     *
     * @return Content
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets content
     *
     * @param string $content
     *
     * @return Content
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets folder
     *
     * @param string $folder
     *
     * @return Content
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Returns folder
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }
}
