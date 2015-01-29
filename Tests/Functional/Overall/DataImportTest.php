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
use ONGR\ElasticsearchBundle\DSL\Query\MatchAllQuery;
use ONGR\ElasticsearchBundle\ORM\Manager;
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

class DataImportTest extends TestBase
{
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
            'repository' => 'ONGROXIDConnectorBundle:CategoryDocument',
            'resultCount' => 2,
            'firstValue' => '0f41a4463b227c437f6e6bf57b1697c4',
        ];

        // Case No 2. Test Content import.
        $cases[] = [
            'target' => 'content_import_test',
            'repository' => 'ONGROXIDConnectorBundle:ContentDocument',
            'resultCount' => 2,
            'firstValue' => 'ad542e49bff479009.64538090',
        ];

        // Case No 3. Test Product import.
        $cases[] = [
            'target' => 'product_import_test',
            'repository' => 'ONGROXIDConnectorBundle:ProductDocument',
            'resultCount' => 1,
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

        // Test if all data was inserted.
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
}
