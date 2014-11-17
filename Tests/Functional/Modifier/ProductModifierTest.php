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

use ONGR\OXIDConnectorBundle\Document\Product;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if product modifier works as expected.
 */
class ProductModifierTest extends TestBase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        // Non-existant category in db.
        $expectedEntity1 = new Product();
        $expectedEntity1->id = '6b698c33118caee4ca0882c33f513d2f';
        $expectedEntity1->active = true;
        $expectedEntity1->sku = '85-8573-846-1-4-3';
        $expectedEntity1->title = 'PRODUCT NO. 1';
        $expectedEntity1->description = 'Product number one for testing';
        $expectedEntity1->price = 25.5;
        $expectedEntity1->oldPrice = 36.7;
        $expectedEntity1->manufacturer = null;
        $expectedEntity1->longDescription = null;
        $expectedEntity1->vendor = null;
        $expectedEntity1->parentId = 'no-parent';
        $expectedEntity1->stock = 5;
        $expectedEntity1->categories = null;

        $expectedEntity2 = new Product();
        $expectedEntity2->id = '6b6a6aedca3e438e98d51f0a5d586c0b';
        $expectedEntity2->active = false;
        $expectedEntity2->sku = '0702-85-853-9-2';
        $expectedEntity2->title = 'PRODUCT NO. 2';
        $expectedEntity2->description = 'Product number two for testing';
        $expectedEntity2->price = 46.6;
        $expectedEntity2->oldPrice = 35.7;
        $expectedEntity2->manufacturer = 'Naish';
        $expectedEntity2->longDescription = 'Product number two description for testing from extension';
        $expectedEntity2->vendor = 'Vendor Title for PRODUCT TWO';
        $expectedEntity2->parentId = '6b698c33118caee4ca0882c33f513d2f';
        $expectedEntity2->stock = 2;
        $expectedEntity2->categories = ['fada9485f003c731b7fad08b873214e0'];

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        $productItems = $this->getTestElements(
            ['6b698c33118caee4ca0882c33f513d2f', '6b6a6aedca3e438e98d51f0a5d586c0b'],
            'ONGROXIDConnectorBundleTest:Article'
        );
        $this->assertCount(2, $productItems);

        $modifier = new ProductModifier();

        foreach ($expectedEntities as $key => $expectedEntity) {
            $createdProduct = new Product();
            $modifier->modify($createdProduct, $productItems[$key]);
            $this->assertEquals($createdProduct, $expectedEntity);
        }
    }
}
