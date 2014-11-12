<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Validates and merges configuration from app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ongr_oxid');

        $rootNode
            ->children()
                ->arrayNode('database_mapping')
                    ->useAttributeAsKey('ongr_shop_id')
                    ->example(
                        [
                            'shop_one' => [
                                'tags' => ['@shop_tag' => '_1', '@lang_tag' => '_1_en', '{@view_tag}' => 'oxv_'],
                                'shop_id' => 1,
                                'lang_id' => 0,
                            ]
                        ]
                    )
                    ->prototype('array')
                        ->children()
                            ->scalarNode('ongr_shop_id')->end()
                            ->arrayNode('tags')
                                ->children()
                                    ->scalarNode('@shop_tag')->isRequired()->end()
                                    ->scalarNode('@lang_tag')->isRequired()->end()
                                    ->scalarNode('{@view_tag}')->defaultValue('oxv_')->end()
                                ->end()
                            ->end()
                            ->scalarNode('shop_id')->isRequired()->end()
                            ->scalarNode('lang_id')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('use_default_triggers')
                    ->defaultTrue()
                    ->info('enabled')
                ->end()
                ->booleanNode('use_modifiers')
                    ->defaultTrue()
                    ->info('Should modifiers be loaded')
                ->end()
                ->booleanNode('use_seo_triggers')
                    ->info('Should default seo triggers be loaded')
                    ->defaultTrue()
                ->end()
                ->arrayNode('modifiers')
                    ->info('List of default modifiers to use. Set to NULL to disable default modifiers.')
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('entity_namespace')
                    ->isRequired()
                    ->info('Namespace/alias for OXID entities')
                    ->example('AcmeDemoBundle')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
