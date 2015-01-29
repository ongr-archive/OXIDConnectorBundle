<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Modifier\Traits;

use ONGR\OXIDConnectorBundle\Modifier\Traits\ShopAwareTrait;

class ShopAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShopAwareTrait
     */
    private $shopAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->shopAwareTrait = $this
            ->getObjectForTrait('ONGR\OXIDConnectorBundle\Modifier\Traits\ShopAwareTrait');
    }

    /**
     * Testing that trait has empty value.
     */
    public function testTraitIsEmpty()
    {
        $this->assertAttributeEmpty('shopId', $this->shopAwareTrait);
    }

    /**
     * Test LanguageId setter and getter.
     */
    public function testSetLanguageId()
    {
        $this->shopAwareTrait->setShopId(1);

        $this->assertEquals(1, $this->shopAwareTrait->getShopId());
    }
}
