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

use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;

class CategoryDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CategoryDocument
     */
    private $document;

    /**
     * Set up document for testing.
     */
    protected function setUp()
    {
        $this->document = new CategoryDocument();
    }

    /**
     * Test getters and setters.
     */
    public function testGettersAndSetters()
    {
        $this->document
            ->setRootId('someRootId')
            ->setDescription('someDescription')
            ->setLongDescription('someLongDescription');
        $expectedAttributes = [];
        $expectedAttributes[0] = new AttributeObject();
        $expectedAttributes[0]->setPos(1)->setTitle('att1Title');
        $expectedAttributes[1] = new AttributeObject();
        $expectedAttributes[1]->setPos(2)->setTitle('att2Title');
        $this->document->setAttributes($expectedAttributes);

        $this->assertEquals('someRootId', $this->document->getRootId());
        $this->assertEquals('someDescription', $this->document->getDescription());
        $this->assertEquals('someLongDescription', $this->document->getLongDescription());
        $this->assertEquals(count($expectedAttributes), count($this->document->getAttributes()));

        $actualAttributes = $this->document->getAttributes();
        foreach ($actualAttributes as $idx => $actualAttribute) {
            $this->assertSame($expectedAttributes[$idx], $actualAttribute);
        }
    }
}
