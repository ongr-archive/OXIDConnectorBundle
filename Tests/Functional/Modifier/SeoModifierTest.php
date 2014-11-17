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

use ONGR\TestingBundle\Document\Product;
use ONGR\OXIDConnectorBundle\Modifier\SeoModifier;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected.
 */
class SeoModifierTest extends TestBase
{
    /**
     * Data provider for testModify.
     *
     * @return array
     */
    public function testModifyData()
    {
        // Case #0 test with no shop id and language set.
        $expectedEntity1 = new Product();
        $expectedEntity1->metaKeywords = 'testKeywords For Product 1 in language 1';
        $expectedEntity1->metaDescription = 'testDescription For Product 1 in language 1';

        $expectedEntity2 = new Product();
        $expectedEntity2->metaKeywords = 'testKeywords For Product 2 in language 0';
        $expectedEntity2->metaDescription = 'testDescription For Product 2 in language 0';

        $out[] = [[$expectedEntity1, $expectedEntity2]];

        // Case #1 test with shop id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->metaKeywords = 'testKeywords For Product 1 in language 0';
        $expectedEntity1->metaDescription = 'testDescription For Product 1 in language 0';

        $expectedEntity2 = new Product();
        $expectedEntity2->metaKeywords = 'testKeywords For Product 2 in language 0';
        $expectedEntity2->metaDescription = 'testDescription For Product 2 in language 0';

        $out[] = [[$expectedEntity1, $expectedEntity2], 1];

        // Case #2 test with language id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->metaKeywords = 'testKeywords For Product 1 in language 1';
        $expectedEntity1->metaDescription = 'testDescription For Product 1 in language 1';

        $expectedEntity2 = new Product();
        $expectedEntity2->metaKeywords = null;
        $expectedEntity2->metaDescription = null;

        $out[] = [[$expectedEntity1, $expectedEntity2], null, 1];

        // Case #3 test with language id and shop id set.
        $expectedEntity1 = new Product();
        $expectedEntity1->metaKeywords = null;
        $expectedEntity1->metaDescription = null;

        $expectedEntity2 = new Product();
        $expectedEntity2->metaKeywords = null;
        $expectedEntity2->metaDescription = null;

        $out[] = [[$expectedEntity1, $expectedEntity2], 1, 1];

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
            ['6b698c33118caee4ca0882c33f513d2f', '6b6a6aedca3e438e98d51f0a5d586c0b'],
            'ONGROXIDConnectorBundleTest:Article'
        );
        $this->assertCount(2, $productItems);

        $modifier = new SeoModifier($this->getEntityManager());
        $modifier->setEntityAlias('ONGROXIDConnectorBundleTest');
        $modifier->setShopId($shopId);
        $modifier->setLanguageId($languageId);

        foreach ($expectedEntities as $key => $expectedEntity) {
            $createdProduct = new Product();
            $modifier->modify($createdProduct, $productItems[$key]);
            $this->assertEquals($expectedEntity->metaKeywords, $createdProduct->metaKeywords);
            $this->assertEquals($expectedEntity->metaDescription, $createdProduct->metaDescription);
        }
    }
}
