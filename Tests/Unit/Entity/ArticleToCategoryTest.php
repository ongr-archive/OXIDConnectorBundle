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

class ArticleToCategoryTest extends ObjectToCategoryTest
{
    /**
     * {@inheritDoc}
     */
    public function getFieldsData()
    {
        $fields = parent::getFieldsData();
        $fields[] = ['article', 'ONGR\OXIDConnectorBundle\Entity\Article'];

        return $fields;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return 'ONGR\OXIDConnectorBundle\Entity\ArticleToCategory';
    }
}
