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

use ONGR\TestingBundle\Document\Category as CategoryDocument;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\CategoryToAttribute;
use ONGR\OXIDConnectorBundle\Modifier\CategoryModifier;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Attribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected
 */
class CategoryModifierTest extends TestBase
{
    /**
     * test modification
     */
    public function testModify()
    {
        $expectedEntity1 = new CategoryDocument();
        $expectedEntity1->id = 'fada9485f003c731b7fad08b873214e0';
        $expectedEntity1->active = true;
        $expectedEntity1->hidden = true;
        $expectedEntity1->left = 4;
        $expectedEntity1->right = 5;
        $expectedEntity1->parentid = 'fad2d80baf7aca6ac54e819e066f24aa';
        $expectedEntity1->rootid = '30e44ab83fdee7564.23264141';
        $expectedEntity1->sort = 3010101;
        $expectedEntity1->title = 'BestCategory';
        $expectedEntity1Attribute = new Attribute();
        $expectedEntity1Attribute->setTitle('testAttribute');

        $expectedEntity2 = new CategoryDocument();
        $expectedEntity2->id = '0f41a4463b227c437f6e6bf57b1697c4';
        $expectedEntity2->active = false;
        $expectedEntity2->hidden = false;
        $expectedEntity2->left = 6;
        $expectedEntity2->right = 7;
        $expectedEntity2->parentid = 'fada9485f003c731b7fad08b873214e0';
        $expectedEntity2->rootid = '943a9ba3050e78b443c16e043ae60ef3';
        $expectedEntity2->sort = 103;
        $expectedEntity2->title = 'Trapeze';

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        /** @var Category[] $categoryItems */
        $categoryItems = $this->getTestElements(
            ['fada9485f003c731b7fad08b873214e0', '0f41a4463b227c437f6e6bf57b1697c4'],
            'ONGROXIDConnectorBundleTest:Category'
        );
        $this->assertCount(2, $categoryItems);

        //test if we have the correct attribute
        /** @var CategoryToAttribute[] $categoryToAttribute */
        $categoryToAttribute = $categoryItems[0]->getAttributes();
        $this->assertEquals($expectedEntity1Attribute->getTitle(), $categoryToAttribute[0]->getAttribute()->getTitle());

        $modifier = new CategoryModifier();

        foreach ($expectedEntities as $key => $expectedEntity) {
            $createdCategory = new CategoryDocument();
            $modifier->modify($createdCategory, $categoryItems[$key]);
            $this->assertEquals($createdCategory, $expectedEntity);
        }
    }
}
