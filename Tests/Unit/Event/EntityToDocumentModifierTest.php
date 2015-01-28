<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Event;

use ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent;
use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;
use ONGR\OXIDConnectorBundle\Document\ContentDocument;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Modifier\CategoryModifier;
use ONGR\OXIDConnectorBundle\Modifier\ContentModifier;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\ObjectToCategory;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class EntityToDocumentModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AttributesToDocumentsService|MockObject
     */
    private $attrToDocService;

    /**
     * @var CategoryModifier
     */
    private $catModifierListener;

    /**
     * @var Category|MockObject
     */
    private $catEntity;

    /**
     * @var CategoryDocument|MockObject
     */
    private $catDocument;

    /**
     * @var ContentModifier
     */
    private $contModifierListener;

    /**
     * @var Content|MockObject
     */
    private $contEntity;

    /**
     * @var ContentDocument|MockObject
     */
    private $contDocument;

    /**
     * @var ProductModifier
     */
    private $prodModifierListener;

    /**
     * @var Article|MockObject
     */
    private $prodEntity;

    /**
     * @var ProductDocument|MockObject
     */
    private $prodDocument;

    /**
     * Set up services for tests.
     */
    protected function setUp()
    {
        /** @var AttributesToDocumentsService|MockObject attrToDocService */
        $this->attrToDocService = $this->getMock('\ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService');

        // Mocks for CategoryModifier.
        $this->catModifierListener = new CategoryModifier($this->attrToDocService);
        $this->catEntity = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category');
        $this->catDocument = $this->getMock('\ONGR\OXIDConnectorBundle\Document\CategoryDocument');

        // Mocks for ContentModifier.
        $this->contModifierListener = new ContentModifier();
        $this->contEntity = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Content');
        $this->contDocument = $this->getMock('\ONGR\OXIDConnectorBundle\Document\ContentDocument');

        // Mocks for ProductModifier.
        $this->prodModifierListener = new ProductModifier($this->attrToDocService);
        $this->prodEntity = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article');
        $this->prodDocument = $this->getMock('\ONGR\OXIDConnectorBundle\Document\ProductDocument');
    }

    /**
     * Test category modifier listener.
     */
    public function testCategoryListener()
    {
        $category = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category');
        $category->expects($this->exactly(2))
            ->method('getId')
            ->willReturnOnConsecutiveCalls(
                $this->returnValue(432),
                $this->returnValue(234)
            );

        $this->mockExpectsMethods(
            $this->catEntity,
            [
                ['getId', 1, 123],
                ['isActive', 1, true],
                ['isHidden', 1, false],
                ['getLeft', 1, 12],
                ['getRight', 1, 17],
                ['getRoot', 1, $category],
                ['getSort', 1, 12],
                ['getTitle', 1, 'testTitle'],
                ['getDesc', 1, 'testDescription'],
                ['getLongDesc', 1, 'testLongDescription'],
                ['getAttributes', 1, [1, 2, 3]],
                ['getParent', 1, $category],
            ]
        );
        $this->mockExpectsMethods(
            $this->catDocument,
            [
                ['setId', 1, null, 123],
                ['setActive', 1, null, true],
                ['setHidden', 1, null, false],
                ['setLeft', 1, null, 12],
                ['setRight', 1, null, 17],
                ['setRootId', 1, null, 432],
                ['setSort', 1, null, 12],
                ['setTitle', 1, null, 'testTitle'],
                ['setDescription', 1, null, 'testDescription'],
                ['setLongDescription', 1, null, 'testLongDescription'],
                ['setAttributes', 1, null, [11, 22, 33]],
                ['setParentId', 1, null, 234],
            ]
        );

        /** @var ImportItem|MockObject $importItem */
        $importItem = $this->getMockBuilder('ONGR\ConnectionsBundle\Pipeline\Item\ImportItem')
            ->disableOriginalConstructor()
            ->getMock();
        $importItem->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($this->catEntity));
        $importItem->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue($this->catDocument));

        /** @var ItemPipelineEvent|MockObject $itemPipelineEvent */
        $itemPipelineEvent = $this->getMockBuilder('\ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent')
            ->disableOriginalConstructor()
            ->getMock();
        $itemPipelineEvent->expects($this->once())
            ->method('getItem')
            ->will($this->returnValue($importItem));

        $this->attrToDocService->expects($this->once())
            ->method('transform')
            ->with([1, 2, 3])
            ->will($this->returnValue([11, 22, 33]));

        $this->catModifierListener->onModify($itemPipelineEvent);
    }

    /**
     * Test content modifier listener.
     */
    public function testContentModifierListener()
    {
        $this->mockExpectsMethods(
            $this->contEntity,
            [
                ['getId', 1, 123],
                ['getTitle', 1, 'testTitle'],
                ['getContent', 1, 'testContent'],
                ['getFolder', 1, 'testFolder'],
                ['getLoadId', 1, 'testLoadId'],
                ['isSnippet', 1, false],
                ['getType', 1, 'testType'],
                ['isActive', 1, true],
                ['getPosition', 1, 9],
            ]
        );
        $this->mockExpectsMethods(
            $this->contDocument,
            [
                ['setId', 1, null, 123],
                ['setTitle', 1, null, 'testTitle'],
                ['setContent', 1, null, 'testContent'],
                ['setFolder', 1, null, 'testFolder'],
                ['setSlug', 1, null, 'testLoadId'],
                ['setSnippet', 1, null, false],
                ['setType', 1, null, 'testType'],
                ['setActive', 1, null, true],
                ['setPosition', 1, null, 9],
            ]
        );

        /** @var ImportItem|MockObject $importItem */
        $importItem = $this->getMockBuilder('ONGR\ConnectionsBundle\Pipeline\Item\ImportItem')
            ->disableOriginalConstructor()
            ->getMock();
        $importItem->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($this->contEntity));
        $importItem->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue($this->contDocument));

        /** @var ItemPipelineEvent|MockObject $itemPipelineEvent */
        $itemPipelineEvent = $this->getMockBuilder('\ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent')
            ->disableOriginalConstructor()
            ->getMock();
        $itemPipelineEvent->expects($this->once())
            ->method('getItem')
            ->will($this->returnValue($importItem));

        $this->contModifierListener->onModify($itemPipelineEvent);
    }

    /**
     * Test product modifier listener.
     */
    public function testProductModifierListener()
    {
        $article = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article');
        $article->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(123));

        $articleExtension = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\ArticleExtension');
        $articleExtension->expects($this->once())
            ->method('getLongDesc')
            ->will($this->returnValue('testLongDescription'));

        $vendor = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Vendor');
        $vendor->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('testVendorTitle'));

        $manufacturer = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Manufacturer');
        $manufacturer->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('testManufacturerTitle'));

        $objectToCategories = [];
        $objectToCategories[0] = new ObjectToCategory();
        $category1 = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category');
        $category1->expects($this->once())
            ->method('isActive')
            ->will($this->returnValue(true));
        $category1->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(123));
        $objectToCategories[0]->setCategory($category1);
        // The following category should be skipped because of isActive=false.
        $objectToCategories[1] = new ObjectToCategory();
        $category2 = $this->getMock('\ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category');
        $category2->expects($this->once())
            ->method('isActive')
            ->will($this->returnValue(false));
        $category2->expects($this->never())
            ->method('getId');
        $objectToCategories[1]->setCategory($category2);

        $this->mockExpectsMethods(
            $this->prodEntity,
            [
                ['getId', 1, 123],
                ['isActive', 1, true],
                ['getArtNum', 1, 'testArtNum'],
                ['getTitle', 1, 'testTitle'],
                ['getShortDesc', 1, 'testShortDescription'],
                ['getPrice', 1, 20.20],
                ['getTPrice', 1, 25.00],
                ['getParent', 1, $article],
                ['getStock', 1, 50],
                ['getAttributes', 1, [1, 2, 3]],
                ['getExtension', 1, $articleExtension],
                ['getVendor', 1, $vendor],
                ['getManufacturer', 1, $manufacturer],
                ['getCategories', 1, $objectToCategories],
            ]
        );
        $this->mockExpectsMethods(
            $this->prodDocument,
            [
                ['setId', 1, null, 123],
                ['setActive', 1, null, true],
                ['setSku', 1, null, 'testArtNum'],
                ['setTitle', 1, null, 'testTitle'],
                ['setDescription', 1, null, 'testShortDescription'],
                ['setPrice', 1, null, 20.20],
                ['setOldPrice', 1, null, 25.00],
                ['setParentId', 1, null, 123],
                ['setStock', 1, null, 50],
                ['setAttributes', 1, null, [11, 22, 33]],
                ['setLongDescription', 1, null, 'testLongDescription'],
                ['setVendor', 1, null, 'testVendorTitle'],
                ['setManufacturer', 1, null, 'testManufacturerTitle'],
                ['setCategories', 1, null, [123]],
            ]
        );

        $this->attrToDocService->expects($this->once())
            ->method('transform')
            ->with([1, 2, 3])
            ->will($this->returnValue([11, 22, 33]));

        /** @var ImportItem|MockObject $importItem */
        $importItem = $this->getMockBuilder('ONGR\ConnectionsBundle\Pipeline\Item\ImportItem')
            ->disableOriginalConstructor()
            ->getMock();
        $importItem->expects($this->once())
            ->method('getEntity')
            ->will($this->returnValue($this->prodEntity));
        $importItem->expects($this->once())
            ->method('getDocument')
            ->will($this->returnValue($this->prodDocument));

        /** @var ItemPipelineEvent|MockObject $itemPipelineEvent */
        $itemPipelineEvent = $this->getMockBuilder('\ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent')
            ->disableOriginalConstructor()
            ->getMock();
        $itemPipelineEvent->expects($this->once())
            ->method('getItem')
            ->will($this->returnValue($importItem));

        $this->prodModifierListener->onModify($itemPipelineEvent);
    }

    /**
     * Helper method to check that mock is expecting for certain methods to be called.
     *
     * @param MockObject $mock
     * @param array      $methods
     */
    private function mockExpectsMethods(MockObject $mock, array $methods)
    {
        foreach ($methods as $expectations) {
            // Set expected number of invocations.
            if (!isset($expectations[1])) {
                $invMocker = $mock->expects($this->once());
            } else {
                $times = (int)$expectations[1];
                $invMocker = $mock->expects($this->exactly($times));
            }

            // Add method call.
            $invMocker->method($expectations[0]);

            // Add returned values.
            if (isset($expectations[2]) && isset($expectations[2]) !== null) {
                $invMocker->will($this->returnValue($expectations[2]));
            }

            // Add parameters to method.
            if (isset($expectations[3])) {
                $invMocker->with($expectations[3]);
            }
        }
    }
}
