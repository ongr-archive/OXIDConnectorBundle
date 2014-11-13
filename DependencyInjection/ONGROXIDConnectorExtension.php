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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages bundle configuration.
 */
class ONGROXIDConnectorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $activeShop = $container->getParameter('ongr_connections.active_shop');

        $shopId = null;
        if (isset($config['database_mapping'][$activeShop]['shop_id'])) {
            $shopId = $config['database_mapping'][$activeShop]['shop_id'];
        }

        $languageId = null;
        if (isset($config['database_mapping'][$activeShop]['lang_id'])) {
            $languageId = $config['database_mapping'][$activeShop]['lang_id'];
        }

        $container->setParameter('ongr_oxid.entity_namespace', $config['entity_namespace']);
        $container->setParameter('ongr_oxid.shop_id', $shopId);
        $container->setParameter('ongr_oxid.language_id', $languageId);

        $loader->load('modifiers/seo.yml');

        if ($config['use_seo_triggers']) {
            $loader->load('triggers/seo.yml');
            $loader->load('triggers/seo_data.yml');
            $loader->load('triggers/seo_history.yml');
        }

        if ($config['use_modifiers']) {
            $this->loadModifiers($config, $loader);
        }

        if (!empty($config['database_mapping'])) {
            if ($activeShop === null) {
                throw new \LogicException(
                    'Database mapping is defined but active shop ID is not set.'
                );
            }

            if (!isset($config['database_mapping'][$activeShop])) {
                throw new \LogicException(
                    "Active shop is set to '{$activeShop}' but no DB mapping is defined for it."
                );
            }

            $tags = $config['database_mapping'][$activeShop]['tags'];
        } else {
            $tags = ['@shop_tag' => '', '@lang_tag' => '', '{@view_tag}' => ''];
        }

        $definition = new Definition(
            $container->getParameter('ongr_oxid.mapping_listener.class'),
            [$tags]
        );
        $definition->addTag('doctrine.event_listener', ['event' => 'loadClassMetadata']);
        $container->setDefinition('ongr_oxid.mapping_listener', $definition);
        //TODO

        die('*******super********');
    }

    /**
     * Loads required modifiers and triggers
     *
     * @param $config
     * @param LoaderInterface $loader
     */
    protected function loadModifiers($config, LoaderInterface $loader)
    {
        $toLoad = ['product', 'category', 'content'];

        foreach ($toLoad as $modifier) {
            if ($config['modifiers'] === [] || in_array($modifier, $config['modifiers'])) {
                $loader->load("modifiers/{$modifier}.yml");
                //load the trigger as well if they're enabled
                if ($config['use_default_triggers']) {
                    $loader->load("triggers/{$modifier}.yml");
                }
            }
        }
    }

    public function getAlias()
    {
        return 'ongr_oxid';
    }
}
