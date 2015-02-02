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
use ONGR\OXIDConnectorBundle\Tests\Functional\TestBase;

/**
 * Tests if category modifier works as expected.
 */
class ContentModifierTest extends TestBase
{
    /**
     * Test modification.
     */
    public function testModify()
    {
        $expected1 = new ContentDocument();
        $expected1->setId('8709e45f31a86909e9f999222e80b1d0');
        $expected1->setContent('CONTENT ONE');
        $expected1->setTitle('TITLE OF CONTENT ONE');
        $expected1->setFolder('CMSFOLDER_STANDARD');
        $expected1->setSlug('oxstdfooter');
        $expected1->setSnippet(true);
        $expected1->setType(2);
        $expected1->setActive(false);
        $expected1->setPosition('position1');

        $expected2 = new ContentDocument();
        $expected2->setId('ad542e49bff479009.64538090');
        $expected2->setContent('<div>Content two</div>');
        $expected2->setTitle('Title of content two');
        $expected2->setFolder('CMSFOLDER_EMAILS');
        $expected2->setSlug('oxadminorderemail');
        $expected2->setSnippet(false);
        $expected2->setType(1);
        $expected2->setActive(true);
        $expected2->setPosition('position2');

        $expectedEntities = [$expected1, $expected2];

        $contentItems = $this->getTestElements(
            ['8709e45f31a86909e9f999222e80b1d0', 'ad542e49bff479009.64538090'],
            'ONGROXIDConnectorBundleTest:Content'
        );
        $this->assertCount(2, $contentItems);

        $modifier = new ContentModifier();

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        foreach ($expectedEntities as $key => $expectedContent) {
            $actualContent = new ContentDocument();
            $modifier->modify(new ImportItem($contentItems[$key], $actualContent), $event);
            $this->assertEquals($expectedContent, $actualContent);
        }
    }
}
