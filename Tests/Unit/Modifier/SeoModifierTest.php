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

use Doctrine\ORM\EntityManager;
use ONGR\TestingBundle\Document\Product;
use ONGR\OXIDConnectorBundle\Modifier\SeoModifier;
use ONGR\OXIDConnectorBundle\Entity\ObjectToSeoData;
use ONGR\OXIDConnectorBundle\Entity\Article;
use Doctrine\ORM\Query;

class SeoModifierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get entity manager mock
     *
     * @param $returnValue
     * @return \PHPUnit_Framework_MockObject_MockObject | EntityManager
     */
    protected function getEntityManagerMock($returnValue)
    {
        $emMock  = $this->getMock(
            'Doctrine\ORM\EntityManagerInterface'
        );

        $queryMock = $this->getMock(
            '\StdClass',
            ['getResult', 'setParameter']
        );

        $emMock->expects($this->any())->method('createQuery')->will($this->returnValue($queryMock));
        $queryMock->expects($this->any())->method('setParameter')->will($this->returnSelf());
        $queryMock->expects($this->any())->method('getResult')->will($this->returnValue([$returnValue]));

        return $emMock;
    }

    /**
     * Data for testModify
     *
     * @return array
     */
    public function testModifyData()
    {
        #0 default mapping
        $expectedDocument = new Product();
        $expectedDocument->metaKeywords = 'testKeywords';
        $expectedDocument->metaDescription = 'testDescription';
        $out[] = [$expectedDocument];

        #1 custom mapping
        $expectedDocument = new Product();
        $expectedDocument->metaKeywordsTest = 'testKeywords';
        $expectedDocument->metaDescriptionTest = 'testDescription';
        $customMapping = ['getKeywords' => 'metaKeywordsTest', 'getDescription' => 'metaDescriptionTest'];
        $out[] = [$expectedDocument, $customMapping];

        return $out;
    }

    /**
     * Test for testModify
     *
     * @dataProvider testModifyData
     *
     * @param ProductModel $expectedDocument
     * @param array $customMapping
     */
    public function testModify(Product $expectedDocument, array $customMapping = null)
    {
        /** @var ObjectToSeoData $seoData */
        $seoData = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ObjectToSeoData');
        $seoData->setDescription('testDescription');
        $seoData->setKeywords('testKeywords');

        $modifier = new SeoModifier($this->getEntityManagerMock($seoData), $customMapping);

        /** @var Article $entity */
        $entity = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');
        $entity->setId('id123');

        $document = new Product();
        $modifier->modify($document, $entity);

        $this->assertEquals($expectedDocument, $document);
    }
}
