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
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Document\VariantObject;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Service\SeoFinder;
use ONGR\OXIDConnectorBundle\Tests\Functional\AbstractTestCase;

/**
 * Tests if product modifier works as expected.
 */
class ProductModifierTest extends AbstractTestCase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        // Non-existant product in db.
        $expectedProduct1 = new ProductDocument();
        $expectedProduct1->setId('6b698c33118caee4ca0882c33f513d2f');
        $expectedProduct1->setActive(true);
        $expectedProduct1->setSku('85-8573-846-1-4-3');
        $expectedProduct1->setTitle('PRODUCT NO. 1');
        $expectedProduct1->setDescription('Product number one for testing');
        $expectedProduct1->setPrice(25.5);
        $expectedProduct1->setOldPrice(36.7);
        $expectedProduct1->setManufacturer(null);
        $expectedProduct1->setLongDescription(null);
        $expectedProduct1->setVendor(null);
        $expectedProduct1->setStock(5);
        $expectedProduct1->setAttributes([]);
        $expectedProduct1->setUrls(new \ArrayIterator());
        $expectedProduct1->setExpiredUrls([]);

        $expectedProduct2 = new VariantObject();
        $expectedProduct2->setId('6b6a6aedca3e438e98d51f0a5d586c0b');
        $expectedProduct2->setActive(false);
        $expectedProduct2->setSku('0702-85-853-9-2');
        $expectedProduct2->setTitle('PRODUCT NO. 2');
        $expectedProduct2->setDescription('Product number two for testing');
        $expectedProduct2->setPrice(46.6);
        $expectedProduct2->setOldPrice(35.7);
        $expectedProduct2->setLongDescription('Product number two description for testing from extension');
        $expectedProduct2->setStock(2);
        $expectedProduct2->setAttributes([]);

        $expectedProduct1->setVariants([$expectedProduct2]);

        $expectedEntities = [$expectedProduct1];

        $productItems = $this->getTestElements(
            ['6b698c33118caee4ca0882c33f513d2f', '6b6a6aedca3e438e98d51f0a5d586c0b'],
            'ONGROXIDConnectorBundleTest:Article'
        );
        $this->assertCount(2, $productItems);

        $seoFinder = new SeoFinder();
        $seoFinder->setEntityManager($this->getEntityManager());
        $seoFinder->setShopId(0);
        $seoFinder->setRepository('ONGROXIDConnectorBundleTest:Seo');

        $modifier = new ProductModifier(new AttributesToDocumentsService());
        $modifier->setSeoFinderService($seoFinder);

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        foreach ($expectedEntities as $key => $expectedProduct) {
            $actualProduct = new ProductDocument();
            $modifier->modify(new ImportItem($productItems[$key], $actualProduct), $event);
            $this->assertEquals($expectedProduct, $actualProduct);
        }
    }
}
