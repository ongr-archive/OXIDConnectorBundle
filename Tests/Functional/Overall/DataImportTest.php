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

use ONGR\ConnectionsBundle\Command\ImportFullCommand;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use ONGR\ElasticsearchBundle\ORM\Manager;
use ONGR\ElasticsearchBundle\DSL\Query\MatchAllQuery;

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

        $this
            ->getServiceContainer()
            ->get('es.manager')
            ->getConnection()
            ->dropAndCreateIndex();
    }

    /**
     * Test data import from database to Elastic Search.
     */
    public function testDataImportFromDBToES()
    {
        // Update some data.
        $this->importData('DataImportTest/updateProducts.sql');


        // Then start data import pipeline for category.
        $result = $this->executeCommand(
            new ImportFullCommand(),
            'ongr:import:full',
            ['target' => 'category_import_test']
        );
        $this->assertContains('Job finished', $result->getDisplay());

        // Then start data import pipeline for content.
        $result = $this->executeCommand(
            new ImportFullCommand(),
            'ongr:import:full',
            ['target' => 'content_import_test']
        );
        $this->assertContains('Job finished', $result->getDisplay());

        // Then start data import pipeline for product.
        $result = $this->executeCommand(
            new ImportFullCommand(),
            'ongr:import:full',
            ['target' => 'product_import_test']
        );
        $this->assertContains('Job finished', $result->getDisplay());


        // Check ElasticSearch for imported records.
        /** @var Manager $manager */
        $manager = $this
            ->getServiceContainer()
            ->get('es.manager');


        // Test if all Categories were inserted.
        $repository = $manager->getRepository('AcmeTestBundle:Category');
        $search = $repository
            ->createSearch()
            ->addQuery(new MatchAllQuery());
        $documents = $repository->execute($search);
        $this->assertEquals(2, $documents->count());
        $this->assertEquals('fada9485f003c731b7fad08b873214e0', $documents->current()->getId());
        $documents->next();
        $this->assertEquals('0f41a4463b227c437f6e6bf57b1697c4', $documents->current()->getId());

        // Test if all Contents were inserted.
        $repository = $manager->getRepository('AcmeTestBundle:Content');
        $search = $repository
            ->createSearch()
            ->addQuery(new MatchAllQuery());
        $documents = $repository->execute($search);
        $this->assertEquals(2, $documents->count());
        $this->assertEquals('ad542e49bff479009.64538090', $documents->current()->getId());
        $documents->next();
        $this->assertEquals('8709e45f31a86909e9f999222e80b1d0', $documents->current()->getId());

        // Test if all Products were inserted.
        $repository = $manager->getRepository('AcmeTestBundle:Product');
        $search = $repository
            ->createSearch()
            ->addQuery(new MatchAllQuery());
        $documents = $repository->execute($search);
        $this->assertEquals(2, $documents->count());
        $this->assertEquals('6b698c33118caee4ca0882c33f513d2f', $documents->current()->getId());
        $documents->next();
        $this->assertEquals('6b6a6aedca3e438e98d51f0a5d586c0b', $documents->current()->getId());
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
