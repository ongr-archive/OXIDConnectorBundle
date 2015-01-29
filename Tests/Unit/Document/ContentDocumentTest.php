<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Document;

use ONGR\OXIDConnectorBundle\Document\ContentDocument;

class ContentDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContentDocument
     */
    private $document;

    /**
     * Set up document for testing.
     */
    protected function setUp()
    {
        $this->document = new ContentDocument();
    }

    /**
     * Test getters and setters.
     */
    public function testGettersAndSetters()
    {
        $this->document
            ->setSnippet(true)
            ->setType(14)
            ->setActive(false)
            ->setPosition(1234)
            ->setFolder('testFolder');

        $this->assertEquals(true, $this->document->getSnippet());
        $this->assertEquals(14, $this->document->getType());
        $this->assertEquals(false, $this->document->getActive());
        $this->assertEquals(false, $this->document->isActive());
        $this->assertEquals(1234, $this->document->getPosition());
        $this->assertEquals('testFolder', $this->document->getFolder());
    }
}
