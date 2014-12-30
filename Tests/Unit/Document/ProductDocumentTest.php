<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Document;

use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;

class ProductDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProductDocument
     */
    private $document;

    /**
     * Set up document for testing.
     */
    protected function setUp()
    {
        $this->document = new ProductDocument();
    }

    /**
     * Test getters and setters.
     */
    public function testGettersAndSetters()
    {
        $this->document
            ->setActive(true)
            ->setOldPrice(20.50)
            ->setStock(10)
            ->setVendor('testVendor')
            ->setManufacturer('testManufacturer')
            ->setCategories([1, 3, 2]);
        $expectedAttributes = [];
        $expectedAttributes[0] = new AttributeObject();
        $expectedAttributes[0]->setPos(1);
        $expectedAttributes[0]->setTitle('testTitle1');
        $this->document->setAttributes($expectedAttributes);

        $this->assertEquals(true, $this->document->isActive());
        $this->assertEquals(20.50, $this->document->getOldPrice());
        $this->assertEquals(10, $this->document->getStock());
        $this->assertEquals('testVendor', $this->document->getVendor());
        $this->assertEquals('testManufacturer', $this->document->getManufacturer());
        $this->assertEquals([1, 3, 2], $this->document->getCategories());

        $actualAttributes = $this->document->getAttributes();
        foreach ($actualAttributes as $idx => $actualAttribute) {
            $this->assertSame($expectedAttributes[$idx], $actualAttribute);
        }

        $this->document
            ->setAttributes(null)
            ->setCategories(null);
        $this->assertEquals([], $this->document->getAttributes());
        $this->assertEquals([], $this->document->getCategories());
    }
}
