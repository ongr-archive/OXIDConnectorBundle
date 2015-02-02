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

use ONGR\OXIDConnectorBundle\Modifier\Traits\EntityAliasAwareTrait;

class EntityAliasAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityAliasAwareTrait
     */
    private $entityAliasAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->entityAliasAwareTrait = $this
            ->getObjectForTrait('ONGR\OXIDConnectorBundle\Modifier\Traits\EntityAliasAwareTrait');
    }

    /**
     * Testing that trait has empty value.
     */
    public function testTraitIsEmpty()
    {
        $this->assertAttributeEmpty('entityAlias', $this->entityAliasAwareTrait);
    }

    /**
     * Test LanguageId setter and getter.
     */
    public function testSetLanguageId()
    {
        $this->entityAliasAwareTrait->setEntityAlias('alias');

        $this->assertEquals('alias', $this->entityAliasAwareTrait->getEntityAlias());
    }
}
