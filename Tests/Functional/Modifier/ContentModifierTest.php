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

use ONGR\TestingBundle\Document\Content as ContentDocument;
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
        $expectedEntity1 = new ContentDocument();
        $expectedEntity1->id = '8709e45f31a86909e9f999222e80b1d0';
        $expectedEntity1->content = 'CONTENT ONE';
        $expectedEntity1->title = 'TITLE OF CONTENT ONE';
        $expectedEntity1->folder = 'CMSFOLDER_STANDARD';
        $expectedEntity1->slug = 'oxstdfooter';

        $expectedEntity2 = new ContentDocument();
        $expectedEntity2->id = 'ad542e49bff479009.64538090';
        $expectedEntity2->content = '<div>Content two</div>';
        $expectedEntity2->title = 'Title of content two';
        $expectedEntity2->folder = 'CMSFOLDER_EMAILS';
        $expectedEntity2->slug = 'oxadminorderemail';

        $expectedEntities = [$expectedEntity1, $expectedEntity2];

        $contentItems = $this->getTestElements(
            ['8709e45f31a86909e9f999222e80b1d0', 'ad542e49bff479009.64538090'],
            'ONGROXIDConnectorBundleTest:Content'
        );
        $this->assertCount(2, $contentItems);

        $modifier = new ContentModifier();
        $createdContent = new ContentDocument();
        foreach ($expectedEntities as $key => $expectedEntity) {
            $modifier->modify($createdContent, $contentItems[$key]);
            $this->assertEquals($createdContent, $expectedEntity);
        }
    }
}
