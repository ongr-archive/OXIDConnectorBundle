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

use ONGR\ConnectionsBundle\Pipeline\Item\ImportItem;
use ONGR\OXIDConnectorBundle\Document\AttributeObject;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument;
use ONGR\OXIDConnectorBundle\Document\ProductDocument;
use ONGR\OXIDConnectorBundle\Entity\ArticleExtension;
use ONGR\OXIDConnectorBundle\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Entity\Manufacturer;
use ONGR\OXIDConnectorBundle\Entity\Vendor;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;
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
            ->setParent($parent)
            ->setStock(5)
            ->setStockFlag(1)
            ->setVendor($vendor)
            ->setManufacturer($manufacturer)
            ->addAttribute($artToAttr);

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
        $expectedDocument->setParent('parentId');
        $expectedDocument->setStock(5);
        $expectedDocument->setVendor('Vendor A');
        $expectedDocument->setManufacturer('Manufacturer A');
        $attObj = new AttributeObject();
        $attObj->setPos(1);
        $attObj->setTitle('testAttributeTitle');
        $expectedDocument->setAttributes([$attObj]);

        $document = new ProductDocument();
        $this->modifier->modify(new ImportItem($entity, $document));

        $this->assertEquals($expectedDocument, $document);
    }
}
