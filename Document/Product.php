<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\TestingBundle\Document\Product as TestingProduct;

/**
 * Product document for testing.
 */
class Product extends TestingProduct
{
    /**
     * @var string
     *
     * @ES\Property(type="string", name="vendor")
     */
    public $vendor;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="long_description")
     */
    public $longDescription;

    /**
     * @var string
     *
     * @ES\Property(type="string", name="manufacturer")
     */
    public $manufacturer;
}
