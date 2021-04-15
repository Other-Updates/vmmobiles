<div id="cust_changes">
    <div class="modal-body">
        <div class="row" id="individual">
            <div class="col-sm-12" class="company">
                <fieldset class="col-sm-12 pt-1">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-inverse">
                                <th style="text-align:center; padding:3px">S.No</th>
                                <th style="text-align:center;padding:3px">Invoice No</th>
                                <th style="text-align:right;padding:3px">Total</th>
                                <th style="text-align:right;padding:3px">Pending</th>
                                <th style="text-align:center;padding:3px">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($pending) && !empty($pending)) {
                                $i = 1;
                                foreach ($pending as $val) {
                                    ?>
                                    <tr>
                                        <td  style="padding:2px;text-align:center"><?php echo $i; ?></td>
                                        <td  style="padding:2px;text-align:center"><?php echo $val['inv_id']; ?></td>
                                        <td  style="padding:2px;text-align:right"><?php echo number_format($val['net_total'], 2); ?></td>
                                        <td  style="padding:2px;text-align:right"><?php echo ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']) > 0) ? number_format($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']), 2, '.', ',') : '0.00'; ?></td>
                                        <td  style="padding:2px;text-align:center"><?php echo ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-'; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr><td colspan="5" style="text-align: center;">No Data Found!</td></tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
</div>

