<table id="myTable" class="display last-td-center dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer " cellspacing="0" width="100%">
    <thead>
        <tr>
            <td class="action-btn-align">S.No</td>
            <td>Customer Name</td>
            <td class="action-btn-align">Mobile</td>
            <td class="action-btn-align">Electricals</td>
            <td class="action-btn-align">Paints</td>
            <td class="action-btn-align">Tiles</td>
            <td class="action-btn-align">Hardware</td>
            <td class="action-btn-align">Total Balance</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($customers) && !empty($customers)) {
            $s = 1;
            $electricals = $tiles = $hardware = $paints = $net_amount = 0;
            foreach ($customers as $customer) {

                if ($customer['firm_id'] == 1)
                    $electricals = ($electricals + ($customer['net_total'] - ($customer['electricals'] + $customer['advance'])));
                if ($customer['firm_id'] == 2)
                    $paints = ($paints + ($customer['net_total'] - ($customer['paints'] + $customer['advance'])));
                if ($customer['firm_id'] == 3)
                    $tiles = ($tiles + ($customer['net_total'] - ($customer['tiles'] + $customer['advance'])));
                if ($customer['firm_id'] == 4)
                    $hardware = ($hardware + ($customer['net_total'] - ($customer['hardware'] + $customer['advance'])));

                $net_amount = $net_amount + ($customer['net_total'] - ($customer['net_amount'] + $customer['advance']));
                ?>
                <tr>
                    <td class="action-btn-align"><?php echo $s; ?></td>
                    <td><?php echo ($customer['store_name']) ? $customer['store_name'] : $customer['name']; ?></td>
                    <td class="action-btn-align"><?php echo $customer['mobil_number']; ?></td>
                    <td class="text_right"><?php echo ($customer['firm_id'] == 1) ? number_format($customer['net_total'] - ($customer['electricals'] + $customer['advance']), 2) : '-'; ?></td>
                    <td class="text_right"><?php echo ($customer['firm_id'] == 2) ? number_format($customer['net_total'] - ($customer['paints'] + $customer['advance']), 2) : '-'; ?>                                    </td>
                    <td class="text_right"><?php echo ($customer['firm_id'] == 3) ? number_format($customer['net_total'] - ($customer['tiles'] + $customer['advance']), 2) : '-'; ?></td>
                    <td class="text_right"><?php echo ($customer['firm_id'] == 4) ? number_format($customer['net_total'] - ($customer['hardware'] + $customer['advance']), 2) : '-'; ?></td>
                    <td class="text_right"><?php echo ($customer['net_total'] != '') ? number_format($customer['net_total'] - ($customer['net_amount'] + $customer['advance']), 2) : '-'; ?></td>
                </tr>
                <?php
                $s++;
            }
        } else {
            ?>
            <tr><td colspan="8">No data found...</td></tr>
<?php } ?>
    </tbody>
</table>