<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Tests\Functional\Entity;

use Doctrine\ORM\Mapping as ORM;
use ONGR\OXIDConnectorBundle\Entity\ArticleToAttribute as ParentArticleToAttribute;

/**
 * A class to test ONGR\OXIDConnectorBundle\Entity\ArticleToAttribute abstract class
 *
 * @ORM\Entity
 * @ORM\Table(name="oxobject2attribute")
 */
class ArticleToAttribute extends ParentArticleToAttribute
{
}
