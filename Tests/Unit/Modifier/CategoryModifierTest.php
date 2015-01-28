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

use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;
use ONGR\OXIDConnectorBundle\Modifier\CategoryModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Attribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\CategoryToAttribute;

class CategoryModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AttributesToDocumentsService
     */
    private $attributesToDocumentsService;

    /**
     * @var CategoryModifier
     */
    private $modifier;

    /**
     * Set up services for tests.
     */
    protected function setUp()
    {
        $this->attributesToDocumentsService = new AttributesToDocumentsService();
        $this->modifier = new CategoryModifier($this->attributesToDocumentsService);
    }

    /**
     * Test for modify().
     */
    public function testModify()
    {
        /** @var Category $root */
        $root = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $root->setId('testIdRoot');

        /** @var Category $parent */
        $parent = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $parent->setId('testIdParent');

        /** @var Category $category */
        $category = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');

        // Attribute to be added to Category.
        $attribute = new Attribute();
        $attribute->setId(123);
        $attribute->setPos(1);
        $attribute->setTitle('testAttributeTitle');
        $catToAttr = new CategoryToAttribute();
        $catToAttr->setId(321);
        $catToAttr->setSort(1);
        $catToAttr->setCategory($category);
        $catToAttr->setAttribute($attribute);

        $category
            ->setId('testId')
            ->setActive(true)
            ->setHidden(false)
            ->setTitle('testTitle')
            ->setDesc('testDescription')
            ->setLongDesc('testLongDescription')
            ->setSort(3)
            ->setRoot($root)
            ->setParent($parent)
            ->setRight(501)
            ->setLeft(102)
            ->addAttribute($catToAttr);

        /** @var CategoryDocument $expectedDocument */
        $expectedDocument = new CategoryDocument();
        $expectedDocument->setId('testId');
        $expectedDocument->setActive(true);
        $expectedDocument->setHidden(false);
        $expectedDocument->setTitle('testTitle');
        $expectedDocument->setDescription('testDescription');
        $expectedDocument->setLongDescription('testLongDescription');
        $expectedDocument->setSort(3);
        $expectedDocument->setRootId('testIdRoot');
        $expectedDocument->setParentId('testIdParent');
        $expectedDocument->setLeft(102);
        $expectedDocument->setRight(501);
        $attrObj = new AttributeObject();
        $attrObj->setPos(1);
        $attrObj->setTitle('testAttributeTitle');
        $expectedDocument->setAttributes([$attrObj]);

        $document = new CategoryDocument();
        $this->modifier->modify(new ImportItem($category, $document));

        $this->assertEquals($expectedDocument, $document);
    }
}
