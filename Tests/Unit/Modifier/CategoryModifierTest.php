<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Modifier;

use ONGR\OXIDConnectorBundle\Document\Category as CategoryDocument;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Modifier\CategoryModifier;

class CategoryModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify().
     */
    public function testModify()
    {
        $modifier = new CategoryModifier();

        /** @var Category $root */
        $root = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $root->setId('testIdRoot');

        /** @var Category $parent */
        $parent = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $parent->setId('testIdParent');

        /** @var Category $category */
        $category = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $category
            ->setId('testId')
            ->setActive(true)
            ->setHidden(false)
            ->setTitle('testTitle')
            ->setSort(3)
            ->setRoot($root)
            ->setParent($parent)
            ->setRight(501)
            ->setLeft(102);

        $expectedDocument = new CategoryDocument();
        $expectedDocument->id = 'testId';
        $expectedDocument->active = true;
        $expectedDocument->hidden = false;
        $expectedDocument->title = 'testTitle';
        $expectedDocument->sort = 3;
        $expectedDocument->rootid = 'testIdRoot';
        $expectedDocument->parentid = 'testIdParent';
        $expectedDocument->left = 102;
        $expectedDocument->right = 501;

        $document = new CategoryDocument();
        $modifier->modify($document, $category);

        $this->assertEquals($expectedDocument, $document);
    }
}
