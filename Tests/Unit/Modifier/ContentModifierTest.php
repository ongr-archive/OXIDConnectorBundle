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

use ONGR\TestingBundle\Document\Content as ContentDocument;
use ONGR\OXIDConnectorBundle\Entity\Content;
use ONGR\OXIDConnectorBundle\Modifier\ContentModifier;

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
            ->setContent('testContent')
            ->setTitle('testTitle')
            ->setFolder('testFolder')
            ->setLoadId('testSlug');

        $expectedDocument = new ContentDocument();
        $expectedDocument->id = 'testId';
        $expectedDocument->content = 'testContent';
        $expectedDocument->title = 'testTitle';
        $expectedDocument->folder = 'testFolder';
        $expectedDocument->slug = 'testSlug';

        $document = new ContentDocument();
        $modifier->modify($document, $content);

        $this->assertEquals($expectedDocument, $document);
    }
}
