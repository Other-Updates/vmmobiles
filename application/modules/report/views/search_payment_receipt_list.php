<?php
$paid = $bal = $inv = 0;
//echo '<pre>';
//print_r($all_receipt);
if (isset($all_receipt) && !empty($all_receipt)) {
    $i = 1;
    foreach ($all_receipt as $val) {
        $inv = $inv + $val['receipt_bill'][0]['net_total'];
        $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];
        $bal = $bal + ($val['receipt_bill'][0]['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));
        ?>
        <tr>
            <td class='first_td action-btn-align'><?= $i ?></td>
            <!--<td class="action-btn-align"><?= $val['inv_id'] ?></td>-->
            <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>
            <td  class="text_right"><?= number_format($val['receipt_bill'][0]['net_total'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format(($val['receipt_bill'][0]['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',') ?></td>
            <td class="action-btn-align"><?= ($val['receipt_bill'][0]['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['created_date'])) : '-'; ?></td>
            <td class="action-btn-align"><?= ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : ''; ?></td>
            <td class="hide_class action-btn-align">
                <?php
                if ($val['receipt_bill'][0]['net_total'] == ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])) {
                    echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
                } else {
                    echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
                }
                ?>
            </td>
        <!--                                    <td  class="hide_class action-btn-align">
                <a href="<?php echo $this->config->item('base_url') . 'sales_receipt/view_receipt/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
            </td>-->

        </tr>

        <?php
        $i++;
    }
}
?>