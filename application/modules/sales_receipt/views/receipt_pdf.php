<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style type="text/css">
    table {border-collapse:collapse; width:100%; font-size:7px }
    table tr th{ text-align:center; border:1px solid #ddd; padding:5px 5px 5px 5px; vertical-align:middle;}
    table tr td { text-align:center; border:1px solid #ddd; padding:5px 5px 5px 5px; vertical-align:middle;}
    .pdf-f{font-weight:bold}
</style>
<br /><br />
<table style="padding: 2px 2px;" row-style="page-break-inside:avoid;">
    <tr><th  colspan="2"><strong>Sales Invoice Details</strong></th></tr>
    <tr>
        <td align="left" ><b>Address:</b>
            <b><?php echo $receipt_details[0]['store_name']; ?></b><br />
            <?php echo $receipt_details[0]['address1']; ?>
        </td>
        <td align="center" valign="middle"> <img src="<?= $theme_path; ?>/images/logo-login2.png" alt="Chain Logo" width="125px"></td>
    </tr>
    <tr>
        <td align="left"><b>Invoice NO : </b><?php echo $receipt_details[0]['inv_id'] ?></td>
        <td align="left"><b>Receipt Number : </b><?php echo $receipt_details[0]['receipt_history'][0]['receipt_no'] ?></td>
    </tr>
    <tr>
        <td align="left"><b>Firm Name : </b><?php echo $receipt_details[0]['firm_name']; ?></td>
        <td align="left"><b>Received Date : </b><?php echo date('d-M-Y', strtotime($receipt_details[0]['receipt_history'][0]['created_date'])) ?></td>
    </tr>
</table>
<br /><br />
<table style="padding: 2px 2px;" row-style="page-break-inside:avoid;">
    <tr>
        <td colspan="7" align="center"><b>INVOICE DETAILS</b></td>
    </tr>
    <tr align="center" style="background-color:#e6e6ff;">
        <td width="7%"><b>S.No</b></td>
        <td width="22%" align="left" ><b>Product&nbsp;Name</b></td>
        <td width ="7%"><b>QTY</b></td>
        <td width ="15%" align="right"><b>Cost/QTY</b></td>
        <td width ="11%"><b>CGST&nbsp;%</b></td>
        <td width ="11%"><b>SGST&nbsp;%</b></td>
        <td width ="14%"><b>Discount&nbsp;%</b></td>
        <td width ="13%" align="right"><b>Net&nbsp;Value</b></td>
    </tr>
    <tbody>
        <?php
        $i = 1;
        if (isset($receipt_details[0]['po_details']) && !empty($receipt_details[0]['po_details'])) {
            foreach ($receipt_details[0]['po_details'] as $vals) {
                ?>
                <tr>
                    <td align="center">
                        <?php echo $i; ?>
                    </td>
                    <td align="left">
                        <?php echo $vals['product_name']; ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['quantity'] ?>
                    </td>
                    <td align="right">
                        <?php echo number_format($vals['per_cost'], 2); ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['tax'] ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['gst'] ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['discount'] ?>
                    </td>
                    <td align="right">
                        <?php echo number_format($vals['sub_total'], 2) ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" align="right" ><b>Total</b></td>
            <td align="center"><?php echo $receipt_details[0]['total_qty']; ?></td>
            <td colspan="4" align="right"><b>Sub Total</b></td>
            <td align="right"><?php echo number_format($receipt_details[0]['subtotal_qty'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="7" align="right"><?php echo $receipt_details[0]['tax_label']; ?> </td>
            <td align="right">
                <?php echo number_format($receipt_details[0]['tax'], 2); ?>
            </td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong>Net Total</strong></td>
            <td align="right"><?php echo number_format($receipt_details[0]['net_total'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong>Advance Amount</strong></td>
            <td align="right"><?php echo number_format($receipt_details[0]['advance'], 2); ?></td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong>Received Amount</strong></td>
            <td align="right"><?php echo number_format($receipt_details[0]['receipt_history'][0]['bill_amount'], 2, '.', ',') ?></td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong>Discount</strong></td>
            <td align="right"><?php echo number_format($receipt_details[0]['receipt_history'][0]['discount'], 2, '.', ',') ?> ( <?php echo $receipt_details[0]['receipt_history'][0]['discount_per'] ?> %)</td>
        </tr>
        <tr>
            <td colspan="7" align="right"><strong>Balance Amount</strong></td>
            <td align="right"><?php echo number_format(($receipt_details[0]['net_total'] - ($receipt_details[0]['receipt_history'][0]['bill_amount'] + $receipt_details[0]['advance'] + $receipt_details[0]['receipt_history'][0]['discount'])), 2, '.', ',') ?></td>
        </tr>
        <tr>
            <td colspan="8" align="left">
                <span class="pdf-f">Remarks : </span>
                <?php echo $receipt_details[0]['receipt_history'][0]['remarks']; ?>
            </td>
        </tr>
    </tfoot>
</table>
