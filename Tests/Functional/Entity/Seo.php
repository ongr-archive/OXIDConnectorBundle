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
use ONGR\OXIDConnectorBundle\Entity\Seo as ParentSeo;

/**
 * A class to test ONGR\OXIDConnectorBundle\Entity\Seo abstract class
 *
 * @ORM\Entity
 * @ORM\Table(name="oxseo")
 */
class Seo extends ParentSeo
{
}
