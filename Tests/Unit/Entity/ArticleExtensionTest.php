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

class ArticleExtensionTest extends AbstractEntityTest
{
    /**
     * {@inheritDoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['longDesc'],
            ['tags'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return 'ONGR\OXIDConnectorBundle\Entity\ArticleExtension';
    }
}
