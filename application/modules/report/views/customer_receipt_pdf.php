<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<style type="text/css">

    table {border-collapse:collapse; width:100%; font-size:8px }

    table tr thead th{ text-align:center; border:0px solid #000; padding:2px; vertical-align:middle !important; font-weight: bold;}

    table tr td { text-align:center; border:0px solid #000; padding:2px; vertical-align:middle !important;}

    .pdf-f{font-weight:bold}

    table.ptable {border:0px solid #000;}

    table.ptable tr {border:0px solid #000;}

    .ptable { margin-bottom:0px;}

    .ptable tr td { padding:2px;}

    table.invoice-detail tfoot tr td.bor-tb0 { border-top:none !important; border-bottom:none !important;}

    .print_header_tit p { text-align:left; font-size:8px;}

    table thead tr td{font-size: 20px;}

</style>

<table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline invoice-detail ">

    <thead>

        <tr>

            <td class="action-btn-align">S.No</td>

            <td class="action-btn-align">Invoice ID</td>

            <td class="action-btn-align">Firm Name</td>

            <td class="action-btn-align">Firm GSTIN</td>

            <td class="action-btn-align">Customer Name</td>

            <td class="action-btn-align">Customer GSTIN</td>

            <td class="action-btn-align">Total QTY</td>

            <td class="action-btn-align">CGST</td>

            <td class="action-btn-align">SGST</td>

            <td class="action-btn-align">Sub Total</td>

            <td class="action-btn-align">Inv Amt</td>

            <!--<td class="action-btn-align">Paid Amount</td>-->

            <td class="action-btn-align">Inv Date</td>

           <!--  <td class="action-btn-align">Paid Date</td>

            <td class="action-btn-align">Credit Days</td>

            <td class="action-btn-align">Due Date</td>

            <td class="action-btn-align">Credit Limit</td>

            <td class="action-btn-align">Exceeded Credit Limit</td>

            <td class="action-btn-align">Sales Man</td>-->

            <!--<td>Remarks</td>-->



        </tr>

    </thead>



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

            $total_qun = 0;

            $cgst = 0;

            $sgst = 0;

            $sub_total = 0;

            $tot_inv_amount = 0;

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

                        $url = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['id'] . '" >' . $val['inv_id'] . '</a>';

                        ?>

                        <tr>

                            <td class='first_td action-btn-align'><?php echo $i; ?></td>

                            <td class="action-btn-align"><?php echo $val['inv_id']; ?></td>

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

                                $inv_amount = 0;

                                $inv_amount = $quotation['inv_all_details'][$invoice_id]['sub_total'] + $quotation['inv_all_details'][$invoice_id]['total_gst'];

                                //echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];

                                ?>

                                <?php

                                if (isset($quotation['inv_all_details'][$invoice_id]['in_id'])) {

                                    // echo "Test " . $quotation['inv_all_details'][$invoice_id]['in_id'];

                                    ?>

                                    <td class="action-btn-align"><?php

                                        echo $quotation['inv_all_details'][$invoice_id]['quantity'];

                                        $total_qun+=$quotation['inv_all_details'][$invoice_id]['quantity'];

                                        ?></td>

                                    <td class="text_right"><?php

                                        echo number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2);

                                        $cgst+=$quotation['inv_all_details'][$invoice_id]['cgst'];

                                        ?></td>

                                    <td class="text_right"><?php

                                        echo number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2);

                                        $sgst+=$quotation['inv_all_details'][$invoice_id]['sgst'];

                                        ?></td>

                                    <td class="text_right"><?php

                                        echo number_format($quotation['inv_all_details'][$invoice_id]['sub_total'], 2);

                                        $sub_total+=$quotation['inv_all_details'][$invoice_id]['sub_total'];

                                        ?></td>

                                    <td class="text_right"><?php

                                        echo number_format($inv_amount, 2);

                                        $tot_inv_amount+=$inv_amount;

                                        ?></td>



                                    <?php

                                } else {

                                    ?>



                                    <td class="action-btn-align">

                                        <?php

                                        echo $val['total_qty'];

                                        $total_qun+=$val['total_qty'];

                                        ?>

                                    </td>

                                    <td class="text_right">

                                        <?php

                                        echo number_format(($val['erp_invoice_details'][0]['cgst']), 2);

                                        $cgst+=$val['erp_invoice_details'][0]['cgst'];

                                        ?>

                                    </td>

                                    <td class="text_right">

                                        <?php

                                        echo number_format(($val['erp_invoice_details'][0]['sgst']), 2);

                                        $sgst+=$val['erp_invoice_details'][0]['sgst'];

                                        ?>

                                    </td>

                                    <td class="text_right"><?php

                                        echo number_format($val['subtotal_qty'], 2);

                                        $sub_total+=$val['subtotal_qty'];

                                        ?></td>

                                    <td class="text_right"><?php

                                        echo number_format($val['net_total'], 2);

                                        $tot_inv_amount+=$val['net_total'];

                                        ?></td>

                                    <?php

                                }

                                ?>

                                <?php

                            } else {

                                ?>

                                <td class="action-btn-align"><?php

                                    echo $val['total_qty'];

                                    $total_qun+=$val['total_qty'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format(($val['erp_invoice_details'][0]['cgst']), 2);

                                    $cgst+=$val['erp_invoice_details'][0]['cgst'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format(($val['erp_invoice_details'][0]['sgst']), 2);

                                    $sgst+=$val['erp_invoice_details'][0]['sgst'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format($val['subtotal_qty'], 2);

                                    $sub_total+=$val['subtotal_qty'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format($val['net_total'], 2);

                                    $tot_inv_amount+=$val['net_total'];

                                    ?></td>

                            <?php } ?>





                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ', ') ?></td>-->

                            <td class="action-btn-align"><?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>

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

                    $url = '<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['id'] . '" >' . $val['inv_id'] . '</a>';

                    ?>

                    <tr>

                        <td class='first_td action-btn-align'><?php echo $i; ?></td>

                        <td class="action-btn-align"><?php echo $val['inv_id']; ?></td>

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

                                <td class="action-btn-align"><?php

                                    echo $quotation['inv_all_details'][$invoice_id]['quantity'];

                                    $total_qun+=$quotation['inv_all_details'][$invoice_id]['quantity'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2);

                                    $cgst+=$quotation['inv_all_details'][$invoice_id]['cgst'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2);

                                    $sgst+=$quotation['inv_all_details'][$invoice_id]['sgst'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format($quotation['inv_all_details'][$invoice_id]['sub_total'], 2);

                                    $sub_total+=$quotation['inv_all_details'][$invoice_id]['sub_total'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format($inv_amount, 2);

                                    $tot_inv_amount+=$inv_amount;

                                    ?></td>



                                <?php

                            } else {

                                ?>



                                <td class="action-btn-align">

                                    <?php

                                    echo $val['total_qty'];

                                    $total_qun+=$val['total_qty'];

                                    ?>

                                </td>

                                <td class="text_right">

                                    <?php

                                    echo number_format(($val['erp_invoice_details'][0]['cgst']), 2);

                                    $cgst+=$val['erp_invoice_details'][0]['cgst'];

                                    ?>

                                </td>

                                <td class="text_right">

                                    <?php

                                    echo number_format(($val['erp_invoice_details'][0]['sgst']), 2);

                                    $sgst+=$val['erp_invoice_details'][0]['sgst'];

                                    ?>

                                </td>

                                <td class="text_right"><?php

                                    echo number_format($val['subtotal_qty'], 2);

                                    $sub_total+=$val['subtotal_qty'];

                                    ?></td>

                                <td class="text_right"><?php

                                    echo number_format($val['net_total'], 2);

                                    $tot_inv_amount+=$val['net_total'];

                                    ?></td>

                                <?php

                            }

                            ?>

                            <?php

                        } else {

                            ?>

                            <td class="action-btn-align"><?php

                                echo $val['total_qty'];

                                $total_qun+=$val['total_qty'];

                                ?></td>

                            <td class="text_right"><?php

                                echo number_format(($val['erp_invoice_details'][0]['cgst']), 2);

                                $cgst+=$val['erp_invoice_details'][0]['cgst'];

                                ?></td>

                            <td class="text_right"><?php

                                echo number_format(($val['erp_invoice_details'][0]['sgst']), 2);

                                $sgst+=$val['erp_invoice_details'][0]['sgst'];

                                ?></td>

                            <td class="text_right"><?php

                                echo number_format($val['subtotal_qty'], 2);

                                $sub_total+=$val['subtotal_qty'];

                                ?></td>

                            <td class="text_right"><?php

                                echo number_format($val['net_total'], 2);

                                $tot_inv_amount+=$val['net_total'];

                                ?></td>

                        <?php } ?>





                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ', ') ?></td>-->

                        <td class="action-btn-align"><?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>

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

    <tfoot>

        <tr>

            <td colspan="6"></td>

            <td class="text_right total-bg"><?php echo number_format($total_qun, 2); ?></td>

            <td class="text_right total-bg"><?php echo number_format($cgst, 2); ?></td>

            <td class="text_right total-bg"><?php echo number_format($sgst, 2); ?></td>

            <td class="text_right total-bg"><?php echo number_format($sub_total, 2); ?></td>

            <td class="text_right total-bg"><?php echo number_format($tot_inv_amount, 2); ?></td>

            <td></td>

        </tr>

    </tfoot>



</table>

