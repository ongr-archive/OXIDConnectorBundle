<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Functional\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * This class contains tests to find out if services are defined correctly.
 */

class ServiceCreationTest extends WebTestCase
{
    /**
     * Tests if services are defined correctly.
     *
     * @param string $service
     * @param string $instance
     *
     * @dataProvider getTestServiceCreationData()
     */
    public function testServiceCreation($service, $instance)
    {
        $container = self::createClient()->getContainer();

        $this->assertTrue($container->has($service));
        $this->assertInstanceOf($instance, $container->get($service));
    }

    /**
     * Data provider for testServiceCreation().
     *
     * @return array[]
     */
    public function getTestServiceCreationData()
    {
        $out = [];

        // Case #0: DB mapping listener.
        $out[] = ['ongr_oxid.mapping_listener', 'ONGR\ConnectionsBundle\EventListener\LoadClassMetadataListener'];

        // Case #1: Product modifier.
        $out[] = ['ongr_oxid.modifier.product', 'ONGR\OXIDConnectorBundle\Modifier\ProductModifier'];

        // Case #2: Product SEO modifier.
        $out[] = ['ongr_oxid.modifier.product_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];

        // Case #3: Product SEO URL modifier.
        $out[] = ['ongr_oxid.modifier.product_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];

        // Case #4: Category modifier.
        $out[] = ['ongr_oxid.modifier.category', 'ONGR\OXIDConnectorBundle\Modifier\CategoryModifier'];

        // Case #5: Category SEO modifier.
        $out[] = ['ongr_oxid.modifier.category_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];

        // Case #6: Category SEO URL modifier.
        $out[] = ['ongr_oxid.modifier.category_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];

        // Case #7: Content modifier.
        $out[] = ['ongr_oxid.modifier.content', 'ONGR\OXIDConnectorBundle\Modifier\ContentModifier'];

        // Case #8: Content SEO modifier.
        $out[] = ['ongr_oxid.modifier.content_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];

        // Case #9: Content SEO URL modifier.
        $out[] = ['ongr_oxid.modifier.content_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];

        return $out;
    }
}
