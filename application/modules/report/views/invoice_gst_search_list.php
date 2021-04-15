<div class="result_div">
    <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline ">
        <thead>
            <tr>
                <td class="action-btn-align">S.No</td>
                <td class="action-btn-align">Invoice ID</td>
                <td class="action-btn-align">Firm Name</td>
                <td class="action-btn-align">Firm GSTIN</td>
                <td class="action-btn-align">Customer Name</td>
                <td class="action-btn-align">Customer GSTIN</td>
                <td class="action-btn-align">Total Quantity</td>
                <td class="action-btn-align">CGST</br><span><?php echo ($search_data['gst'] && $search_data['gst'] != 'Select') ? $search_data['gst'] . '%' : ''; ?></span></td>
                <td class="action-btn-align">SGST</br><span><?php echo ($search_data['gst'] && $search_data['gst'] != 'Select') ? $search_data['gst'] . '%' : ''; ?></span></td>
                <td class="action-btn-align">Sub Total</td>
                <td class="action-btn-align">Invoice Amount</td>
                <!--<td class="action-btn-align">Paid Amount</td>-->
                <td class="action-btn-align">Invoice Date</td>
               <!--  <td class="action-btn-align">Paid Date</td>
                <td class="action-btn-align">Credit Days</td>
                <td class="action-btn-align">Due Date</td>
                <td class="action-btn-align">Credit Limit</td>
                <td class="action-btn-align">Exceeded Credit Limit</td>
                <td class="action-btn-align">Sales Man</td>-->
                <!--<td>Remarks</td>-->

            </tr>
        </thead>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="action-btn-align"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <!--<td></td>-->
