<?php

namespace MauticPlugin\MauticContactLedgerBundle\Entity;

use Mautic\CoreBundle\Entity\CommonRepository;
use Mautic\LeadBundle\Entity\Lead;

/**
 * Class EntryRepository extends {@see \Mautic\CoreBundle\Entity\CommonRepository}.
 */
class EntryRepository extends CommonRepository
{
    /**
     * Defines default table alias for contact_ledger table.
     *
     * @return string
     */
    public function getTableAlias()
    {
        return 'cl';
    }

    /**
     * @param \Mautic\LeadBundle\Entity\Lead $contact
     *
     * @return Entry[] An array of ledger entries
     */
    public function getContactLedger(Lead $contact)
    {
    }

    /**
     * @param \Mautic\LeadBundle\Entity\Lead $contact
     *
     * @return float COGS for contact
     */
    public function getContactCost(Lead $contact)
    {
    }

    /**
     * @param \Mautic\LeadBundle\Entity\Lead $contact
     *
     * @return float gross revenue generated by contact
     */
    public function getContactRevenue(Lead $contact)
    {
    }
}
