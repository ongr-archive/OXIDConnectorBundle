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
 * Trait used for modifiers which require shop id in queries.
 *
 * It's used to select data by the specified shop
 */
trait ShopAwareTrait
{
    /**
     * @var int Specifies the shop used in queries.
     */
    private $shopId;

    /**
     * Sets the current shop.
     *
     * @param int $shopId
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * Return shop.
     *
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }
}
