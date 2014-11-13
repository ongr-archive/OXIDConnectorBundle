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

use Doctrine\ORM\Query;
use ONGR\OXIDConnectorBundle\Modifier\SeoUrlModifier;
use ONGR\TestingBundle\Document\Product;

/**
 * This class holds unit tests for seo modifier
 */
class SeoUrlModifierTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if modify method works as expected
     */
    public function testModify()
    {
        $service = $this->getMockBuilder('ONGR\OXIDConnectorBundle\Service\SeoUrlService')
            ->disableOriginalConstructor()->setMethods(['getActiveUrlList', 'getSeoHistoryHashes'])->getMock();
        $service->expects($this->any())->method('getActiveUrlList')->will($this->returnValue([['url' => 'fresh/url']]));
        $service->expects($this->any())->method('getSeoHistoryHashes')->will($this->returnValue(['abcd']));

        $doc = new Product();
        $modifier = new SeoUrlModifier($service);
        $modifier->modify($doc, $this->getMockForAbstractClass('ONGR\OXIDConnectorBundle\Entity\Article'));

        $expected = new Product();
        $expected->url = [['url' => 'fresh/url']];
        $expected->expired_url = ['abcd'];

        $this->assertEquals($expected, $doc);
    }
}
