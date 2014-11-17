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

use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ArticleExtension;
use ONGR\OXIDConnectorBundle\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\Manufacturer;
use ONGR\OXIDConnectorBundle\Entity\Vendor;
use ONGR\TestingBundle\Document\Product;
use ONGR\OXIDConnectorBundle\Modifier\ProductModifier;

class ProductModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for modify().
     */
    public function testModify()
    {
        $modifier = new ProductModifier();

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
            ->setManufacturer($manufacturer);

        $expectedDocument = new Product();
        $expectedDocument->id = 'id123';
        $expectedDocument->active = true;
        $expectedDocument->sku = 'abc123';
        $expectedDocument->title = 'Any title';
        $expectedDocument->description = 'Short description';
        $expectedDocument->price = 12.34;
        $expectedDocument->oldPrice = 43.21;
        $expectedDocument->longDescription = 'Long description';
        $expectedDocument->categories = ['activeCategoryId'];
        $expectedDocument->parentId = 'parentId';
        $expectedDocument->stock = 5;
        $expectedDocument->vendor = 'Vendor A';
        $expectedDocument->manufacturer = 'Manufacturer A';

        $document = new Product();
        $modifier->modify($document, $entity);

        $this->assertEquals($expectedDocument, $document);
    }
}
