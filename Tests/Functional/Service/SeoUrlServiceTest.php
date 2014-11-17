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

use ONGR\OXIDConnectorBundle\Service\SeoUrlService;
use ONGR\TestingBundle\Document\Product;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected.
 */
class SeoUrlServiceTest extends TestBase
{
    /**
     * Test data fpr testModify().
     *
     * @return array
     */
    public function testModifyData()
    {
        // Case #0 test with no shop id and language set.
        $expectedEntity1 = new Product();
        $expectedEntity1->url = [
            ['url' => 'test/url/for/product1/number/one', 'key' => 'product1Key'],
            ['url' => 'test/url/for/product1/number/two', 'key' => 'product2Key'],
        ];
        $expectedEntity1->expired_url = ['b0b4d221756c80afdad8904c0b91b877', '8b831f739c5d16cf4571b14a76006528'];

        $out[] = [[$expectedEntity1]];

        // Case #1 test with shop id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->url = [
            ['url' => 'test/url/for/product1/number/one', 'key' => 'product1Key'],
        ];
        $expectedEntity1->expired_url = ['8b831f739c5d16cf4571b14a76006528'];

        $out[] = [[$expectedEntity1], 1];

        // Case #2 test with language id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->url = [
            ['url' => 'test/url/for/product1/number/two', 'key' => 'product2Key'],
        ];
        $expectedEntity1->expired_url = ['b0b4d221756c80afdad8904c0b91b877'];

        $out[] = [[$expectedEntity1], null, 1];

        // Case #3 test with language id and shop id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->url = [];
        $expectedEntity1->expired_url = [];

        $out[] = [[$expectedEntity1], 1, 1];

        return $out;
    }

    /**
     * Test modification.
     *
     * @param array $expectedEntities
     * @param int   $shopId
     * @param int   $languageId
     *
     * @dataProvider testModifyData()
     */
    public function testModify(array $expectedEntities, $shopId = null, $languageId = null)
    {
        $productItems = $this->getTestElements(
            ['6b698c33118caee4ca0882c33f513d2f'],
            'ONGROXIDConnectorBundleTest:Article'
        );
        $this->assertCount(1, $productItems);

        $service = new SeoUrlService($this->getEntityManager());
        $service->setEntityAlias('ONGROXIDConnectorBundleTest');
        $service->setLanguageId($languageId);
        $service->setShopId($shopId);

        foreach ($expectedEntities as $key => $expectedEntity) {
            $this->assertEquals($expectedEntity->url, $service->getActiveUrlList($productItems[$key]));
            $this->assertEquals($expectedEntity->expired_url, $service->getSeoHistoryHashes($productItems[$key]));
        }
    }
}