<!--                <td></td>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td class=""></td>-->

            </tr>
        </tfoot>
        <tbody>
            <?php
            $quotation = array_filter($quotation);
            if (isset($quotation) && !empty($quotation)) {

                $count = count($quotation);
                // exit;
                // echo "<pre>";
                //  print_r($quotation);
                // exit;

                $i = 1;
                $tot = 0;
                $cnt = 0;
                foreach ($quotation as $key => $val) {
                    if (isset($quotation['inv_all_details'])) {
                        if (++$cnt === $count) {
                            //echo "last index!";
                        } else {



                            //}
                            //foreach ($quotation as $val) {

                            $invoice_id = $val['id'];
                            //echo $invoice_id . '<br />';
                            $tot += $val['net_total'];
                            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
                            } else {
                                $due_date = '-';
                            }
                            $url = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['id'] . '" target="_blank">' . $val['inv_id'] . '</a>';
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td class="action-btn-align"><?php echo $url ?></td>
                                <td><?php echo $val['firm_name']; ?></td>
                                <td><?php echo ($val['gstin']) ? $val['gstin'] : ''; ?></td>
                                <td><?php
                                    echo ($val['store_name']) ? $val['store_name'] : $val['name'];
                                    ?></td>
                                <td><?php
                                    echo ($val['tin']) ? $val['tin'] : 'NULL';
                                    ?></td>

                                <?php
                                //echo "<pre>";
                                //print_r($quotation['inv_all_details']);
                                // exit;

                                if (isset($quotation['inv_all_details']) && !empty($quotation['inv_all_details'])) {
                                    $inv_amount = 0;
                                    $inv_amount = $quotation['inv_all_details'][$invoice_id]['sub_total'] + $quotation['inv_all_details'][$invoice_id]['total_gst'];
                                    //echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];
                                    ?>
                                    <?php
                                    if (isset($quotation['inv_all_details'][$invoice_id]['in_id'])) {
                                        // echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];
                                        ?>
                                        <td class="action-btn-align"><?= $quotation['inv_all_details'][$invoice_id]['quantity'] ?></td>
                                        <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format($quotation['inv_all_details'][$invoice_id]['sub_total'], 2); ?></td>
                                        <td class="text_right"><?= number_format($inv_amount, 2); ?></td>

                                        <?php
                                    } else {
                                        ?>

                                        <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                        <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                } else {
                                    ?>
                                    <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                <?php } ?>


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ', ') ?></td>-->
                                <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                <!--                                <td class="action-btn-align"><?php echo ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-'; ?></td>
                                <td class="action-btn-align"><?= $val['credit_days'] > 0 ? $val['credit_days'] : '-'; ?></td>
                                <td class="action-btn-align"><?= $due_date; ?></td>
                                <td class="action-btn-align"><?= ($val['credit_limit'] != '') ? $val['credit_limit'] : '-'; ?></td>
                                <td class="action-btn-align"><?= ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-'; ?></td>
                                <td><?= $val['sales_man_name'] ?></td>-->
                <!--<td><?= $val['remarks'] ?></td>-->
                            </tr>

                            <?php
                            $i++;

                            // $cnt++;
                        }
                    } else {




                        //}
                        //foreach ($quotation as $val) {

                        $invoice_id = $val['id'];
                        $inv_amount = 0;
                        $inv_amount = $quotation['inv_all_details'][$invoice_id]['sub_total'] + $quotation['inv_all_details'][$invoice_id]['total_gst'];
                        //echo $invoice_id . '<br />';
                        $tot += $val['net_total'];
                        if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                            $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
                        } else {
                            $due_date = '-';
                        }
                        $url = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['id'] . '" target="_blank" >' . $val['inv_id'] . '</a>';
                        ?>
                        <tr>
                            <td class='first_td action-btn-align'><?= $i ?></td>
                            <td class="action-btn-align"><?= $url ?></td>
                            <td><?php echo $val['firm_name']; ?></td>
                            <td><?php echo ($val['gstin']) ? $val['gstin'] : ''; ?></td>
                            <td><?php
                                echo ($val['store_name']) ? $val['store_name'] : $val['name'];
                                ?></td>
                            <td><?php
                                echo ($val['tin']) ? $val['tin'] : '';
                                ?></td>

                            <?php
                            //echo "<pre>";
                            //print_r($quotation['inv_all_details']);
                            // exit;

                            if (isset($quotation['inv_all_details']) && !empty($quotation['inv_all_details'])) {

                                //echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];
                                ?>
                                <?php
                                if (isset($quotation['inv_all_details'][$invoice_id]['in_id'])) {
                                    // echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];
                                    ?>
                                    <td class="action-btn-align"><?= $quotation['inv_all_details'][$invoice_id]['quantity'] ?></td>
                                    <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format($quotation['inv_all_details'][$invoice_id]['sub_total'], 2); ?></td>
                                    <td class="text_right"><?= number_format($inv_amount, 2); ?></td>
                                    <?php
                                } else {
                                    ?>

                                    <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                    <?php
                                }
                                ?>
                                <?php
                            } else {
                                ?>
                                <td class="action-btn-align"><?= $val['total_qty'] ?></td>
                                <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                            <?php } ?>


                                                                                                                                                                                                                                                                                                <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ', ') ?></td>-->
                            <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
            <!--                            <td class="action-btn-align"><?php echo ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-'; ?></td>
                            <td class="action-btn-align"><?= $val['credit_days'] > 0 ? $val['credit_days'] : '-'; ?></td>
                            <td class="action-btn-align"><?= $due_date; ?></td>
                            <td class="action-btn-align"><?= ($val['credit_limit'] != '') ? $val['credit_limit'] : '-'; ?></td>
                            <td class="action-btn-align"><?= ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-'; ?></td>
                            <td><?= $val['sales_man_name'] ?></td>-->
            <!--<td><?= $val['remarks '] ?></td>-->
                        </tr>

                        <?php
                        $i++;

                        // $cnt++;
                    }
                }
            }
            ?>
        </tbody>
       <!-- <tfoot>
            <tr>
                <td colspan="4"></td>
                <td class="text_right total-bg"><?= number_format($tot, 2); ?></td>
            <td colspan="4"></td>
        </tr>
    </tfoot>-->

    </table>
</div>