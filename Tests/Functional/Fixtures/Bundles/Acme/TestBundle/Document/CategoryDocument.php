<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Fixtures\Bundles\Acme\TestBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\OXIDConnectorBundle\Document\CategoryDocument as ParentDocument;
use ONGR\RouterBundle\Document\UrlObject;

/**
 * Category document.
 *
 * @ES\Document(type="category")
 */
class CategoryDocument extends ParentDocument
{
}
