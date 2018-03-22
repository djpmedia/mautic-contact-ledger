<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<script src="/plugins/MauticContactLedgerBundle/Assets/js/datatables.min.js"></script>
<script src="/plugins/MauticContactLedgerBundle/Assets/js/global-revenue.js"></script>

<link href="/plugins/MauticContactLedgerBundle/Assets/css/datatables.min.css" rel="stylesheet">
<link href="/plugins/MauticContactLedgerBundle/Assets/css/dataTables.fontAwesome.css" rel="stylesheet">

<?php
    $params = $data['params'];
?>
<script>
    var widgetHeight = <?php echo $data['height']; ?> ;
</script>

    <div class="chart-wrapper">
        <div class="pt-sd pr-md pb-md pl-md">
            <div id="campaign-revenue-table" style="height:<?php echo $data['height']; ?>px">
                <!-- Revenue By Campaign -->
                <div class="responsive-table">
                    <table id="global-revenue" class="table table-striped table-bordered" width="100%">
                    </table>
                </div>
                <!--/ Revenue By Campaign -->
            </div>
        </div>
    </div>