<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\CategoryToAttribute;
use ONGR\OXIDConnectorBundle\Modifier\CategoryModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected.
 */
class CategoryModifierTest extends TestBase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        $expectedCategory1 = new CategoryDocument();
        $expectedCategory1->setId('fada9485f003c731b7fad08b873214e0');
        $expectedCategory1->setActive(true);
        $expectedCategory1->setHidden(true);
        $expectedCategory1->setLeft(4);
        $expectedCategory1->setRight(5);
        $expectedCategory1->setParentId('fad2d80baf7aca6ac54e819e066f24aa');
        $expectedCategory1->setRootId('30e44ab83fdee7564.23264141');
        $expectedCategory1->setSort(3010101);
        $expectedCategory1->setTitle('BestCategory');
        $expectedCategory1->setDescription('Description 1');
        $attribute = new AttributeObject();
        $attribute->setPos(9999);
        $attribute->setTitle('testAttribute');
        $expectedCategory1->setAttributes([$attribute]);

        $expectedCategory2 = new CategoryDocument();
        $expectedCategory2->setId('0f41a4463b227c437f6e6bf57b1697c4');
        $expectedCategory2->setActive(false);
        $expectedCategory2->setHidden(false);
        $expectedCategory2->setLeft(6);
        $expectedCategory2->setRight(7);
        $expectedCategory2->setParentId('fada9485f003c731b7fad08b873214e0');
        $expectedCategory2->setRootId('943a9ba3050e78b443c16e043ae60ef3');
        $expectedCategory2->setSort(103);
        $expectedCategory2->setTitle('Trapeze');
        $expectedCategory2->setDescription('Description 2');
        $expectedCategory2->setAttributes([]);

        $expectedCategories = [$expectedCategory1, $expectedCategory2];

        /** @var Category[] $categoryItems */
        $categoryItems = $this->getTestElements(
            ['fada9485f003c731b7fad08b873214e0', '0f41a4463b227c437f6e6bf57b1697c4'],
            'ONGROXIDConnectorBundleTest:Category'
        );
        $this->assertCount(2, $categoryItems);

        // Test if we have the correct attribute.
        /** @var CategoryToAttribute[] $categoryToAttribute */
        $categoryToAttribute = $categoryItems[0]->getAttributes();
        $this->assertEquals($attribute->getTitle(), $categoryToAttribute[0]->getAttribute()->getTitle());

        $modifier = new CategoryModifier(new AttributesToDocumentsService());

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        foreach ($expectedCategories as $key => $expectedCategory) {
            $actualCategory = new CategoryDocument();
            $modifier->modify(new ImportItem($categoryItems[$key], $actualCategory), $event);
            $this->assertEquals($expectedCategory, $actualCategory);
        }
    }
}
