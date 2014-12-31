<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Functional;

use ONGR\ConnectionsBundle\Sync\Trigger\TriggersManager;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article;

class ProductTriggerConfigTest extends TriggerConfigTestBase
{
    /**
     * Tests Article trigger.
     */
    public function testArticleTrigger()
    {
        /** @var $triggersManager TriggersManager */
        $triggersManager = $this->getServiceContainer()->get('ongr_connections.triggers_manager');
        $this->importData('TriggerConfigTest/job.sql');
        $this->importData('TriggerConfigTest/articles.sql');
        $triggersManager->createTriggers($this->getProgressHelper(), $this->getConsoleOutput());

        $entityManager = $this->getEntityManager();
        $connection = $this->getConnection();

        // Insert.
        $article = new Article();
        $article->setActive(true);
        $article->setShortDesc('test');
        $article->setArtNum('testArtNum');
        $article->setMpn('testPartNumber');
        $article->setTitle('testTitle');
        $article->setPrice(0.1);
        $article->setSort(0);
        $article->setStock(5.56);
        $article->setStockFlag(2);
        $article->setTPrice(5.58);
        $entityManager->persist($article);
        $entityManager->flush();

        // Update.
        $article->setPrice(0.2);
        $entityManager->persist($article);
        $entityManager->flush();

        // Delete.
        $entityManager->remove($article);
        $entityManager->flush();

        $actualRecords = $connection->fetchAll('SELECT * FROM `ongr_sync_jobs`');
        $this->compareRecords(
            [
                [
                    'id' => 1,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'C',
                ],
                [
                    'id' => 2,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U',
                ],
                [
                    'id' => 3,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'D',
                ],
            ],
            $actualRecords
        );
    }
}
