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
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class DataImportTest extends TestBase
{
    /**
     * @var Application
     */
    private $application;

    /**
     * Prepare services for tests.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->application = new Application($this->getClient()->getKernel());
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

        $this->rebootKernel();

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
     * @param ContainerAwareCommand $commandInstance
     * @param string                $commandNamespace
     * @param array                 $parameters
     *
     * @return CommandTester
     */
    private function executeCommand(
        ContainerAwareCommand $commandInstance,
        $commandNamespace,
        array $parameters = []
    ) {
        $application = new Application($this->getClient()->getKernel());
        $commandInstance->setContainer($this->getServiceContainer());
        $application->add($commandInstance);
        $command = $application->find($commandNamespace);
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array_merge_recursive(
                ['command' => $command->getName()],
                $parameters
            )
        );

        return $commandTester;
    }
}
