<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Unit\Modifier\Traits;

use Doctrine\ORM\EntityManager;
use ONGR\OXIDConnectorBundle\Modifier\SeoModifier;
use ONGR\OXIDConnectorBundle\Modifier\Traits\LanguageAwareTrait;

class LanguageAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LanguageAwareTrait
     */
    protected $languageTrait;

    /**
     * Set up LanguageAwareTrait object
     */
    public function setUp()
    {
        $this->languageTrait = $this->getObjectForTrait('ONGR\OXIDConnectorBundle\Modifier\Traits\LanguageAwareTrait');
    }

    /**
     * Testing that trait has empty value
     */
    public function testTraitIsEmpty()
    {
        $this->assertAttributeEmpty('languageId', $this->languageTrait);
    }

    /**
     * Test LanguageId setter and getter
     */
    public function testSetLanguageId()
    {
        $this->languageTrait->setLanguageId(1);

        $this->assertEquals(1, $this->languageTrait->getLanguageId());
    }
}
