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

use ONGR\ContentBundle\Document\AbstractCategoryDocument;
use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Category document.
 *
 * @ES\Document(type="category", create=false)
 */
class CategoryDocument extends AbstractCategoryDocument
{
    /**
     * @var string
     *
     * @ES\Property(name="root_id", type="string")
     */
    protected $rootId;

    /**
     * @var string
     *
     * @ES\Property(name="description", type="string")
     */
    protected $description;

    /**
     * @var string
     *
     * @ES\Property(name="description", type="string")
     */
    protected $longDescription;

    /**
     * @var AttributeObject[]
     *
     * @ES\Property(
     *     name="attributes",
     *     objectName="ONGROXIDConnectorBundle:AttributeObject",
     *     multiple=true,
     *     type="object"
     * )
     */
    protected $attributes;

    /**
     * @return mixed
     */
    public function getRootId()
    {
        return $this->rootId;
    }

    /**
     * @param string $rootId
     *
     * @return $this
     */
    public function setRootId($rootId)
    {
        $this->rootId = $rootId;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $longDescription
     *
     * @return $this
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * @return AttributeObject[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param AttributeObject[] $attributes
     *
     * @return $this
     */
    public function setAttributes($attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
