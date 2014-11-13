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

class CategoryTest extends AbstractEntityTest
{
    /**
     * {@inheritDoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['parent', 'ONGR\OXIDConnectorBundle\Entity\Category'],
            ['left'],
            ['right'],
            ['root', 'ONGR\OXIDConnectorBundle\Entity\Category'],
            ['sort'],
            ['active', 'boolean'],
            ['hidden', 'boolean'],
            ['title'],
            ['desc'],
            ['longDesc'],
            ['children', 'ONGR\OXIDConnectorBundle\Entity\Category', 'addChild', 'removeChild'],
            ['attributes', 'ONGR\OXIDConnectorBundle\Entity\CategoryToAttribute', 'addAttribute', 'removeAttribute'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return 'ONGR\OXIDConnectorBundle\Entity\Category';
    }
}
