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
 * Entity for table "oxobject2attribute"
 *
 * @ORM\MappedSuperclass
 */
abstract class ObjectToAttribute
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
     * @var Attribute
     *
     * @ORM\OneToOne(targetEntity="Attribute")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXATTRID", referencedColumnName="OXID")
     * })
     */
    protected $attribute;

    /**
     * @var string
     *
     * @ORM\Column(name="OXVALUE", type="string")
     */
    protected $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="OXPOS", type="integer")
     */
    protected $pos;

    /**
     * Sets object ID
     *
     * @param string $id
     *
     * @return ObjectToAttribute
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
     * Sets mapped object ID
     *
     * @param string $objectId
     *
     * @return ObjectToAttribute
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Returns mapped object ID
     *
     * @return string
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Sets attribute
     *
     * @param Attribute $attribute
     *
     * @return ObjectToAttribute
     */
    public function setAttribute(Attribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Returns attribute
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Sets attribute value
     *
     * @param string $value
     *
     * @return ObjectToAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns attribute value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets position
     *
     * @param integer $position
     *
     * @return ObjectToAttribute
     */
    public function setPos($position)
    {
        $this->pos = $position;

        return $this;
    }

    /**
     * Returns position
     *
     * @return integer
     */
    public function getPos()
    {
        return $this->pos;
    }
}
