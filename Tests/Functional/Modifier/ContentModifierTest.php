<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Modifier;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\ContentDocument;
use ONGR\OXIDConnectorBundle\Modifier\ContentModifier;
use ONGR\OXIDConnectorBundle\Service\SeoFinder;
use ONGR\OXIDConnectorBundle\Tests\Functional\AbstractTestCase;
use ONGR\RouterBundle\Document\UrlNested;

/**
 * Tests if category modifier works as expected.
 */
class ContentModifierTest extends AbstractTestCase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        $expectedContent1 = new ContentDocument();
        $expectedContent1->setId('8709e45f31a86909e9f999222e80b1d0');
        $expectedContent1->setContent('CONTENT ONE');
        $expectedContent1->setTitle('TITLE OF CONTENT ONE');
        $expectedContent1->setFolder('CMSFOLDER_STANDARD');
        $expectedContent1->setSlug('oxstdfooter');
        $expectedContent1->setSnippet(true);
        $expectedContent1->setType(2);
        $expectedContent1->setActive(false);
        $expectedContent1->setPosition('position1');
        $url = new UrlNested();
        $url->setUrl('Test/Content/1');
        $expectedContent1->setUrls(new \ArrayIterator([$url]));
        $expectedContent1->setExpiredUrls([]);

        $expectedContent2 = new ContentDocument();
        $expectedContent2->setId('ad542e49bff479009.64538090');
        $expectedContent2->setContent('<div>Content two</div>');
        $expectedContent2->setTitle('Title of content two');
        $expectedContent2->setFolder('CMSFOLDER_EMAILS');
        $expectedContent2->setSlug('oxadminorderemail');
        $expectedContent2->setSnippet(false);
        $expectedContent2->setType(1);
        $expectedContent2->setActive(true);
        $expectedContent2->setPosition('position2');
        $url = new UrlNested();
        $url->setUrl('Test/Content/2');
        $expectedContent2->setUrls(new \ArrayIterator([$url]));
        $expectedContent2->setExpiredUrls([]);

        $expectedEntities = [$expectedContent1, $expectedContent2];

        $contentItems = $this->getTestElements(
            ['8709e45f31a86909e9f999222e80b1d0', 'ad542e49bff479009.64538090'],
            'ONGROXIDConnectorBundleTest:Content'
        );
        $this->assertCount(2, $contentItems);

        $seoFinder = new SeoFinder();
        $seoFinder->setEntityManager($this->getEntityManager());
        $seoFinder->setShopId(0);
        $seoFinder->setRepository('ONGROXIDConnectorBundleTest:Seo');

        $modifier = new ContentModifier();
        $modifier->setSeoFinderService($seoFinder);

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        foreach ($expectedEntities as $key => $expectedContent) {
            $actualContent = new ContentDocument();
            $modifier->modify(new ImportItem($contentItems[$key], $actualContent), $event);
            $this->assertEquals($expectedContent, $actualContent);
        }
    }
}
