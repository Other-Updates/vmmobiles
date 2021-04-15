<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script src="<?php echo $theme_path; ?>/js/jQuery.print.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<style type="text/css">
    .text_right
    {
        text-align:right;
    }
    .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
    #top_heading_fix h3 {top: -57px;left: 6px;}
    #TB_overlay { z-index:20000 !important; }
    #TB_window { z-index:25000 !important; }
    .dialog_black{ z-index:30000 !important; }
    #boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;}
    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .auto-asset-search ul#country-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    .btn-info { background-color:#ffffff;border-color: #000000;color:#a1a3a5;    padding: 2px 2px 2px 2px !important;}
    .btn-info:hover { background-color:#ff4081;border:1px solid #ff4081 !important;color:#ffffff; }
    ul li {
        list-style-type: none;
    }
    .dropdown-menu { min-width: 190px; }
    .dataTable tbody tr td:last-child, .dataTable thead tr th:last-child { text-align:right;}

</style>
<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
            </td>
            <td width="85%">
                <div class="print_header_tit" >
                    <h3> <?= $company_details[0]['firm_name'] ?></h3>
                    <p></p>
                    <p class="pf">  <?= $company_details[0]['address'] ?>,
                    </p>
                    <p></p>
                    <p class="pf"> Pin Code : <?= $company_details[0]['pincode'] ?>,</p>
                    <p></p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="mainpanel">
    <div class="hide_class media mt--40">
        <h4 class="hide_class">View Sales Invoice</h4>
    </div>
    <div class="contentpanel enquiryview ptpb-10 viewquo mb-45 mt-top2">
        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <table class="table ptable" cellpadding="0" cellspacing="0">
                    <tr class="tbor">
                        <td colspan="1">GSTIN NO : <?= $company_details[0]['gstin'] ?></td>
                        <td align="right">Cell : <?= $company_details[0]['mobile_number'] ?> </td>
                    </tr>
                    <tr>
                        <!--<td class="action-btn-align" style="border-bottom:1px solid #fff !important"> <img src="<?= $theme_path; ?>/images/logo.png" width="75px"></td>-->
                        <td style=""><span  class="tdhead">TO,</span>
                            <div><?php echo $val['store_name']; ?></div>
                            <div><?php echo $val['address1']; ?> </div>
                            <div>Mobile : <?php echo ($val['mobil_number']) ? $val['mobil_number'] : '-'; ?></div>
                            <div>Email :  <?php echo ($val['email_id']) ? $val['email_id'] : '-'; ?></div>
                            <div>GSTIN : <?php echo ($val['tin']) ? $val['tin'] : '-'; ?></div>
                        </td>
                        <td align="right" style="vertical-align:top;">Sales Invoice No : <?php echo '' . $val['inv_id']; ?><br /> Reference No :  <?php echo $val['q_no']; ?><br /> Date : <?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?><br />Sales Man : <?php
                            $sales_man = (!empty($val['sales_man_name']) ? $val['sales_man_name'] : '-');
                            echo $sales_man;
                            ?>
                        </td>
                    </tr>
        <!--                    <tr>
                        <td colspan="1"></td>
                        <td align="right">Sales Man : <?php
                    $sales_man = (!empty($val['sales_man_name']) ? $val['sales_man_name'] : '-');
                    echo $sales_man;
                    ?>
                        </td>
                    </tr>-->
                </table>
                <table class="table table-striped table-bordered responsive" id="add_quotation"  cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="1%" class="first_td1 action-btn-align">S.No</td>
                            <td width="10%" class="first_td1">HSN Code</td>
                            <td width="10%" class="first_td1 hide_class">Category</td>
                            <td width="10%" class="first_td1 hide_class">Brand</td>
                            <td width="5%" class="first_td1 hide_class">Unit</td>
                            <td width="20%" class="first_td1 pro-wid">Product&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td width="5%" class="first_td1 action-btn-align ser-wid">QTY</td>
                            <td width="5%" class="first_td1 action-btn-align ser-wid">Return QTY</td>
                            <td width="8%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                            <td width="6%" class="first_td1 action-btn-align ser-wid">Total</td>
                            <!--<td width="7%" class="first_td1 action-btn-align proimg-wid">Discount%</td>-->
                            <td width="6%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                            <?php
                            $gst_type = $quotation[0]['state_id'];
                            if ($gst_type != '') {
                                if ($gst_type == 31) {
                                    ?>
                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                <?php } else { ?>
                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                    <?php
                                }
                            }
                            ?>
                            <td width="8%" class="first_td1 action-btn-align qty-wid">Net&nbsp;Value</td>
                        </tr>
                    </thead>
                    <tbody id='app_table'>
                        <?php
                        $i = 1;
                        $cgst = 0;
                        $sgst = $present_qty = 0;
                        $ret_qty = $total_qty = $sub_tot_amt = $sub_total = 0;
                        if (isset($quotation_details) && !empty($quotation_details)) {
                            $inv = 0;
                            foreach ($quotation_details as $vals) {
                                $present_qty = $vals['actual_qty'][0]['actual_qty'] - $vals['return'][0]['return_qty'];
                                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * (($present_qty < 0) ? 0 : $present_qty));

                                $gst_type = $quotation[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {

                                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * (($present_qty < 0) ? 0 : $present_qty));
                                    } else {
                                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * (($present_qty < 0) ? 0 : $present_qty));
                                    }
                                }

                                $cgst += $cgst1;
                                $sgst += $sgst1;

                                if (isset($val['round_off']) && $val['round_off'] > 0) {
                                    if ($val['net_total'] > ($val['subtotal_qty'] + $val['transport'] + $val['labour'] + $cgst + $sgst)) {
                                        $round_off_plus = $val['round_off'];
                                        $round_off_minus = 0;
                                    } else if ($val['net_total'] < ($val['subtotal_qty'] + $val['transport'] + $val['labour'] + $cgst + $sgst)) {
                                        $round_off_minus = $val['round_off'];
                                        $round_off_plus = 0;
                                    } else {
                                        $round_off_plus = 0;
                                        $round_off_minus = 0;
                                    }
                                }
                                $net_total = $val['net_total'];
                                // if ($val['advance'] != '') {
                                // $net_total = abs($val['net_total']) - abs($val['advance']);
                                // }
                                ?>
                                <tr>
                                    <td class="action-btn-align">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="">
                                        <?php echo!empty($vals['hsn_sac_name']) ? $vals['hsn_sac_name'] : '-'; ?>
                                    </td>
                                    <td class="hide_class">
                                        <?php echo!empty($vals['categoryName']) ? $vals['categoryName'] : '-'; ?>
                                    </td>
                                    <td class="hide_class">
                                        <?php echo!empty($vals['brands']) ? $vals['brands'] : '-'; ?>
                                    </td>
                                    <td class="hide_class">
                                        <?php echo!empty($vals['unit']) ? $vals['unit'] : '-'; ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['product_name'] ?>
                                    </td>

                                    <td class="action-btn-align">
                                        <?php
                                        echo $vals['actual_qty'][0]['actual_qty'];
                                        $total_qty += $vals['actual_qty'][0]['actual_qty'];
                                        ?>
                                    </td>
                                    <td class="action-btn-align">
                                        <?php
                                        echo $vals['return'][0]['return_qty'];
                                        $ret_qty += $vals['return'][0]['return_qty'];
                                        ?>
                                    </td>
                                    <td class="text_right">
                                        <?php echo number_format($vals['per_cost'], 2); ?>
                                    </td>
                                    <td class="text_right">
                                        <?php
                                        $qty = ($vals['invoice'][0]['quantity'] - $vals['return_quantity']);
                                        echo number_format(((($present_qty < 0) ? 0 : $present_qty) * $vals['per_cost']), 2);
                                        ?>
                                    </td>

                                    <td class="action-btn-align">
                                        <?php echo $vals['tax']; ?>
                                    </td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['gst']; ?>
                                            </td>
                                        <?php } else { ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['igst']; ?>
                                            </td>

                                            <?php
                                        }
                                    }
                                    ?>
                                    <td class="text_right" style="text-align:right;">
                                        <?php
                                        $presenet_qty = $vals['actual_qty'][0]['actual_qty'] - $vals['return'][0]['return_qty'];
                                        $sub_total = (($present_qty < 0) ? 0 : $present_qty) * $vals['per_cost'];
                                        echo number_format($sub_total, 2);
                                        $sub_tot_amt += $sub_total;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                                $inv++;
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="3" style="width:70px; text-align:right;">Total</td>
                            <td class="action-btn-align"><?php echo $total_qty; ?></td>
                            <td class="action-btn-align"><?php echo $ret_qty; ?></td>
                            <td colspan="4" style="text-align:right;">Sub Total : </td>
                            <td class="text_right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="4" style="width:70px; text-align:right;" class="bor-tb0"></td>
                            <td colspan="5" style="text-align:right;" class="bor-tb0 bor-tr0">Advance Amount : </td>
                            <td class="text_right bor-tb0"><?php echo (!empty($val['advance'])) ? number_format($val['advance'], 2) : 0.00; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="4" style="width:70px; text-align:right;" class="bor-tb0"></td>
                            <td colspan="5"  style="text-align:right;" class="bor-tb0"><?php echo $val['tax_label']; ?> </td>
                            <td class="text_right bor-tb0"><?php echo number_format($val['tax'], 2); ?></td>
                        </tr>
                        <?php
                        foreach ($val['other_cost'] as $key) {
                            ?>
                            <tr>
                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="4" class="bor-tb0" style="width:70px; text-align:right;"></td>
                                <td colspan="5" style="text-align:right;"><?php echo $key['item_name']; ?> </td>
                                <td class="text_right"><?php echo number_format($key['amount'], 2); ?></td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td colspan="3" class="hide_class"></td>
                            <td colspan="4" class="bor-tb0">
                            </td>
                            <td colspan="5" style="text-align:right;" class="bor-tb0 bor-tr0">Round Off ( - ) :<br>

                            </td>
                            <td class="text_right bor-tb0" ><?php echo number_format($val['round_off'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;" class="hide_class"></td>
                            <td colspan="4" class="bor-tb0">	</td>
                            <td colspan="5" style="text-align:right;" class="bor-tb0">CGST : </td>
                            <td class="text_right bor-tb0"><?php echo number_format($cgst, 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;" class="hide_class"></td>
                            <td colspan="4" class="bor-tb0">ACC No : <?php echo $val['account_num']; ?></td>
                            <?php
                            $gst_type = $quotation[0]['state_id'];
                            if ($gst_type != '') {
                                if ($gst_type == 31) {
                                    ?>
                                    <td colspan="5" style="text-align:right;" class="bor-tb0">SGST : </td>
                                <?php } else { ?>
                                    <td colspan="5" style="text-align:right;" class="bor-tb0">IGST : </td>

                                    <?php
                                }
                            }
                            ?>
                            <td class="text_right bor-tb0" ><?php echo number_format($sgst, 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="4" class="bor-tb0">
                                IFSC Code : <?php echo $val['ifsc']; ?>
                            </td>
                            <td colspan="5"style="text-align:right;" class="bor-tb0">Transport Charge : </td>
                            <td class="text_right bor-tb0" ><?php echo number_format($val['transport'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="4" class="bor-tb0">
                                Bank Name : <?php echo $val['bank_name']; ?>
                            </td>
                            <td colspan="5"style="text-align:right;" class="bor-tb0">Labour Charge : </td>
                            <td class="text_right bor-tb0" ><?php echo number_format($val['labour'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                            <td colspan="4" class="bor-tb0">
                                <?php echo $in_words; ?>
                            </td>
                            <td colspan="5" style="text-align:right;font-weight:bold; font-size:15px;" class="bor-tb0">Net Total : </td>
                            <td class="text_right bor-tb0" style="font-size:15px;"><?php echo number_format($net_total, 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="125"><span style="float:left; top:12px;">Remarks&nbsp;:&nbsp;</span> <?php echo $val['remarks']; ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <center><h4><strong>Sales Return History</strong></h4></center>
                <table class="table table-striped table-bordered responsive" id="add_quotation"  cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                S.no
                            </td>
                            <td style="text-align:center">
                                Return Date
                            </td>
                            <td style="text-align:center">
                                Return QTY
                            </td>
                            <td style="text-align:center">
                                Return AMT
                            </td>
                            <td style="text-align:center">
                                Return Copy
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($return_details) && !empty($return_details)) {
                            $k = 1;
                            $rt_qty = $rt_amt = 0;
                            foreach ($return_details as $key => $return) {
                                if ($key > 0) {
                                    $net_total1 = 0;
                                    $cgst = 0;
                                    $sgst = 0;
                                    foreach ($return['return_details'] as $ret_det) {
                                        if ($ret_det['return_quantity'] != 0) {
                                            $cgst1 = ($ret_det['tax'] / 100 ) * ($ret_det['per_cost'] * ($ret_det['return_quantity']));

                                            $gst_type = $quotation[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {

                                                    $sgst1 = ($ret_det['gst'] / 100 ) * ($ret_det['per_cost'] * ($ret_det['return_quantity']));
                                                } else {
                                                    $sgst1 = ($ret_det['igst'] / 100 ) * ($ret_det['per_cost'] * ($ret_det['return_quantity']));
                                                }
                                            }

                                            $cgst = $cgst1;
                                            $sgst = $sgst1;
                                            $net_total1 += ($ret_det['per_cost'] * $ret_det['return_quantity']) + $cgst + $sgst;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td style="text-align:center"><?php echo $k; ?></td>
                                        <td style="text-align:center"><?php echo ($return['created_date'] != '') ? date('d-M-Y', strtotime($return['created_date'])) : '-'; ?></td>
                                        <td style="text-align:center"><?php
                                            echo $return['return_quantity'][0]['return_quantity'];
                                            $rt_qty += $return['return_quantity'][0]['return_quantity'];
                                            ?></td>
                                        <td style="text-align:center"><?php
                                            echo number_format($net_total1, 2);
                                            $rt_amt += $net_total1;
                                            ?></td>
                                        <td style="text-align:center">
                                            <?php
                                            $bill_copy_url = '<a target="_blank" style="border-radius: 0;" href="' . $this->config->item('base_url') . 'sales_return/return_bill_copy/' . $return['id'] . '/' . $quotation[0]['id'] . '" data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="" data-original-title="View"><span>Print Return Copy</span></a>';
                                            echo $bill_copy_url;
                                            ?>
                                        </td>

                                    </tr>
                                    <?php
                                    $k++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                    <td></td>
                    <td></td>
                    <td style="text-align:center" class="total-bg"><?php echo number_format($rt_qty, 0); ?></td>
                    <td style="text-align:center" class="total-bg"><?php echo number_format($rt_amt, 2); ?></td>
                    </tfoot>
                </table>


                <div class="hide_class action-btn-align">
                    <a href="<?php echo $this->config->item('base_url') . 'sales_return/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                    <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>



                </div>

                <?php
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
<script>
    $('.print_btn').click(function () {
        window.print();
    });

</script>
