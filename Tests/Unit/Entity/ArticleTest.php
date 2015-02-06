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

class ArticleTest extends AbstractEntityTest
{
    /**
     * {@inheritdoc}
     */
    public function getFieldsData()
    {
        return [
            ['id'],
            ['shopId'],
            ['active', 'boolean'],
            ['artNum'],
            ['mpn'],
            ['title'],
            ['shortDesc'],
            ['price'],
            ['tPrice'],
            ['sort'],
            ['vendor', 'ONGR\OXIDConnectorBundle\Entity\Vendor'],
            ['manufacturer', 'ONGR\OXIDConnectorBundle\Entity\Manufacturer'],
            ['extension', 'ONGR\OXIDConnectorBundle\Entity\ArticleExtension'],
            ['categories', 'ONGR\OXIDConnectorBundle\Entity\ArticleToCategory', 'addCategory', 'removeCategory'],
            ['attributes', 'ONGR\OXIDConnectorBundle\Entity\ArticleToAttribute', 'addAttribute', 'removeAttribute'],
            ['parent', 'ONGR\OXIDConnectorBundle\Entity\Article'],
            ['variants', 'ONGR\OXIDConnectorBundle\Entity\Article'],
            ['stock'],
            ['stockFlag'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getIgnoredFields()
    {
        return ['seoUrls'];
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return 'ONGR\OXIDConnectorBundle\Entity\Article';
    }
}
