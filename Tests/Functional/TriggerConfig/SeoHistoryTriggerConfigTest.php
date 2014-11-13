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
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\SeoHistory;

class SeoHistoryTriggerConfigTest extends TriggerConfigTestBase
{
    public function testSeoTrigger()
    {

        /** @var $triggersManager TriggersManager */
        $triggersManager = $this->getServiceContainer()->get('ongr_connections.triggers_manager');
        $entityManager = $this->getEntityManager();
        $this->importData('TriggerConfigTest/job.sql');
        $this->importData('TriggerConfigTest/category.sql');
        $this->importData('TriggerConfigTest/articles.sql');
        $this->importData('TriggerConfigTest/content.sql');
        $this->importData('TriggerConfigTest/seo_history.sql');

        //insert records before trigger creation so  we don't cause the main insert triggers to fire
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

        $category = new Category();
        $category->setActive(true);
        $category->setHidden(true);
        $category->setLeft(123);
        $category->setRight(321);
        $category->setSort(4);
        $category->setTitle('testTitle');
        $category->setDesc('testDecsription');
        $category->setLongDesc('testLongDescription');
        $entityManager->persist($category);

        $content = new Content();
        $content->setTitle("testContentTitle");
        $content->setContent("testContent");
        $content->setFolder("testFolder");
        $content->setLoadId("testLoadId");
        $content->setSnippet(true);
        $content->setType(5);
        $content->setActive(true);
        $content->setPosition("testPosition");
        $content->setId(3);
        $entityManager->persist($content);

        $entityManager->flush();

        $triggersManager->createTriggers($this->getProgressHelper(), $this->getConsoleOutput());

        $connection = $this->getConnection();

        //insert
        $seo = new SeoHistory();
        $seo->setIdent('testIdentifier');
        $seo->setLang(0);
        $seo->setObjectId('1');
        $seo->setShopId(0);
        $seo->setHits(5);

        $entityManager->persist($seo);

        $entityManager->flush();

        //update
        $seo->setLang(2);
        $entityManager->persist($seo);
        $entityManager->flush();

        //delete
        $connection->executeQuery('DELETE FROM `oxseohistory`');

        $actualRecords = $connection->fetchAll("SELECT * FROM `ongr_sync_jobs`");
        $this->compareRecords(
            [
                [
                    'id' => 1,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 2,
                    'document_type' => 'category',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 3,
                    'document_type' => 'content',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 4,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 5,
                    'document_type' => 'category',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 6,
                    'document_type' => 'content',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 7,
                    'document_type' => 'product',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 8,
                    'document_type' => 'category',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
                [
                    'id' => 9,
                    'document_type' => 'content',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'U'
                ],
            ],
            $actualRecords
        );
    }
}
