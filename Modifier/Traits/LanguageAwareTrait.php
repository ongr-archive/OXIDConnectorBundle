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
 * Trait used for modifiers which require language id in queries.
 *
 * It's used to select data by the specified language
 */
trait LanguageAwareTrait
{
    /**
     * Specifies the language used in queries.
     *
     * @var int $languageId
     */
    private $languageId;

    /**
     * Sets the current language.
     *
     * @param int $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * Return language.
     *
     * @return int
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }
}
