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
use ONGR\ConnectionsBundle\Command\SyncStorageCreateCommand;
use ONGR\ConnectionsBundle\Sync\SyncStorage\SyncStorage;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class DataImportTest extends TestBase
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var Client
     */
    private $client;

    /**
     * Prepare services for tests.
     */
    protected function setUp()
    {
        $this->client = self::createClient();
        $this->application = new Application($this->client->getKernel());
    }

    /**
     * Test data import from database to Elastic Search.
     */
    public function testDataImportFromDBToES()
    {
        // Let's create storage space.
        $result = $this->executeCommand(
            new SyncStorageCreateCommand(),
            'ongr:sync:storage:create',
            ['storage' => SyncStorage::STORAGE_MYSQL]
        );
        $this->assertContains('Storage successfully created', $result->getDisplay());

        // Then update some data.
        $this->importData('DataImportTest/updateProducts.sql');

        // And start data provider pipeline.
        $result = $this->executeCommand(
            new SyncProvideCommand(),
            'ongr:sync:provide',
            ['target' => 'data_provide_test']
        );
        $this->assertContains('Job finished', $result->getDisplay());

        // Then start data import pipeline.
        $result = $this->executeCommand(
            new SyncExecuteCommand(),
            'ongr:sync:execute',
            ['target' => 'data_sync_test']
        );
        $this->assertContains('Job finished', $result->getDisplay());

        // And only then we check ElasticSearch for imported records.
    }

    /**
     * Executes specified command.
     *
     * @param ContainerAwareInterface $commandInstance
     * @param string                  $commandNamespace
     * @param array                   $parameters
     *
     * @return CommandTester
     */
    private function executeCommand(
        ContainerAwareInterface $commandInstance,
        $commandNamespace,
        array $parameters = []
    ) {
        $commandInstance->setContainer($this->client->getContainer());
        $this->application->add($commandInstance);
        $command = $this->application->find($commandNamespace);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array_merge_recursive(['command' => $command->getName()], $parameters));

        return $commandTester;
    }
}
