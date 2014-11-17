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

use Doctrine\ORM\EntityManager;
use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\ArticleToCategory;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\Seo;
use ONGR\OXIDConnectorBundle\Entity\SeoHistory;
use ONGR\OXIDConnectorBundle\Service\SeoUrlService;

/**
 * This class holds unit tests for seo url service.
 */
class SeoUrlServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get entity manager mock.
     *
     * @param array $returnValueActive
     * @param array $returnValueHistory
     *
     * @return \PHPUnit_Framework_MockObject_MockObject | EntityManager
     */
    protected function getEntityManagerMock($returnValueActive, $returnValueHistory)
    {
        $emMock = $this->getMock(
            'Doctrine\ORM\EntityManagerInterface'
        );

        $queryMockActive = $this->getMock(
            '\StdClass',
            ['getResult', 'setParameter']
        );

        $queryMockExpired = $this->getMock(
            '\StdClass',
            ['getResult', 'setParameter']
        );

        $emMock->expects($this->any())->method('createQuery')->will(
            $this->returnValueMap(
                [
                    ['SELECT h FROM ONGROXIDConnectorBundle:SeoHistory h WHERE h.objectId = :id', $queryMockExpired],
                    ['SELECT s FROM ONGROXIDConnectorBundle:Seo s WHERE s.objectId = :id', $queryMockActive],
                ]
            )
        );

        $queryMockExpired->expects($this->any())->method('setParameter')->will($this->returnSelf());
        $queryMockExpired->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue($returnValueHistory));

        $queryMockActive->expects($this->any())->method('setParameter')->will($this->returnSelf());
        $queryMockActive->expects($this->any())
            ->method('getResult')
            ->will($this->returnValue($returnValueActive));

        return $emMock;
    }

    /**
     * Data for testModify.
     *
     * @return array
     */
    public function testModifyData()
    {
        // Case #0 one prioritized url and a few expired urls.

        /** @var Category $mainCategory */
        $mainCategory = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Category');
        $mainCategory->setId('prioritizedKey');

        /** @var ArticleToCategory $objToCatPrio */
        $objToCatPrio = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\ArticleToCategory');
        $objToCatPrio->setCategory($mainCategory);

        /** @var SeoHistory $seoExpired */
        $seoExpired = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\SeoHistory');
        $seoExpired->setIdent('1f7c2ad5fb974d30234a08b41769b4bf');

        /** @var SeoHistory $seoExpired1 */
        $seoExpired1 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\SeoHistory');
        $seoExpired1->setIdent('1aa5a628fcfb26e7586fa314eb84995a');

        /** @var Seo $seoActive */
        $seoActive = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive->setSeoUrl('/test/seo/Active/0');
        $seoActive->setParams('testKey0');

        /** @var Seo $seoActive1 */
        $seoActive1 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive1->setSeoUrl('/test/seo/Active/1');
        $seoActive1->setParams('testKey1');

        /** @var Seo $seoActive2 */
        $seoActive2 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive2->setSeoUrl('/test/seo/Active/2/prioritized');
        $seoActive2->setParams('prioritizedKey');

        $activeSeos = [$seoActive, $seoActive1, $seoActive2];
        $expiredSeos = [$seoExpired, $seoExpired1];
        $expectedUrls = [
            ['url' => '/test/seo/Active/2/prioritized', 'key' => 'prioritizedKey'],
            ['url' => '/test/seo/Active/0', 'key' => 'testKey0'],
            ['url' => '/test/seo/Active/1', 'key' => 'testKey1'],
        ];
        $expectedExpiredUrls = ['1f7c2ad5fb974d30234a08b41769b4bf', '1aa5a628fcfb26e7586fa314eb84995a'];
        $out[] = [$activeSeos, $expiredSeos, [$objToCatPrio], $expectedUrls, $expectedExpiredUrls];

        // Case #1 no prioritized URLs.
        /** @var Seo $seoActive */
        $seoActive = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive->setSeoUrl('/test/seo/Active/0');
        $seoActive->setParams('testKey0');

        /** @var Seo $seoActive1 */
        $seoActive1 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive1->setSeoUrl('/test/seo/Active/1');
        $seoActive1->setParams('testKey1');

        /** @var Seo $seoActive2 */
        $seoActive2 = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Seo');
        $seoActive2->setSeoUrl('/test/seo/Active/2');
        $seoActive2->setParams('testKey2');

        $activeSeos = [$seoActive, $seoActive2, $seoActive1];
        $expectedUrls = [
            [ 'url' => '/test/seo/Active/0', 'key' => 'testKey0'],
            [ 'url' => '/test/seo/Active/2', 'key' => 'testKey2'],
            [ 'url' => '/test/seo/Active/1', 'key' => 'testKey1'],
        ];
        $expectedExpiredUrls = [];
        $out[] = [$activeSeos, [], [], $expectedUrls, $expectedExpiredUrls];

        return $out;
    }

    /**
     * Test for testModify.
     *
     * @param array               $activeSeos
     * @param array               $expiredSeos
     * @param ArticleToCategory[] $categories
     * @param array               $expectedUrls
     * @param array               $expectedExpired
     *
     * @dataProvider testModifyData
     */
    public function testModify(
        array $activeSeos,
        array $expiredSeos,
        array $categories,
        array $expectedUrls,
        array $expectedExpired
    ) {
        $service = new SeoUrlService($this->getEntityManagerMock($activeSeos, $expiredSeos));
        $service->setEntityAlias('ONGROXIDConnectorBundle');

        /** @var Article $entity */
        $entity = $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article');
        foreach ($categories as $category) {
            $entity->addCategory($category);
        }

        $this->assertEquals($expectedUrls, $service->getActiveUrlList($entity));
        $this->assertEquals($expectedExpired, $service->getSeoHistoryHashes($entity));
    }
}
