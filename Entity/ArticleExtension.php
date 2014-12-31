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
 * Entity for table "oxartextends".
 *
 * @ORM\MappedSuperclass
 */
abstract class ArticleExtension
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
     * @ORM\Column(name="OXLONGDESC", type="text")
     */
    protected $longDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="OXTAGS", type="string")
     */
    protected $tags;

    /**
     * Sets object ID.
     *
     * @param string $id
     *
     * @return ArticleExtension
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
     * Sets long description.
     *
     * @param string $description
     *
     * @return ArticleExtension
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
     * Sets tags.
     *
     * @param string $tags
     *
     * @return ArticleExtension
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Returns tags.
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }
}
