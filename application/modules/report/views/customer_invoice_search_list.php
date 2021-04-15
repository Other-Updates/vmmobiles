

<?php

$paid = $bal = $inv = $advance = 0;

if (isset($quotation) && !empty($quotation)) {



    $i = 1;

    foreach ($quotation as $val) {



        $link = '';

        $paid = $bal = $inv = $advance = $rtn_amt = 0;

        $advance = $advance + $val['advance'];

        $inv = $inv + $val['net_total'];

        $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];

        $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']));

        if ($val['payment_status'] == 'Pending') {

            $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';

        } else {

            $link = '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

        }

        if ($this->user_auth->is_action_allowed("reports", "customer_based_report", "view")) {

            $url = $this->config->item("base_url") . "report/customer_receipt_view/" . $val["id"];

        }



        if (!$this->user_auth->is_action_allowed("reports", "customer_based_report", "view")) {

            $alert = 'alerts';

        }

        $link1 = '<a href="' . $url . '" data-toggle="tooltip" class="tooltips btn btn-default btn-xs ' . $alert . ' " title="" data-original-title="View" ><span class="fa fa-eye"></span></a>';

        ?>

        <tr>

            <td class='first_td action-btn-align'><?php echo $i ?></td>

            <td><?php echo $val['store_name'] ?></td>

            <td class='action-btn-align'><?php echo $val['inv_id'] ?></td>

            <td><?php echo number_format($val['net_total'], 2, '.', ','); ?></td>

          <!--  <td><?php echo number_format($val['advance'], 2, '.', ','); ?></td>

            <td><?php echo number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ','); ?></td>-->

            <?php

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                $rtn_amt = number_format($val['return'][1]['net_total'] - $val['return'][0]['net_total'], 2, '.', ',');

                $rtn_amt = str_replace("-", "", $rtn_amt);

            } else {

                $rtn_amt = '0.00';

            }

            ?>

          <!--  <td><?php echo $rtn_amt; ?></td>

            <td><?php echo number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ','); ?></td>

            <?php

            if (($val['return'][0]['id'] != $val['return'][1]['id'])) {

                $dis = number_format(($val['return'][1]['net_total'] - ($val['return'][1]['net_total'] - $val['return'][0]['net_total'])) - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            } else {

                $dis = number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance']), 2, '.', ',');

            }

            ?>

            <td><?php echo $dis; ?></td>-->

            <td><?php echo ($val['created_date'] != '' && $val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>

<!--            <td><?php echo ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : ''; ?></td>

            <td><?php echo $link; ?></td>-->

            <td><?php echo $link1; ?></td>

        </tr>







        <?php

        $i++;

    }

    ?>



<?php } else {

    ?>

    </tr><td colspan="12"> No results found!.. </td>       </tr>



<?php }

?>



