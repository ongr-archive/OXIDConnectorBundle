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

use Doctrine\ORM\EntityManager;
use ONGR\OXIDConnectorBundle\Modifier\SeoModifier;

class ShopAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test ShopId setter and getter
     */
    public function testSetShopId()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $seoModifier = new SeoModifier($entityManager);
        $this->assertNull($seoModifier->getShopId());

        $seoModifier->setShopId(3);
        $this->assertEquals(3, $seoModifier->getShopId());
    }
}
