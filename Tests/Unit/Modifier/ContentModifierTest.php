<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\ContentDocument;
use ONGR\OXIDConnectorBundle\Entity\Seo;
use ONGR\OXIDConnectorBundle\Modifier\ContentModifier;
use ONGR\OXIDConnectorBundle\Service\SeoFinder;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content;
use ONGR\RouterBundle\Document\UrlNested;

class ContentModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify().
     */
    public function testModify()
    {
        $modifier = new ContentModifier();

        /** @var Content $content */
        $content = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Content');
        $content
            ->setId('testId')
            ->setActive(true)
            ->setPosition(4)
            ->setContent('testContent')
            ->setTitle('testTitle')
            ->setFolder('testFolder')
            ->setLoadId('testSlug')
            ->setSnippet(false)
            ->setType(5)
            ->setFolder('testFolder');

        /** @var Seo|\PHPUnit_Framework_MockObject_MockObject $seo */
        $seo = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seo->setSeoUrl('test');

        /** @var SeoFinder|\PHPUnit_Framework_MockObject_MockObject $seoFinder */
        $seoFinder = $this->getMockBuilder('ONGR\OXIDConnectorBundle\Service\SeoFinder')
            ->disableOriginalConstructor()
            ->getMock();
        $seoFinder->expects($this->once())->method('getEntitySeo')->willReturn(new \ArrayIterator([$seo]));

        $modifier->setSeoFinderService($seoFinder);

        $expectedDocument = new ContentDocument();
        $expectedDocument->setId('testId');
        $expectedDocument->setActive(true);
        $expectedDocument->setPosition(4);
        $expectedDocument->setContent('testContent');
        $expectedDocument->setTitle('testTitle');
        $expectedDocument->setFolder('testFolder');
        $expectedDocument->setSlug('testSlug');
        $expectedDocument->setSnippet(false);
        $expectedDocument->setType(5);
        $expectedDocument->setFolder('testFolder');
        $url = new UrlNested();
        $url->setUrl('test');
        $expectedDocument->setUrls(new \ArrayIterator([$url]));
        $expectedDocument->setExpiredUrls([]);

        $document = new ContentDocument();

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        $modifier->modify(new ImportItem($content, $document), $event);

        $this->assertEquals($expectedDocument, $document);
    }
}
