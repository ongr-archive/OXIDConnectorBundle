<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Unit\DependencyInjection;

use ONGR\OXIDConnectorBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if expected configuration structure works well.
     */
    public function testConfiguration()
    {
        $configs = [
            'database_mapping' => [
                'prod_1_en' => [
                    'tags' => [
                        '@shop_tag' => '_1',
                        '@lang_tag' => '_1_en',
                    ],
                    'shop_id' => 1,
                    'lang_id' => 0,
                ],
                'prod_2_en' => [
                    'tags' => [
                        '@shop_tag' => '_2',
                        '@lang_tag' => '_2_en',
                    ],
                    'shop_id' => 1,
                    'lang_id' => 0,
                ],
            ],
            'entity_namespace' => 'AcmeDemoBundle',
        ];

        $processor = new Processor();
        $processedConfig = $processor->processConfiguration(new Configuration(), [$configs]);

        $this->assertEquals(
            $configs['database_mapping']['prod_1_en']['tags']['@shop_tag'],
            $processedConfig['database_mapping']['prod_1_en']['tags']['@shop_tag']
        );
    }
}
