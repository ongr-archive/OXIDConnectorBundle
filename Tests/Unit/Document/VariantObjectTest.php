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
use ONGR\OXIDConnectorBundle\Document\VariantObject;

class VariantObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setters.
     */
    public function testGettersAndSetters()
    {
        $variant = new VariantObject();
        $attribute = new AttributeObject();

        $variant
            ->setId('id')
            ->setActive(false)
            ->setPrice(1.0)
            ->setAttributes([$attribute])
            ->setDescription('Description.')
            ->setLongDescription('Long description.')
            ->setOldPrice(2.1)
            ->setSku('sku')
            ->setStock(5)
            ->setTitle('Title');

        $this->assertEquals('id', $variant->getId());
        $this->assertEquals(false, $variant->isActive());
        $this->assertEquals(1.0, $variant->getPrice());
        $this->assertSame([$attribute], $variant->getAttributes());
        $this->assertEquals('Description.', $variant->getDescription());
        $this->assertEquals('Long description.', $variant->getLongDescription());
        $this->assertEquals(2.1, $variant->getOldPrice());
        $this->assertEquals('sku', $variant->getSku());
        $this->assertEquals(5, $variant->getStock());
        $this->assertEquals('Title', $variant->getTitle());
    }
}
