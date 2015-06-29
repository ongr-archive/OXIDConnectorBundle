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

use ONGR\OXIDConnectorBundle\Service\SeoFinder;

/**
 * Class SeoFinderTest.
 */
class SeoFinderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if exception is thrown on invalid argument.
     */
    public function testException()
    {
        $instance = new SeoFinder();

        $this->setExpectedException('InvalidArgumentException');
        $instance->getEntitySeo(new \stdClass());
    }

    /**
     * Tests getting manager before it is set.
     */
    public function testException2()
    {
        $instance = new SeoFinder();

        $this->setExpectedException('LogicException', 'setEntityManager must be called before getEntityManager');
        $instance->getEntityManager();
    }
}
