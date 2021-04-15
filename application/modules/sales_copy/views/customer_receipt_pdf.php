<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style type="text/css">
    table {border-collapse:collapse; width:100%; font-size:8px }
    table.invoice-detail tr th{ text-align:center; border:0px solid #000; padding:2px; vertical-align:middle;}
    table.invoice-detail tr td { text-align:center; border:0px solid #000; padding:2px; vertical-align:middle;}
    .pdf-f{font-weight:bold}
    table.invoice-detail tbody tr td:nth-child(even){ background:#e1e1e1}
    table.ptable {border:0px solid #000;}
    table.ptable tr {border:0px solid #000;}
    .ptable { margin-bottom:0px;}
    .ptable tr td { padding:2px;}
    table.invoice-detail tfoot tr td.bor-tb0 { border-top:none !important; border-bottom:none !important;}
    .print_header_tit p { text-align:left; font-size:8px;}
</style>
<table class="ptable" style="padding:2px;" row-style="page-break-inside:avoid;">
    <!--<tr><th  colspan="3" style="color:#fff;" bgcolor="#333"><strong>Sales Invoice Details</strong></th></tr>-->
    <tr>
        <td colspan="1" style="border-bottom:0px solid #000;" align="left">GSTIN NO :  <?php echo $val['tin']; ?></td>
        <td align="right" style="border-bottom:0px solid #000;">Cell :  --- </td>
    </tr>
    <tr>
        <!--<td width="20%" align="center" valign="middle"> <img src="<?= $theme_path; ?>/images/logo.png" width="50px"></td>-->
        <td width="50%" align="left" ><?php echo $quotation[0]['store_name']; ?><br />
            <?php echo $quotation[0]['address1']; ?><br /><?php echo $quotation[0]['mobil_number']; ?><br /><?php echo $quotation[0]['email_id']; ?>
        </td>
        <td width="50%" align="right">Invoice NO : <?php echo $quotation[0]['inv_id'] ?><br /> Receipt Number : <?php echo $quotation[0]['q_no'] ?><br /> Firm Name : <?php echo $quotation[0]['firm_name']; ?><br /> Received Date : <?php echo date('d-M-Y', strtotime($quotation[0]['created_date'])) ?></td>
    </tr>
</table>
<table class="invoice-detail" style="padding: 2px 2px;" row-style="page-break-inside:avoid;">
    <!--<tr>
        <td colspan="7" align="center" style="color:#fff;" bgcolor="#333">Invoice Details</td>
    </tr>-->
    <tr align="center">
        <td width="7%">S.No</td>
        <td width="31%" align="left">Product Name</td>
        <td width="8%">QTY</td>
        <td width="15%" align="right">Cost/QTY</td>
        <td width="12%">CGST%</td>
        <td width="12%">SGST%</td>
        <!--<td width="13%">Discount%</td>-->
        <td width="15%" align="right">Net&nbsp;Value</td>
    </tr>
    <tbody>
        <?php
        $i = 1;
        $j = 0;
        $final_qty = 0;
        $final_sub_total = 0;
        $cgst = 0;
        $sgst = 0;
        if (isset($quotation_details) && !empty($quotation_details)) {
            foreach ($quotation_details as $vals) {
                $pertax1 = ($vals['tax'] / 100) * $t1_customer_rate[$j];
                $gst1 = ($vals['gst'] / 100) * $t1_customer_rate[$j];
                $discount1 = ($vals['discount'] / 100) * $t1_customer_rate[$j];
                $sub_total1 = ($vals['quantity'] * $t1_customer_rate[$j]) + ($pertax1 * $vals['quantity']) + ($gst1 * $vals['quantity']);
                $sub_total = $sub_total1 - ($discount1 * $vals['quantity']);
                $final_qty = $final_qty + $vals['quantity'];
                $final_sub_total = $final_sub_total + $sub_total;
                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                $cgst += $cgst1;
                $sgst += $sgst1;
                ?>
                <tr>
                    <td align="center">
                        <?php echo $i; ?>
                    </td>
                    <td align="left">
                        <?php echo $vals['product_name'] ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['quantity'] ?>
                    </td>
                    <td align="right">
                        <?php echo number_format($t1_customer_rate[$j], 2); ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['tax'] ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['gst'] ?>
                    </td>
        <!--                    <td align="center">
                    <?php echo $vals['discount'] ?>
                    </td>-->
                    <td align="right">
                        <?php echo number_format($sub_total, 2) ?>
                    </td>
                </tr>
                <?php
                $i++;
                $j++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right" >Total</td>
            <td align="center"><?php echo $quotation[0]['total_qty']; ?></td>
            <td colspan="3" align="right">Sub Total : </td>
            <td align="right"><?php echo number_format($final_sub_total, 2); ?></td>
        </tr>
        <?php
        $final_sub_total = $final_sub_total + $quotation[0]['transport'] + $quotation[0]['labour'];
        ?>
        <tr>
            <td colspan="3" align="left" style="border-top:0px solid #fff; border-bottom:1px solid #fff; border-right:1px solid #fff;">ACC No : ---</td>
            <td colspan="3" align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">Add CGST : </td>
            <td align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;"><?php echo number_format($cgst, 2); ?></td>

        </tr>
        <tr>
            <td colspan="3" align="left" style="border-top:0px solid #fff; border-bottom:1px solid #fff; border-right:1px solid #fff;">IFSC Code : ---</td>
            <td colspan="3" align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">Add SGST : </td>
            <td align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;"><?php echo number_format($sgst, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="left" style="border-top:0px solid #fff; border-bottom:1px solid #fff; border-right:1px solid #fff;">Bank Name : ---</td>
            <td colspan="3" align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">Transport Charge : </td>
            <td align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">
                <?php echo number_format($quotation[0]['transport'], 2); ?>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">Labour Charge : </td>
            <td align="right" style="border-top:0px solid #fff; border-bottom:1px solid #fff;">
                <?php echo number_format($quotation[0]['labour'], 2); ?>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="border-top:0px solid #fff; font-size:11px;" align="right"><strong>Net Total : </strong></td>
            <td align="right" style="border-top:0px solid #fff; font-size:11px;"><?php echo number_format($final_sub_total, 2); ?></td>
        </tr>
        <tr>
            <td colspan="7" align="left">
                <span class="pdf-f">Remarks : </span>
                <?php echo $quotation[0]['remarks']; ?>
            </td>
        </tr>
    </tfoot>
</table><br><br><br>
<table class="table" cellpadding="0" cellspacing="0">
    <tr class="tbor">
        <td>Customer's Signature</td>
        <td align="center"></td>
        <td align="right">Signature</td>
    </tr>
</table>
