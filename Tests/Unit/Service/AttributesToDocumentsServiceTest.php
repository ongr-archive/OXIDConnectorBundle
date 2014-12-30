<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Service;

use Doctrine\Common\Collections\ArrayCollection;
use ONGR\OXIDConnectorBundle\Service\AttributesToDocumentsService;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Article;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\ArticleToAttribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Attribute;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\Category;
use ONGR\OXIDConnectorBundle\Tests\Functional\Entity\CategoryToAttribute;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class AttributesToDocumentsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AttributesToDocumentsService
     */
    private $service;

    /**
     * Set up services.
     */
    protected function setUp()
    {
        $this->service = new AttributesToDocumentsService();
    }

    /**
     * Test method for categories.
     */
    public function testTransformCategoryToDocument()
    {
        $attributes = new ArrayCollection();
        $expected = [];
        /** @var Category|MockObject $mockCategory */
        $mockCategory = $this->getMockForAbstractClass('\ONGR\OXIDConnectorBundle\Entity\Category');

        for ($i = 1; $i <= 10; $i++) {
            $catToAttr = new CategoryToAttribute();
            $catToAttr->setId($i);
            $catToAttr->setSort($i);
            $catToAttr->setCategory($mockCategory);
            $attr = new Attribute();
            $attr->setPos($i);
            $attr->setTitle('Some title ' . $i);
            $catToAttr->setAttribute($attr);
            $attributes->add($catToAttr);
            $expected[] = $catToAttr;
        }

        $result = $this->service->transform($attributes);
        foreach ($result as $idx => $actual) {
            $this->assertInstanceOf('\ONGR\OXIDConnectorBundle\Document\AttributeObject', $actual);
            $this->assertEquals('Some title ' . ($idx + 1), $actual->getTitle());
            $this->assertEquals($idx + 1, $actual->getPos());
        }
    }

    /**
     * Test method for articles.
     */
    public function testTransformArticleToDocument()
    {
        $attributes = new ArrayCollection();
        $expected = [];
        /** @var Article|MockObject $mockArticle */
        $mockArticle = $this->getMockForAbstractClass('\ONGR\OXIDConnectorBundle\Entity\Article');

        for ($i = 1; $i <= 10; $i++) {
            $artToAttr = new ArticleToAttribute();
            $artToAttr->setId($i);
            $artToAttr->setPos($i);
            $artToAttr->setArticle($mockArticle);
            $attr = new Attribute();
            $attr->setPos($i + 2);
            $attr->setTitle('Some other title ' . $i);
            $artToAttr->setAttribute($attr);
            $attributes->add($artToAttr);
            $expected[] = $artToAttr;
        }

        $result = $this->service->transform($attributes);
        foreach ($result as $idx => $actual) {
            $this->assertInstanceOf('\ONGR\OXIDConnectorBundle\Document\AttributeObject', $actual);
            $this->assertEquals('Some other title ' . ($idx + 1), $actual->getTitle());
            $this->assertEquals($idx + 3, $actual->getPos());
        }
    }

    /**
     * Test transform with non-traversable entity.
     */
    public function testTransformNonTraversable()
    {
        $entity = new Attribute();
        $this->assertEquals([], $this->service->transform($entity));
    }
}
