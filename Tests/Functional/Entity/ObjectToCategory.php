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

use ONGR\OXIDConnectorBundle\Entity\ObjectToCategory as ParentObjectToCategory;

/**
 * A class to test ONGR\OXIDConnectorBundle\Entity\ObjectToCategory abstract class.
 *
 * @ORM\Entity
 * @ORM\Table(name="oxobject2category")
 */
class ObjectToCategory extends ParentObjectToCategory
{
}
