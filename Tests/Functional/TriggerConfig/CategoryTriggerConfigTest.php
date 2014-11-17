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
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;

class CategoryTriggerConfigTest extends TriggerConfigTestBase
{
    /**
     * Tests Category trigger.
     */
    public function testCategoryTrigger()
    {
        /** @var $triggersManager TriggersManager */
        $triggersManager = $this->getServiceContainer()->get('ongr_connections.triggers_manager');
        $entityManager = $this->getEntityManager();
        $this->importData('TriggerConfigTest/job.sql');
        $this->importData('TriggerConfigTest/category.sql');
        $this->importData('TriggerConfigTest/articles.sql');

        // Insert article before triggers creation so  we don't cause the main articles insert trigger to fire.
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

        $triggersManager->createTriggers($this->getProgressHelper(), $this->getConsoleOutput());

        $connection = $this->getConnection();

        // Insert.
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

        $objectToCat = new ArticleToCategory();
        $objectToCat->setArticle($article);
        $objectToCat->setCategory($category);
        $objectToCat->setTime(123);
        $objectToCat->setPos(1);
        $entityManager->persist($objectToCat);

        $entityManager->flush();

        // Update.
        $category->setSort(5);
        $entityManager->persist($category);
        $entityManager->flush();

        // Delete.
        $entityManager->remove($category);
        $entityManager->flush();

        $actualRecords = $connection->fetchAll('SELECT * FROM `ongr_sync_jobs`');

        $this->compareRecords(
            [
                [
                    'id' => 1,
                    'document_type' => 'category',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'C',
                ],
                [
                    'id' => 2,
                    'document_type' => 'category',
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
                    'type' => 'U',
                ],
                [
                    'id' => 4,
                    'document_type' => 'category',
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
