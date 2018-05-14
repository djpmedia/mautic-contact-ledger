<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic Community
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticContactLedgerBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;

/**
 * Class LedgerEntryRepository.
 */
class CampaignSourceStatsRepository extends CommonRepository
{
    /**
     * @param $dollarValue
     *
     * @return string
     */
    public static function formatDollar($dollarValue)
    {
        return sprintf('%19.4f', floatval($dollarValue));
    }

    /**
     * @return string
     */
    public function getTableAlias()
    {
        return 'css';
    }

    /**
     * Gets the ID of the latest ID.
     *
     * @return int
     */
    public function getMaxId()
    {
        $result = $this->getEntityManager()->getConnection()->createQueryBuilder()
            ->select('max(id) AS id')
            ->from(MAUTIC_TABLE_PREFIX.'contact_ledger_campaign_source_stats', 'css')
            ->execute()->fetchAll();

        return $result[0]['id'];
    }

    /**
     * Gets the ID of the latest ID.
     *
     * @return int
     */
    public function getLastEntity()
    {
        $entity = null;
        $result = $this->getMaxId();

        if (isset($result)) {
            $entity = $this->getEntity($result);
        }

        return $entity;
    }

    /**
     * @param $params
     * @param true $
     * @param $cache_dir
     *
     * @return array
     */
    public function getDashboardRevenueWidgetData($params, $bySource = false, $cache_dir = __DIR__)
    {
        $results = [];
        $query   = $this->getEntityManager()->getConnection()->createQueryBuilder()
            ->select(
                'c.is_published as active,
                css.campaign_id,
            c.name as name,
            SUM(css.received) as received,
            SUM(css.scrubbed) as scrubbed,
            SUM(css.declined) as declined,
            SUM(css.converted) as converted,
            SUM(css.revenue) as revenue,
            SUM(css.cost) as cost'
            )
            ->from(MAUTIC_TABLE_PREFIX.'contact_ledger_campaign_source_stats', 'css')
            ->join('css', MAUTIC_TABLE_PREFIX.'campaigns', 'c', 'c.id = css.campaign_id')
            ->join('css', MAUTIC_TABLE_PREFIX.'contactsource', 'cs', 'cs.id = css.contact_source_id')
            ->where('css.date_added BETWEEN :dateFrom AND :dateTo')
            ->groupBy('css.campaign_id')
            ->orderBy('c.name', 'ASC');

        if ($bySource) {
            $query->addSelect(
                'css.contact_source_id as sourceid,
            cs.name as sourcename'
            );
            $query->addGroupBy('css.contact_source_id');
        }
        $query
            ->setParameter('dateFrom', $params['dateFrom'])
            ->setParameter('dateTo', $params['dateTo']);

        $financials = $query->execute()->fetchAll();
        foreach ($financials as $financial) {
            $financial['revenue']      = number_format(floatval($financial['revenue']), 2, '.', ',');
            $financial['cost']         = number_format(floatval($financial['cost']), 2, '.', ',');
            $financial['gross_income'] = number_format(
                (float) $financial['revenue'] - (float) $financial['cost'],
                2,
                '.',
                ','
            );

            if ($financial['gross_income'] > 0) {
                $financial['gross_margin'] = number_format(
                    100 * $financial['gross_income'] / $financial['revenue'],
                    0,
                    '.',
                    ','
                );
                $financial['ecpm']         = number_format((float) $financial['gross_income'] / 1000, 4, '.', ',');
            } else {
                $financial['gross_margin'] = 0;
                $financial['ecpm']         = 0;
            }

            $result = [
                $financial['active'],
                $financial['campaign_id'],
                $financial['name'],
            ];
            if ($bySource) {
                $result[] = $financial['sourcid'];
                $result[] = $financial['sourcename'];
            }
            $result[] = $financial['received'];
            $result[] = $financial['scrubbed'];
            $result[] = $financial['declined'];
            $result[] = $financial['converted'];
            $result[] = $financial['revenue'];
            $result[] = $financial['cost'];
            $result[] = $financial['gross_income'];
            $result[] = $financial['gross_margin'];
            $result[] = $financial['ecpm'];

            $results['rows'][] = $result;
        }

        return $results;
    }
}
