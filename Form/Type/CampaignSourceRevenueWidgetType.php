<?php

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Digital Media Solutions, LLC
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticContactLedgerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CampaignSourceRevenueWidgetType.
 */
class CampaignSourceRevenueWidgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'groupby',
            'choice',
            [
                'label'      => 'Group By Granularity',
                'choices'    => [
                    'Source Name'                           => 'mautic.contactledger.dashboard.source-revenue.header.sourcename',
                    'Source Category'                       => 'mautic.contactledger.dashboard.source-revenue.header.category',
                ],
                'label_attr' => ['class' => 'control-label'],
                'attr'       => ['class' => 'form-control'],
                'required'   => true,
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'campaign_source_revenue_widget';
    }
}
