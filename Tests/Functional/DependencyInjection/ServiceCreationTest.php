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
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class contains tests to find out if services are defined correctly.
 */

class ServiceCreationTest extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Return container instance.
     *
     * @return ContainerInterface
     */
    private function getContainer()
    {
        if (empty($this->container)) {
            $this->container = static::createClient()->getContainer();
        }

        return $this->container;
    }

    /**
     * Tests if services are defined correctly.
     *
     * @param string $serviceId
     * @param string $instance
     *
     * @dataProvider getTestServiceCreationData()
     */
    public function testServiceCreation($serviceId, $instance)
    {
        $container = $this->getContainer();
        $this->assertTrue($container->has($serviceId));
        $service = $container->get($serviceId);
        $this->assertInstanceOf($instance, $service);
    }

    /**
     * Data provider for testServiceCreation().
     *
     * @return array[]
     */
    public function getTestServiceCreationData()
    {
        $out = [];

        // DB mapping listener.
        $out[] = ['ongr_oxid.mapping_listener', 'ONGR\ConnectionsBundle\EventListener\LoadClassMetadataListener'];

        // Product modifier.
        $out[] = ['ongr_oxid.modifier.product', 'ONGR\OXIDConnectorBundle\Modifier\ProductModifier'];

        // Product SEO modifier.
        // $out[] = ['ongr_oxid.modifier.product_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];//.

        // Product SEO URL modifier.
        // $out[] = ['ongr_oxid.modifier.product_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];//.

        // Category modifier.
        $out[] = ['ongr_oxid.modifier.category', 'ONGR\OXIDConnectorBundle\Modifier\CategoryModifier'];

        // Category SEO modifier.
        // $out[] = ['ongr_oxid.modifier.category_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];//.

        // Category SEO URL modifier.
        // $out[] = ['ongr_oxid.modifier.category_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];//.

        // Content modifier.
        $out[] = ['ongr_oxid.modifier.content', 'ONGR\OXIDConnectorBundle\Modifier\ContentModifier'];

        // Content SEO modifier.
        // $out[] = ['ongr_oxid.modifier.content_seo', 'ONGR\OXIDConnectorBundle\Modifier\SeoModifier'];//.

        // Content SEO URL modifier.
        // $out[] = ['ongr_oxid.modifier.content_seo_url', 'ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier'];//.

        // Attributes to documents service.
        $out[] = ['ongr_oxid.attr_to_doc_service', 'ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService'];

        return $out;
    }
}
