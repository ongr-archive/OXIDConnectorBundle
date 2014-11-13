<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Entity;

use ONGR\ConnectionsBundle\Tests\Unit\Entity\AbstractEntityTest;

/**
 * Contains tests for CategoryToAttribute setters and getters
 */
class CategoryToAttributeTest extends AbstractEntityTest
{
    /**
     * {@inheritDoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['category', 'ONGR\OXIDConnectorBundle\Entity\Category'],
            ['attribute', 'ONGR\OXIDConnectorBundle\Entity\Attribute'],
            ['sort']
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return 'ONGR\OXIDConnectorBundle\Entity\CategoryToAttribute';
    }
}
