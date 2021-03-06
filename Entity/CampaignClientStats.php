<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Digital Media Solutions, LLC
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticContactLedgerBundle\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Mautic\CampaignBundle\Entity\Campaign;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\CommonEntity;

/**
 * Class CampaignClientStats.
 */
class CampaignClientStats extends CommonEntity
{
    /**
     * @var int primary key read-only
     */
    protected $id;

    /**
     * @var \DateTime time entry was made
     */
    protected $dateAdded;

    /**
     * @var int
     */
    protected $campaignId;

    /**
     * @var \Mautic\CampaignBundle\Entity\Campaign
     */
    protected $campaign;

    /**
     * @var bool
     */
    protected $isPublished;

    /**
     * @var int
     */
    protected $contactClientId;

    /**
     * @var string|float
     */
    protected $cost;

    /**
     * @var string|float
     */
    protected $revenue;

    /**
     * @var string|float
     */
    protected $grossIncome;

    /**
     * @var string|float
     */
    protected $margin;

    /**
     * @var string|float
     */
    protected $ecpm;

    /**
     * @var string|float
     */
    protected $received;

    /**
     * @var string|float
     */
    protected $declined;

    /**
     * @var string|float
     */
    protected $converted;

    /**
     * @var string|float
     */
    protected $utmSource;

    /**
     * @var bool
     */
    protected $reprocessFlag;

    public function __set($field, $value)
    {
        if (property_exists($this, $field)) {
            $this->$field = $value;
        }
    }

    /**
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata
     */
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('contact_ledger_campaign_client_stats')
            ->setCustomRepositoryClass(
                'MauticPlugin\MauticContactLedgerBundle\Entity\CampaignClientStatsRepository'
            );

        $builder->addId();
        $builder->addDateAdded();

        $builder->createField('campaignId', 'integer')
            ->columnName('campaign_id')
            ->nullable()
            ->build();

        $builder->createField('contactClientId', 'integer')
            ->columnName('contact_client_id')
            ->nullable()
            ->build();

        $builder->createField('cost', 'decimal')
            ->precision(19)
            ->scale(4)
            ->nullable()
            ->build();

        $builder->createField('revenue', 'decimal')
            ->precision(19)
            ->scale(4)
            ->nullable()
            ->build();

        $builder->createField('grossIncome', 'decimal')
            ->columnName('gross_income')
            ->precision(19)
            ->scale(4)
            ->nullable()
            ->build();

        $builder->createField('margin', 'decimal')
            ->precision(19)
            ->scale(4)
            ->nullable()
            ->build();

        $builder->createField('ecpm', 'decimal')
            ->precision(19)
            ->scale(4)
            ->nullable()
            ->build();

        $builder->createField('received', 'integer')
            ->columnName('received')
            ->nullable()
            ->build();

        $builder->createField('declined', 'integer')
            ->columnName('declined')
            ->nullable()
            ->build();

        $builder->createField('converted', 'integer')
            ->columnName('converted')
            ->nullable()
            ->build();

        $builder->createField('utmSource', 'string')
            ->columnName('utm_source')
            ->build();

        $builder->createField('reprocessFlag', 'boolean')
            ->columnName('reprocess_flag')
            ->build();

        $builder->addIndex(['campaign_id', 'contact_client_id', 'utm_source'], 'idx_campaign_client_utm')
            ->addIndex(['date_added'], 'idx_dateadded');

        $builder->addUniqueConstraint(['campaign_id', 'contact_client_id', 'utm_source', 'date_added'], 'unique_dupe_insert');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string when the entry was added
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param string $dateAdded
     *
     * @return $this
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * @return int
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param \Mautic\CampaignBundle\Entity\Campaign|int $campaignId
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setCampaignId($campaignId)
    {
        if ($campaignId instanceof Campaign) {
            $this->setCampaign($campaignId);
        } elseif (\is_int($campaignId)) {
            $this->campaignId = $campaignId;
        } else {
            throw new \InvalidArgumentException(
                '$campaign must be an integer or instance of "\\Mautic\\CampaignBundle\\Entity\\Campaign"'
            );
        }

        return $this;
    }

    /**
     * @return int|Campaign
     */
    public function getCampaign()
    {
        if (null !== $this->campaign) {
            return $this->campaign;
        }

        return $this->campaignId;
    }

    /**
     * @param Campaign $campaign
     *
     * @return $this
     */
    public function setCampaign(Campaign $campaign = null)
    {
        if ($campaign) {
            $this->campaign   = $campaign;
            $this->campaignId = $campaign->getId();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getContactClientId()
    {
        return $this->contactClientId;
    }

    /**
     * @param int
     *
     * @return $this
     */
    public function setContactClientId($contactClientId)
    {
        $this->contactClientId = $contactClientId;

        return $this;
    }

    /**
     * @return string|float|null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string|float|null $cost
     *
     * @return $this
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return string|float|null
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @param string|float|null $revenue
     *
     * @return $this
     */
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;

        return $this;
    }

    /**
     * @return string|float|null
     */
    public function getGrossIncome()
    {
        return $this->grossIncome;
    }

    /**
     * @param string|float|null $grossIncome
     *
     * @return $this
     */
    public function setGrossIncome($grossIncome)
    {
        $this->grossIncome = $grossIncome;

        return $this;
    }

    /**
     * @return string|float|null
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * @param string|float|null $margin
     *
     * @return $this
     */
    public function setMargin($margin)
    {
        $this->margin = $margin;

        return $this;
    }

    /**
     * @return string|float|null
     */
    public function getEcpm()
    {
        return $this->ecpm;
    }

    /**
     * @param string|float|null $ecpm
     *
     * @return $this
     */
    public function setEcpm($ecpm)
    {
        $this->ecpm = $ecpm;

        return $this;
    }

    /**
     * @return string|int|null
     */
    public function getReceived()
    {
        return $this->received;
    }

    /**
     * @param string|int|null $received
     *
     * @return $this
     */
    public function setReceived($received)
    {
        $this->received = $received;

        return $this;
    }

    /**
     * @return string|int|null
     */
    public function getDeclined()
    {
        return $this->declined;
    }

    /**
     * @param string|int|null $declined
     *
     * @return $this
     */
    public function setDeclined($declined)
    {
        $this->declined = $declined;

        return $this;
    }

    /**
     * @return string|int|null
     */
    public function getConverted()
    {
        return $this->converted;
    }

    /**
     * @param string|int|null $converted
     *
     * @return $this
     */
    public function setConverted($converted)
    {
        $this->converted = $converted;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUtmSource()
    {
        return $this->utmSource;
    }

    /**
     * @param string|null $utmSource
     *
     * @return $this
     */
    public function setUtmSource($utmSource)
    {
        $this->utmSource = $utmSource;

        return $this;
    }

    /**
     * @return bool
     */
    public function getReProcessFlag()
    {
        return $this->reprocessFlag;
    }

    /**
     * @param bool $reprocessFlag
     *
     * @return $this
     */
    public function setReprocessFlag($reprocessFlag)
    {
        $this->reprocessFlag = $reprocessFlag;

        return $this;
    }
}
