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

        // Update some data.
        $this->importData('DataImportTest/updateProducts.sql');
    }

    /**
     * Test cases to test Data Import.
     *
     * @return array.
     */
    public function getDataForDataImport()
    {
        $cases = [];

        // Case No 1. Test Category import.
        $cases[] = [
            'target' => 'category_import_test',
            'repository' => 'AcmeTestBundle:Category',
            'resultCount' => 2,
            'firstValue' => '0f41a4463b227c437f6e6bf57b1697c4',
        ];

        // Case No 1. Test Content import.
        $cases[] = [
            'target' => 'content_import_test',
            'repository' => 'AcmeTestBundle:Content',
            'resultCount' => 2,
            'firstValue' => 'ad542e49bff479009.64538090',
        ];

        // Case No 1. Test Product import.
        $cases[] = [
            'target' => 'product_import_test',
            'repository' => 'AcmeTestBundle:Product',
            'resultCount' => 2,
            'firstValue' => '6b698c33118caee4ca0882c33f513d2f',
        ];

        return $cases;
    }

    /**
     * Test data import from database to Elastic Search.
     *
     * @param string $target
     * @param string $repository
     * @param int    $resultCount
     * @param string $firstValue
     *
     * @dataProvider getDataForDataImport
     */
    public function testDataImportFromDBToES($target, $repository, $resultCount, $firstValue)
    {
        // Then start data import pipeline $target.
        $result = $this->executeCommand(
            new ImportFullCommand(),
            'ongr:import:full',
            ['target' => $target]
        );
        $this->assertContains('Job finished', $result->getDisplay());

        // Check ElasticSearch for imported records.
        /** @var Manager $manager */
        $manager = $this
            ->getServiceContainer()
            ->get('es.manager');

        // Test if all Categories were inserted.
        $repository = $manager->getRepository($repository);
        $search = $repository
            ->createSearch()
            ->addQuery(new MatchAllQuery());
        $documents = $repository->execute($search);
        $this->assertEquals($resultCount, $documents->count());

        $documents = iterator_to_array($documents);
        sort($documents);
        $this->assertEquals($firstValue, $documents[0]->getId());
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
