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

use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
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
        $expected1 = new ProductDocument();
        $expected1->setId('6b698c33118caee4ca0882c33f513d2f');
        $expected1->setActive(true);
        $expected1->setSku('85-8573-846-1-4-3');
        $expected1->setTitle('PRODUCT NO. 1');
        $expected1->setDescription('Product number one for testing');
        $expected1->setPrice(25.5);
        $expected1->setOldPrice(36.7);
        $expected1->setManufacturer(null);
        $expected1->setLongDescription(null);
        $expected1->setVendor(null);
        $expected1->setParentId('oxrootid');
        $expected1->setStock(5.0);
        $expected1->setAttributes([]);

        $expected2 = new ProductDocument();
        $expected2->setId('6b6a6aedca3e438e98d51f0a5d586c0b');
        $expected2->setActive(false);
        $expected2->setSku('0702-85-853-9-2');
        $expected2->setTitle('PRODUCT NO. 2');
        $expected2->setDescription('Product number two for testing');
        $expected2->setPrice(46.6);
        $expected2->setOldPrice(35.7);
        $expected2->setManufacturer('Naish');
        $expected2->setLongDescription('Product number two description for testing from extension');
        $expected2->setVendor('Vendor Title for PRODUCT TWO');
        $expected2->setParentId('6b698c33118caee4ca0882c33f513d2f');
        $expected2->setStock(2);
        $expected2->setCategories(['fada9485f003c731b7fad08b873214e0']);
        $expected2->setAttributes([]);

        $expectedEntities = [$expected1, $expected2];

        $productItems = $this->getTestElements(
            ['6b698c33118caee4ca0882c33f513d2f', '6b6a6aedca3e438e98d51f0a5d586c0b'],
            'ONGROXIDConnectorBundleTest:Article'
        );
        $this->assertCount(2, $productItems);

        $modifier = new ProductModifier(new AttributesToDocumentsService());
        foreach ($expectedEntities as $key => $expectedProduct) {
            $actualProduct = new ProductDocument();
            $modifier->modify(new ImportItem($productItems[$key], $actualProduct));
            $this->assertEquals($expectedProduct, $actualProduct);
        }
    }
}
