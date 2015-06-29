<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Sets active shop id for Seo Finder service.
 */
class SeoServicePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $activeShop = $container->getParameter('ongr_connections.active_shop');
        $shops = $container->getParameter('ongr_connections.shops');

        $definition = $container->getDefinition('ongr_oxid.seo_finder_service');
        $definition->addMethodCall('setShopId', [$shops[$activeShop]['shop_id']]);
    }
}
