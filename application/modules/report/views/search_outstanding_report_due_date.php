<?php
if (isset($customers) && !empty($customers)) {

    $s = 1;
    $days = $sevendays = $inv = $advance = $thirtydays = $nintydays = $receipt = 0;
    foreach ($customers as $customer) {
        $now = date('Y-m-d');
        $due_date = $customer['receipt'][0]['created_date'];
        $seven_date = date('Y-m-d', strtotime("+7 day", strtotime($customer['receipt'][0]['created_date'])));
        $thirty_date = date('Y-m-d', strtotime("+30 day", strtotime($customer['receipt'][0]['created_date'])));
        $ninty_date = date('Y-m-d', strtotime("+90 day", strtotime($customer['receipt'][0]['created_date'])));
        ?>
        <tr>
            <td class="action-btn-align"><?php echo $s; ?></td>
            <td><?php echo ($customer['store_name']) ? $customer['store_name'] : $customer['name']; ?></td>
            <td class="action-btn-align"><?php echo $customer['mobil_number']; ?></td>

            <td class="text_right">
                <?php
                if ($customer['rec'][0]['inv_id'] != '' && $customer['rec'][0]['inv_id'] == 'Wings Invoice') {
                    $new_val = 0;
                    $val = (number_format($customer['rec'][0]['net_total'] - ($customer['rec'][0]['receipt'] + $customer['rec'][0]['advance']), 2));
                    echo($val <= 0 ) ? '' : $val;
                }
                ?>
                <?php //echo ($customer['rec'][0]['inv_id'] != '' && $customer['rec'][0]['inv_id'] == 'Wings Invoice') ? number_format($customer['rec'][0]['net_total'], 2) : ''; ?>
            </td>
            <td class="text_right 7days">
                <?php
                if ($customer['days'][0]['inv_id'] != '' && $customer['days'][0]['inv_id'] != 'Wings Invoice') {
                    $new_val = 0;
                    $val = (number_format($customer['days'][0]['net_total'] - ($customer['days'][0]['receipt'] + $customer['days'][0]['advance']), 2));
                    echo($val <= 0 ) ? '' : $val;
                }
                ?>
            </td>
            <td class="text_right 7to30days">
                <?php
                if ($customer['sevendays'][0]['inv_id'] != '' && $customer['sevendays'][0]['inv_id'] != 'Wings Invoice') {
                    $new_val = 0;
                    $val = (number_format($customer['sevendays'][0]['net_total'] - ($customer['sevendays'][0]['receipt'] + $customer['sevendays'][0]['advance']), 2));
                    echo($val <= 0 ) ? '' : $val;
                }
                ?>
            </td>
            <td class="text_right 30to90days">
                <?php
                if ($customer['thirtydays'][0]['inv_id'] != '' && $customer['thirtydays'][0]['inv_id'] != 'Wings Invoice') {
                    $new_val = 0;
                    $val = (number_format($customer['thirtydays'][0]['net_total'] - ($customer['thirtydays'][0]['receipt'] + $customer['thirtydays'][0]['advance']), 2));
                    echo($val <= 0 ) ? '' : $val;
                }
                ?>
            </td>
            <td class="text_right 90days">
                <?php
                if ($customer['nintydays'][0]['inv_id'] != '' && $customer['nintydays'][0]['inv_id'] != 'Wings Invoice') {
                    $new_val = 0;
                    $val = (number_format($customer['nintydays'][0]['net_total'] - ($customer['nintydays'][0]['receipt'] + $customer['nintydays'][0]['advance']), 2));
                    echo($val <= 0 ) ? '' : $val;
                }
                ?>
            </td>
            <td class="text_right net_balance"><?php
                $a_val = $b_val = $c_val = $d_val = $e_val = 0;
                if ($customer['days'][0]['inv_id'] != '' && $customer['days'][0]['inv_id'] != 'Wings Invoice') {
                    $a_val = ($customer['days'][0]['net_total'] - ($customer['days'][0]['receipt'] + $customer['days'][0]['advance']) > 0) ? ($customer['days'][0]['net_total'] - ($customer['days'][0]['receipt'] + $customer['days'][0]['advance'])) : '';
                }

                if ($customer['sevendays'][0]['inv_id'] != '' && $customer['sevendays'][0]['inv_id'] != 'Wings Invoice') {
                    $b_val = ($customer['sevendays'][0]['net_total'] - ($customer['sevendays'][0]['receipt'] + $customer['sevendays'][0]['advance']) > 0) ? ($customer['sevendays'][0]['net_total'] - ($customer['sevendays'][0]['receipt'] + $customer['sevendays'][0]['advance'])) : '';
                }
                if ($customer['thirtydays'][0]['inv_id'] != '' && $customer['thirtydays'][0]['inv_id'] != 'Wings Invoice') {
                    $c_val = ($customer['thirtydays'][0]['net_total'] - ($customer['thirtydays'][0]['receipt'] + $customer['thirtydays'][0]['advance']) > 0) ? ($customer['thirtydays'][0]['net_total'] - ($customer['thirtydays'][0]['receipt'] + $customer['thirtydays'][0]['advance'])) : '';
                }

                if ($customer['nintydays'][0]['inv_id'] != '' && $customer['nintydays'][0]['inv_id'] != 'Wings Invoice') {
                    $d_val = ($customer['nintydays'][0]['net_total'] - ($customer['nintydays'][0]['receipt'] + $customer['nintydays'][0]['advance']) > 0) ? ($customer['nintydays'][0]['net_total'] - ($customer['nintydays'][0]['receipt'] + $customer['nintydays'][0]['advance'])) : '';
                }

                if ($customer['rec'][0]['inv_id'] != '' && $customer['rec'][0]['inv_id'] == 'Wings Invoice') {
                    $e_val = ($customer['rec'][0]['net_total'] - ($customer['rec'][0]['receipt'] + $customer['rec'][0]['advance']) > 0) ? ($customer['rec'][0]['net_total'] - ($customer['rec'][0]['receipt'] + $customer['rec'][0]['advance'])) : '';
                }

                $vak = ($a_val) + ($b_val) + ($c_val) + ($d_val) + ($e_val);
                echo number_format($vak, 2);
                ?>
            </td>
        </tr>
        <?php
        $s++;
    }
}
?>