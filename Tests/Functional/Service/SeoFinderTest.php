<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Service;

use ONGR\OXIDConnectorBundle\Entity\Article;
use ONGR\OXIDConnectorBundle\Entity\Category;
use ONGR\OXIDConnectorBundle\Entity\Content;
use ONGR\OXIDConnectorBundle\Service\SeoFinder;
use ONGR\OXIDConnectorBundle\Tests\Functional\AbstractTestCase;

/**
 * Class SeoFinderTest.
 */
class SeoFinderTest extends AbstractTestCase
{
    /**
     * @var SeoFinder
     */
    protected $seoFinder;

    /**
     * Prepare Seo Finder.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->seoFinder = new SeoFinder();
        $this->seoFinder->setEntityManager($this->getEntityManager());
        $this->seoFinder->setRepository('ONGROXIDConnectorBundleTest:Seo');
        $this->seoFinder->setShopId(0);
    }

    /**
     * Data provider for testUrls.
     *
     * @return array
     */
    public function urlsTestProvider()
    {
        return [
            // Case #0. Product - all languages.
            [
                'repository' => 'ONGROXIDConnectorBundleTest:Article',
                'expectedUrls' => [
                    '6b698c33118caee4ca0882c33f513d2f' => ['Test/Product/1', 'en/Test/Product/1'],
                    '6b6a6aedca3e438e98d51f0a5d586c0b' => ['Test/Product/2', 'en/Test/Product/2'],
                ],
                'language' => null,
            ],
            // Case #1. Product - language 0.
            [
                'repository' => 'ONGROXIDConnectorBundleTest:Article',
                'expectedUrls' => [
                    '6b698c33118caee4ca0882c33f513d2f' => ['Test/Product/1'],
                    '6b6a6aedca3e438e98d51f0a5d586c0b' => ['Test/Product/2'],
                ],
                'language' => 0,
            ],
            // Case #2. Product - language 1.
            [
                'repository' => 'ONGROXIDConnectorBundleTest:Article',
                'expectedUrls' => [
                    '6b698c33118caee4ca0882c33f513d2f' => ['en/Test/Product/1'],
                    '6b6a6aedca3e438e98d51f0a5d586c0b' => ['en/Test/Product/2'],
                ],
                'language' => 1,
            ],
            // Case #3. Content - all languages.
            [
                'repository' => 'ONGROXIDConnectorBundleTest:Content',
                'expectedUrls' => [
                    '8709e45f31a86909e9f999222e80b1d0' => ['Test/Content/1', 'en/Test/Content/1'],
                    'ad542e49bff479009.64538090' => ['Test/Content/2', 'en/Test/Content/2'],
                ],
                'language' => null,
            ],
            // Case #4. Category - all languages.
            [
                'repository' => 'ONGROXIDConnectorBundleTest:Category',
                'expectedUrls' => [
                    'fada9485f003c731b7fad08b873214e0' => ['Test/Category/1', 'en/Test/Category/1'],
                    '0f41a4463b227c437f6e6bf57b1697c4' => ['Test/Category/2', 'en/Test/Category/2'],
                ],
                'language' => null,
            ],
        ];
    }

    /**
     * Tests if correct urls are collected.
     *
     * @param string   $repository
     * @param string[] $expectedUrls
     * @param int|null $language
     *
     * @dataProvider urlsTestProvider
     */
    public function testUrls($repository, $expectedUrls, $language)
    {
        $repository = $this->getEntityManager()->getRepository($repository);
        /** @var Category|Article|Content $entity */
        foreach ($repository->findAll() as $entity) {
            $seos = $this->seoFinder->getEntitySeo($entity, $language);
            $urls = [];
            foreach ($seos as $seo) {
                $urls[] = $seo->getSeoUrl();
            }
            sort($urls);
            sort($expectedUrls[$entity->getId()]);
            $this->assertSame($expectedUrls[$entity->getId()], $urls);
        }
    }
}
