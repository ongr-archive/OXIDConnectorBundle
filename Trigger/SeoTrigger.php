<?php

/*
* This file is part of the ONGR package.
*
* (c) NFQ Technologies UAB <info@nfq.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ONGR\OXIDConnectorBundle\Trigger;

use ONGR\ConnectionsBundle\DataCollector\DataCollectorInterface;
use ONGR\ConnectionsBundle\Sync\Trigger\ComposedTrigger;

/**
 * Seo trigger, only inserts item updates, not seo itself.
 */
class SeoTrigger extends ComposedTrigger
{
    /**
     * @param null|string $table
     * @param null|string $type
     * @param array       $trackFields
     */
    public function __construct($table, $type, $trackFields = [])
    {
        parent::__construct($table, $type, DataCollectorInterface::TYPE_PARTIAL, null, null, $trackFields);
    }

    /**
     * Generates Insert statement.
     *
     * @inheritdoc
     *
     * @return string
     */
    protected function generateInsertStatement()
    {
        $out = '';

        foreach ($this->statements as $statement) {
            $out .= $statement->getJobInsertSql($this->getJobTableName());
        }

        return $out;
    }
}
