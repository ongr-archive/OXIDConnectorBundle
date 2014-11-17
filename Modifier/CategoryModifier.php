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
use ONGR\ElasticsearchBundle\Document\DocumentInterface;
use ONGR\OXIDConnectorBundle\Entity\Category;

/**
 * Converts OXID category to ONGR category document.
 */
class CategoryModifier implements ModifierInterface
{
    /**
     * {@inheritdoc}
     */
    public function modify(DocumentInterface $document, $entity, $type = DataCollectorInterface::TYPE_FULL)
    {
        /** @var Category $entity */

        $document->active = $entity->isActive();
        $document->hidden = $entity->isHidden();
        $document->id = $entity->getId();
        $document->left = $entity->getLeft();
        $document->right = $entity->getRight();
        $document->parentid = $entity->getParent()->getId();
        $document->rootid = $entity->getRoot()->getId();
        $document->sort = $entity->getSort();
        $document->title = $entity->getTitle();
    }
}
