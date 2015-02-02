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
use ONGR\OXIDConnectorBundle\Document\ContentDocument as ParentDocument;
use ONGR\RouterBundle\Document\UrlObject;

/**
 * Content document.
 *
 * @ES\Document(type="content")
 */
class ContentDocument extends ParentDocument
{
    /**
     * @return \Iterator|UrlObject[]
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param \Iterator|UrlObject[] $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getExpiredUrl()
    {
        return $this->expiredUrl;
    }

    /**
     * @param string[] $expiredUrl
     *
     * @return $this
     */
    public function setExpiredUrl($expiredUrl)
    {
        $this->expiredUrl = $expiredUrl;

        return $this;
    }
}
