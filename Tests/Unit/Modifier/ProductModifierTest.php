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
use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Document\VariantObject;
use ONGR\OXIDConnectorBundle\Entity\ArticleExtension;
use ONGR\OXIDConnectorBundle\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Entity\Manufacturer;
use ONGR\OXIDConnectorBundle\Entity\Vendor;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\ArticleToAttribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Attribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;

class ProductModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AttributesToDocumentsService
     */
    private $attrToDocService;

    /**
     * @var ProductModifier
     */
    private $modifier;

    /**
     * Set up services for tests.
     */
    protected function setUp()
    {
        $this->attrToDocService = new AttributesToDocumentsService();
        $this->modifier = new ProductModifier($this->attrToDocService);
    }

    /**
     * Test for modify().
     */
    public function testModify()
    {
        /** @var Article $parent */
        $parent = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');
        $parent->setId('parentId');

        /** @var Category $category */
        $category = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $category->setId('inactiveCategoryId');
        $category->setActive(false);

        /** @var Category $activeCategory */
        $activeCategory = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $activeCategory->setId('activeCategoryId');
        $activeCategory->setActive(true);

        /** @var ArticleToCategory $objToCat */
        $objToCat = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleToCategory');
        $objToCat->setCategory($category);

        /** @var ArticleToCategory $activeObjToCat */
        $activeObjToCat = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleToCategory');
        $activeObjToCat->setCategory($activeCategory);

        /** @var ArticleExtension $extension */
        $extension = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleExtension');
        $extension->setLongDesc('Long description');

        /** @var Vendor $vendor */
        $vendor = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Vendor');
        $vendor->setTitle('Vendor A');

        /** @var Manufacturer $manufacturer */
        $manufacturer = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Manufacturer');
        $manufacturer->setTitle('Manufacturer A');

        /** @var Article $entity */
        $entity = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');

        // Attribute to be added to Category.
        $attribute = new Attribute();
        $attribute->setId(123);
        $attribute->setPos(1);
        $attribute->setTitle('testAttributeTitle');
        $artToAttr = new ArticleToAttribute();
        $artToAttr->setId(321);
        $artToAttr->setPos(1);
        $artToAttr->setArticle($entity);
        $artToAttr->setAttribute($attribute);

        $entity
            ->setId('id123')
            ->setActive(true)
            ->setArtNum('abc123')
            ->setTitle('Any title')
            ->setShortDesc('Short description')
            ->setPrice(12.34)
            ->setTPrice(43.21)
            ->setExtension($extension)
            ->addCategory($objToCat)
            ->addCategory($activeObjToCat)
            ->setStock(5)
            ->setStockFlag(1)
            ->setVendor($vendor)
            ->setManufacturer($manufacturer)
            ->addAttribute($artToAttr);

        $entity->setVariants($this->getVariants($entity));

        $expectedDocument = new ProductDocument();
        $expectedDocument->setId('id123');
        $expectedDocument->setActive(true);
        $expectedDocument->setSku('abc123');
        $expectedDocument->setTitle('Any title');
        $expectedDocument->setDescription('Short description');
        $expectedDocument->setPrice(12.34);
        $expectedDocument->setOldPrice(43.21);
        $expectedDocument->setLongDescription('Long description');
        $expectedDocument->setCategories(['activeCategoryId']);
        $expectedDocument->setStock(5);
        $expectedDocument->setVendor('Vendor A');
        $expectedDocument->setManufacturer('Manufacturer A');
        $expectedDocument->setVariants($this->getExpectedVariants());
        $attObj = new AttributeObject();
        $attObj->setPos(1);
        $attObj->setTitle('testAttributeTitle');
        $expectedDocument->setAttributes([$attObj]);

        $document = new ProductDocument();

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);

        $this->modifier->modify(new ImportItem($entity, $document), $event);

        $this->assertEquals($expectedDocument, $document);
    }

    /**
     * Tests skipping.
     */
    public function testModifySkip()
    {
        /** @var Article $entityParent */
        $entityParent = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');
        $entityParent->setId('id');

        /** @var Article $entity */
        $entity = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');
        $entity->setParent($entityParent);

        $document = new ProductDocument();

        /** @var ItemPipelineEvent|\PHPUnit_Framework_MockObject_MockObject $event */
        $event = $this->getMock('ONGR\ConnectionsBundle\Pipeline\Event\ItemPipelineEvent', [], [], '', false);
        $event->expects($this->once())->method('setItemSkip');

        $this->modifier->modify(new ImportItem($entity, $document), $event);
    }

    /**
     * @param Article $parent
     *
     * @return Article[] ;
     */
    private function getVariants($parent)
    {
        /** @var ArticleExtension $extension */
        $extension = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleExtension');
        $extension->setLongDesc('Long description');

        /** @var Article $entity1 */
        $entity1 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');

        $attribute = new Attribute();
        $attribute->setId(125);
        $attribute->setPos(1);
        $attribute->setTitle('testAttributeTitle');
        $artToAttr = new ArticleToAttribute();
        $artToAttr->setId(3213);
        $artToAttr->setPos(1);
        $artToAttr->setArticle($entity1);
        $artToAttr->setAttribute($attribute);

        $entity1
            ->setId('id1235')
            ->setActive(true)
            ->setArtNum('abc123')
            ->setTitle('Any title')
            ->setShortDesc('Short description')
            ->setPrice(13.34)
            ->setTPrice(44.21)
            ->setExtension($extension)
            ->setStock(5)
            ->setStockFlag(1)
            ->addAttribute($artToAttr)
            ->setParent($parent);

        /** @var ArticleExtension $extension */
        $extension = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleExtension');
        $extension->setLongDesc('Long description2');

        /** @var Article $entity2 */
        $entity2 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');

        $attribute = new Attribute();
        $attribute->setId(126);
        $attribute->setPos(1);
        $attribute->setTitle('testAttributeTitle2');
        $artToAttr = new ArticleToAttribute();
        $artToAttr->setId(3211);
        $artToAttr->setPos(1);
        $artToAttr->setArticle($entity2);
        $artToAttr->setAttribute($attribute);

        $entity2
            ->setId('id1234')
            ->setActive(false)
            ->setArtNum('abc1234')
            ->setTitle('Any title2')
            ->setShortDesc('Short description2')
            ->setPrice(13.34)
            ->setTPrice(44.21)
            ->setExtension($extension)
            ->setStock(6)
            ->setStockFlag(1)
            ->addAttribute($artToAttr)
            ->setParent($parent);

        return [$entity1, $entity2];
    }

    /**
     * @return VariantObject[]
     */
    private function getExpectedVariants()
    {
        $variant1 = new VariantObject();

        $attObj = new AttributeObject();
        $attObj->setPos(1);
        $attObj->setTitle('testAttributeTitle');

        $variant1
            ->setId('id1235')
            ->setActive(true)
            ->setOldPrice(44.21)
            ->setStock(5)
            ->setAttributes([$attObj])
            ->setTitle('Any title')
            ->setDescription('Short description')
            ->setLongDescription('Long description')
            ->setSku('abc123')
            ->setPrice(13.34);

        $variant2 = new VariantObject();

        $attObj = new AttributeObject();
        $attObj->setPos(1);
        $attObj->setTitle('testAttributeTitle2');

        $variant2
            ->setId('id1234')
            ->setActive(false)
            ->setOldPrice(44.21)
            ->setStock(6)
            ->setAttributes([$attObj])
            ->setTitle('Any title2')
            ->setDescription('Short description2')
            ->setLongDescription('Long description2')
            ->setSku('abc1234')
            ->setPrice(13.34);

        return [$variant1, $variant2];
    }
}
