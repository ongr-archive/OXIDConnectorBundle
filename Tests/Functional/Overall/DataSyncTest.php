<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Overall;

use ONGR\ConnectionsBundle\Command\SyncExecuteCommand;
use ONGR\ConnectionsBundle\Command\SyncProvideCommand;
use ONGR\ConnectionsBundle\Service\PairStorage;
use ONGR\ConnectionsBundle\Sync\DiffProvider\Binlog\BinlogDiffProvider;
use ONGR\ConnectionsBundle\Sync\DiffProvider\Binlog\BinlogParser;
use ONGR\ConnectionsBundle\Sync\StorageManager\MysqlStorageManager;
use ONGR\ElasticsearchBundle\DSL\Search;
use ONGR\ElasticsearchBundle\ORM\Repository;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

class DataSyncTest extends TestBase
{
    /**
     * Tests full data synchronization process.
     */
    public function testDataSync()
    {
        // Delete existing binlog data.
        $this->getConnection()->executeQuery('RESET MASTER');

        $this->importData('DataImportTest/updateProducts.sql');
        $this->importData('DataImportTest/updateCategories.sql');
        $this->importData('DataImportTest/updateContent.sql');

        /** @var MysqlStorageManager $managerMysql */
        $managerMysql = $this
            ->getServiceContainer()
            ->get('ongr_connections.sync.storage_manager.mysql_storage_manager');

        // Create storage for shop.
        $managerMysql->createStorage(0);

        // Set initial start position, if not sure, 0 always returns results.
        $this->setLastSync(0, BinlogParser::START_TYPE_POSITION);

        // Set service so, that it would use last sync position.
        $this
            ->getServiceContainer()
            ->get('ongr_connections.sync.diff_provider.binlog_diff_provider')
            ->setStartType(BinlogParser::START_TYPE_POSITION);

        // Then start data import with pipeline $target.
        $this->executeCommand(
            new SyncProvideCommand(),
            'ongr:sync:provide',
            ['target' => 'data_provide_test']
        );

        // The part of "sync execute".

        $esManager = $this->getServiceContainer()->get('es.manager');
        $esManager->getConnection()->dropAndCreateIndex();

        $result = $this->executeCommand(
            new SyncExecuteCommand(),
            'ongr:sync:execute',
            ['target' => 'data_execute_product']
        );

        $this->assertContains('Job finished', $result->getDisplay());

        $result = $this->executeCommand(
            new SyncExecuteCommand(),
            'ongr:sync:execute',
            ['target' => 'data_execute_category']
        );

        $this->assertContains('Job finished', $result->getDisplay());

        $result = $this->executeCommand(
            new SyncExecuteCommand(),
            'ongr:sync:execute',
            ['target' => 'data_execute_content']
        );

        $this->assertContains('Job finished', $result->getDisplay());

        $repositories = [
            'TestBundle:ProductDocument',
            'TestBundle:CategoryDocument',
            'TestBundle:ContentDocument',
        ];

        $actualDocuments = [];

        foreach ($repositories as $repositoryName) {
            $repository = $esManager->getRepository($repositoryName);

            foreach ($repository->execute(new Search(), Repository::RESULTS_ARRAY) as $item) {
                $actualDocuments[$repositoryName][] = $item;
            }
        }

        $expectedDocument = [
            'TestBundle:ProductDocument' => [
                0 => [
                    'title' => 'The same title for all!',
                    'description' => 'The same desc for all!',
                    'sku' => '85-8573-846-1-4-3',
                    'price' => 25.5,
                    'active' => true,
                    'old_price' => 36.7,
                    'stock' => 5,
                ],
                1 => [
                    'title' => 'Product 1',
                    'active' => true,
                ],
                2 => [
                    'title' => 'Product 2',
                    'active' => true,
                ],
                3 => [
                    'title' => 'Product 3',
                    'active' => true,
                ],
                4 => [
                    'title' => 'The same title for all!',
                    'description' => 'The same desc for all!',
                    'long_description' => 'Product number two description for testing from extension',
                    'sku' => '0702-85-853-9-2',
                    'price' => 46.6,
                    'old_price' => 35.7,
                    'stock' => 2,
                    'vendor' => 'Vendor Title for PRODUCT TWO',
                    'manufacturer' => 'Naish',
                    'categories' =>
                            [
                                0 => 'fada9485f003c731b7fad08b873214e0',
                            ],
                ],
            ],
            'TestBundle:CategoryDocument' => [
                0 => [
                    'sort' => 3010101,
                    'active' => true,
                    'title' => 'The best category ever',
                    'is_hidden' => true,
                    'left' => 4,
                    'right' => 5,
                    'root_id' => '30e44ab83fdee7564.23264141',
                    'attributes' =>
                        [
                            0 =>
                                [
                                    'title' => 'testAttribute',
                                    'pos' => 9999,
                                ],
                        ],
                ],
            ],
            'TestBundle:ContentDocument' => [
                0 => [
                    'slug' => 'oxadminorderemail',
                    'title' => 'Title of content two',
                    'content' => 'Content two',
                    'type' => 1,
                    'active' => true,
                    'position' => 'position2',
                    'folder' => 'CMSFOLDER_EMAILS',
                ],
            ],
        ];

        $this->assertEquals(
            sort($expectedDocument),
            sort($actualDocuments)
        );
    }

    /**
     * Sets last_sync_date in bin log format or sets last_sync_position.
     *
     * @param \DateTime|int $from
     * @param int           $startType
     */
    private function setLastSync($from, $startType)
    {
        /** @var PairStorage $pairStorage */
        $pairStorage = $this->getServiceContainer()->get('ongr_connections.pair_storage');

        if ($startType == BinlogParser::START_TYPE_DATE) {
            // Sometimes, mysql, php and server timezone could differ, we need convert time seen by php
            // to the same time in the same timezone as is used in mysqlbinlog.
            // This issue is for tests only, should not affect live website.
            $result = $this->managerMysql->getConnection()->executeQuery('SELECT @@global.time_zone');

            $time_zone = $result->fetchAll()[0]['@@global.time_zone'];

            // If mysql timezone is the same as systems, string 'SYSTEM' is returned, which is not what we want.
            if ($time_zone == 'SYSTEM') {
                $result = $this->managerMysql->getConnection()->executeQuery('SELECT @@system_time_zone');
                $time_zone = $result->fetchAll()[0]['@@system_time_zone'];
            }

            $from->setTimezone(new \DateTimeZone($time_zone));

            $pairStorage->set(BinlogDiffProvider::LAST_SYNC_DATE_PARAM, $from->format('Y-m-d H:i:s'));
        } elseif ($startType == BinlogParser::START_TYPE_POSITION) {
            $pairStorage->set(BinlogDiffProvider::LAST_SYNC_POSITION_PARAM, $from);
        }
    }
}
