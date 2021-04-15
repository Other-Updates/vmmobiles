<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style type="text/css">
    table {border-collapse:collapse; width:100%; font-size:7px }
    table tr th{ text-align:center; border:1px solid #ddd; padding:2px 2px 2px 2px; vertical-align:middle;}
    table tr td { text-align:center; border:1px solid #ddd; padding:2px 2px 2px 2px; vertical-align:middle;}
    .pdf-f{font-weight:bold}
    table tbody tr td:nth-child(even){ background:#e1e1e1}
</style>
<table style="padding: 5px 2px;" row-style="page-break-inside:avoid;" bgcolor="#f5f5f5">
    <tr><th colspan="2" style="color:#fff;" bgcolor="#333"><strong>Sales Invoice Details</strong></th></tr>
    <tr>
        <td align="left" ><b>Address:</b>
            <b><?php echo $quotation[0]['store_name']; ?></b><br />
            <?php echo $quotation[0]['address1']; ?> <br />
            Phone No : <strong><?php echo $quotation[0]['mobil_number']; ?> </strong><br />
            Email id : <strong><?php echo $quotation[0]['email_id']; ?> </strong>
        </td>
        <td align="center" valign="middle"> <img src="<?= $theme_path; ?>/images/logo.png" width="120" ></td>
    </tr>
    <tr>
        <td align="left"><b>Invoice NO : </b> <?php echo $quotation[0]['inv_id'] ?></td>
        <td align="left"><b>Receipt Number : </b> <?php echo $quotation[0]['q_no'] ?></td>
    </tr>
    <tr>
        <td align="left"><b>Firm Name : </b> <?php echo $quotation[0]['firm_name']; ?></td>
        <td align="left"><b>Received Date : </b> <?php echo date('d-M-Y', strtotime($quotation[0]['created_date'])) ?></td>
    </tr>
</table>
<br /><br />
<table style="padding: 5px 2px;" row-style="page-break-inside:avoid;">
    <tr>
        <td colspan="7" align="center" style="color:#fff;" bgcolor="#333"><b>Invoice Details</b></td>
    </tr>
    <tr align="center" style="background-color:#e6e6ff;">
        <td width="7%" style="padding:5px;"><b>S.No</b></td>
        <td width="28%" align="left"><b>Product Name</b></td>
        <td width ="8%" align="center"><b>QTY</b></td>
        <td width ="15%" align="right"><b>Cost/QTY</b></td>
        <td width ="13%"><b>CGST&nbsp;%</b></td>
        <?php
        $gst_type = $quotation[0]['state_id'];
        if ($gst_type != '') {
            if ($gst_type == 31) {
                ?>
                <td width ="13%"><b>SGST&nbsp;%</b></td>
            <?php } else { ?>
                <td width ="13%"><b>IGST&nbsp;%</b></td>
                <?php
            }
        }
        ?>
<!--<td width ="13%"><b>Discount&nbsp;%</b></td>-->
        <td width ="15%" align="right"><b>Net&nbsp;Value</b></td>
    </tr>
    <tbody>
        <?php
        $i = 1;
        $cgst = 0;
        $sgst = 0;
        if (isset($quotation_details) && !empty($quotation_details)) {
            foreach ($quotation_details as $vals) {
                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                $gst_type = $quotation[0]['state_id'];
                if ($gst_type != '') {
                    if ($gst_type == 31) {

                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                    } else {
                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                    }
                }
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
                        <?php echo number_format($vals['per_cost'], 2); ?>
                    </td>
                    <td align="center">
                        <?php echo $vals['tax'] ?>
                    </td>
                    <?php
                    $gst_type = $quotation[0]['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {
                            ?>
                            <td align="center">
                                <?php echo $vals['gst'] ?>
                            </td>
                        <?php } else { ?>
                            <td align="center">
                                <?php echo $vals['igst'] ?>
                            </td>
                            <?php
                        }
                    }
                    ?>

                        <!--                    <td align="center">
                    <?php echo $vals['discount'] ?>
                                            </td>-->
                    <td align="right">
                        <strong><?php echo number_format($vals['sub_total'], 2) ?></strong>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
    </tbody>
    <?php
    $s_total = $quotation[0]['net_total'] - ($quotation[0]['transport'] + $quotation[0]['labour']);
    $class = '';
    if ($s_total > $quotation[0]['subtotal_qty']) {
        $class = '+';
    } else {
        $class = '-';
    }
    ?>
    <tfoot>
        <tr>
            <td colspan="2" align="right" ><b>Total  </b></td>
            <td align="center"><strong><?php echo $quotation[0]['total_qty']; ?></strong></td>
            <td colspan="3" align="right"><b>Sub Total  </b></td>
            <td align="right"><strong><?php echo number_format($quotation[0]['subtotal_qty'], 2); ?></strong></td>
        </tr>

        <tr>
            <td colspan="6" align="right"><b>Add CGST  </b> </td>
            <td align="right"><?php echo number_format($cgst, 2); ?></td>

        </tr>
        <tr>
            <?php
            $gst_type = $quotation[0]['state_id'];
            if ($gst_type != '') {
                if ($gst_type == 31) {
                    ?>
                    <td colspan="6" align="right"><b>Add SGST  </b> </td>
                <?php } else { ?>
                    <td colspan="6" align="right"><b>Add IGST  </b> </td>
                    <?php
                }
            }
            ?>

            <td align="right"><?php echo number_format($sgst, 2); ?></td>
        </tr>
        <tr>
            <td colspan="6" align="right"><b>Transport Charge  </b> </td>
            <td align="right">
                <strong> <?php echo number_format($quotation[0]['transport'], 2); ?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="right"><b>Labour Charge  </b> </td>
            <td align="right">
                <strong><?php echo number_format($quotation[0]['labour'], 2); ?></strong>
            </td>
        </tr>
        <?php if ($s_total != $quotation[0]['subtotal_qty']) { ?>
            <tr>
                <td colspan="6" align="right"><b>Round Off</b>
                    <i class="glyphicon glyphicon-plus">(<?php echo $class; ?>)</i></td>
                <td align="right">
                    <strong><?php echo number_format($quotation[0]['round_off'], 2); ?></strong>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="6" align="right"><strong>Net Total  </strong> </td>
            <td align="right"><strong><?php echo number_format($quotation[0]['net_total'], 2); ?></strong>  </td>
        </tr>
        <tr>
            <td colspan="7" align="left">
                <span class="pdf-f">Remarks : </span>
                <?php echo $quotation[0]['remarks']; ?>
            </td>
        </tr>
    </tfoot>
</table>
