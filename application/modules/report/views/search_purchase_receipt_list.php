<thead>
    <tr>
        <td class="action-btn-align">S.No</td>
        <td class="action-btn-align">PO #</td>
        <td>Customer Name</td>
        <td>Invoice Amount</td>
        <td>Paid Amount</td>
        <td>Discount Amount</td>
        <td>Balance</td>
        <td class="action-btn-align">Due Date</td>
        <td class="action-btn-align">Created Date</td>
        <td class="hide_class action-btn-align">Payment Status</td>
        <td class="hide_class action-btn-align">Action</td>

    </tr>
</thead>
<tbody>
    <?php
    $paid = $bal = $inv = 0;
    if (isset($all_receipt) && !empty($all_receipt)) {
        $i = 1;
        foreach ($all_receipt as $val) {
            $inv = $inv + $val['net_total'];
            $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];
            $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));
            ?>
            <tr>
                <td class='first_td'><?= $i ?></td>
                <td><?= $val['po_no'] ?></td>
                <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>
                <td  class="text_right"><?= number_format($val['net_total'], 2, '.', ',') ?></td>
                <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',') ?></td>
                <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',') ?></td>
                <td  class="text_right"><?= number_format(($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',') ?></td>
                <td><?= ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : ''; ?></td>
                <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>
                <td class="hide_class action-btn-align">
                    <?php
                    if ($val['payment_status'] == 'Pending') {
                        echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
                    } else {
                        echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
                    }
                    ?>
                </td>
                <td  class="hide_class action-btn-align">
                    <a href="<?php echo $this->config->item('base_url') . 'purchase_receipt/view_receipt/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                </td>

            </tr>
            <?php
            $i++;
        }
        ?>
    </tbody>
    <tfoot class="result_tfoot">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text_right total-bg"><?= number_format($inv, 2, '.', ',') ?></td>
            <td class="text_right total-bg"><?= number_format($paid, 2, '.', ',') ?></td>
            <td></td>
            <td class="text_right total-bg"><?= number_format($bal, 2, '.', ',') ?></td>
            <td></td>
            <td></td>
            <td class="hide_class"></td>
            <td class="hide_class"></td>
        </tr>
    </tfoot>
    <?php
}
?>