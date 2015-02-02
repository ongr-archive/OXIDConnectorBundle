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

use ONGR\ContentBundle\Document\AbstractContentDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Content document.
 *
 * @ES\Document(type="content", create=false)
 */
class ContentDocument extends AbstractContentDocument
{
    /**
     * @var bool
     *
     * @ES\Property(name="snippet", type="boolean")
     */
    private $snippet;

    /**
     * @var int
     *
     * @ES\Property(name="type", type="integer")
     */
    private $type;

    /**
     * @var bool
     *
     * @ES\Property(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ES\Property(name="position", type="string")
     */
    private $position;

    /**
     * @var string
     *
     * @ES\Property(name="folder", type="string")
     */
    private $folder;

    /**
     * @return bool
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * @param bool $snippet
     *
     * @return $this
     */
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

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
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     *
     * @return $this
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }
}
