<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Modifier\Traits;

/**
 * Trait used for modifiers which require custom queries.
 *
 * It's used to find out which entity is currently active
 */
trait EntityAliasAwareTrait
{
    /**
     * Specifies the current working entity.
     *
     * @var string $entityAlias
     */
    private $entityAlias;

    /**
     * Sets entity alias.
     *
     * @param string $entityAlias
     */
    public function setEntityAlias($entityAlias)
    {
        $this->entityAlias = $entityAlias;
    }

    /**
     * Return entity alias.
     *
     * @return string
     */
    public function getEntityAlias()
    {
        return $this->entityAlias;
    }
}
