<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Modifier;

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Doctrine\Modifier\ModifierInterface;
use ONGR\OXIDConnectorBundle\Service\SeoUrlService;
use ONGR\ElasticsearchBundle\Document\DocumentInterface;

/**
 * Gets URLs for new entities from OXID
 */
class SeoUrlModifier implements ModifierInterface
{
    /**
     * @var SeoUrlService
     */
    protected $seoUrlService;

    /**
     * Constructor
     *
     * @param SeoUrlService $seoUrlService
     */
    public function __construct(SeoUrlService $seoUrlService)
    {
        $this->seoUrlService = $seoUrlService;
    }

    /**
     * {@inheritDoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        $document->url = $this->seoUrlService->getActiveUrlList($entity);
        $document->expired_url = $this->seoUrlService->getSeoHistoryHashes($entity);
    }
}
