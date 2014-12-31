<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Entity\Attribute;
use ONGR\OXIDConnectorBundle\Entity\CategoryToAttribute;
use ONGR\OXIDConnectorBundle\Entity\ObjectToAttribute;

/**
 * Service to transform array of "*ToAttribute" into "AttributeObject" array.
 */
class AttributesToDocumentsService
{
    /**
     * Worker method.
     *
     * @param array $attributes
     *
     * @return AttributeObject[]
     */
    public function transform($attributes)
    {
        $result = [];

        if (!$attributes instanceof \Traversable) {
            return $result;
        }

        /** @var ObjectToAttribute|CategoryToAttribute $attr */
        foreach ($attributes as $attr) {
            /** @var Attribute $attrEntity */
            $attrEntity = $attr->getAttribute();
            $attrObj = new AttributeObject();
            $attrObj->setTitle($attrEntity->getTitle());
            $attrObj->setPos($attrEntity->getPos());
            $result[] = $attrObj;
        }

        return $result;
    }
}
