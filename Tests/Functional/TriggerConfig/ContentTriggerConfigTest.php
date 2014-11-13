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
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content;

class ContentTriggerConfigTest extends TriggerConfigTestBase
{
    public function testContentTrigger()
    {
        /** @var $triggersManager TriggersManager */
        $triggersManager = $this->getServiceContainer()->get('ongr_connections.triggers_manager');
        $this->importData('TriggerConfigTest/job.sql');
        $this->importData('TriggerConfigTest/content.sql');
        $triggersManager->createTriggers($this->getProgressHelper(), $this->getConsoleOutput());

        $entityManager = $this->getEntityManager();
        $connection = $this->getConnection();

        //insert
        $content = new Content();
        $content->setTitle("testContentTitle");
        $content->setContent("testContent");
        $content->setFolder("testFolder");
        $content->setLoadId("testLoadId");
        $content->setSnippet(true);
        $content->setType(5);
        $content->setActive(true);
        $content->setPosition("testPosition");
        $entityManager->persist($content);
        $entityManager->flush();

        //update
        $content->setContent("testContent2");
        $entityManager->persist($content);
        $entityManager->flush();

        //delete
        $entityManager->remove($content);
        $entityManager->flush();

        $actualRecords = $connection->fetchAll("SELECT * FROM `ongr_sync_jobs`");
        $this->compareRecords(
            [
                [
                    'id' => 1,
                    'document_type' => 'content',
                    'document_id' => '1',
                    'status_test' => '0',
                    'update_type' => '1',
                    'type' => 'C'
                ],
                [
                    'id' => 2,
                    'document_type' => 'content',
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
                    'type' => 'D'
                ]
            ],
            $actualRecords
        );
    }
}
