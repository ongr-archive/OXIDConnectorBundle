<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity for articles mapped in table "oxobject2category".
 *
 * @ORM\MappedSuperclass
 */
abstract class ArticleToCategory extends ObjectToCategory
{
    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="categories")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="OXOBJECTID", referencedColumnName="OXID")
     * })
     */
    protected $article;

    /**
     * Sets article object.
     *
     * @param Article $article
     *
     * @return ArticleToCategory
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Returns article object.
     *
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
