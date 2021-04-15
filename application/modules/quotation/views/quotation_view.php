<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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
    ul li {
        list-style-type: none;
    }

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
    <div class="media mt--40 hide_class">
        <h4 class="hide_class">View Quotation
            <a href="<?php echo $this->config->item('base_url') . 'quotation/history_view/' . $quotation[0]['id'] ?>" class="btn btn-success right topgen">Quotation History</a>
        </h4>
    </div>
    <div class="contentpanel enquiryview  viewquo">
        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <div class="mscroll">
                    <div class="tpadd10">
                        <table class="table ptable" cellpadding="0" cellspacing="0">
                            <tr class="tbor">
                                <td colspan="1">GSTIN NO : <?= $company_details[0]['gstin'] ?></td>
                                <td  colspan="1" align="right">Cell : <?= $company_details[0]['mobile_number'] ?> </td>
                            </tr>
                            <tr>
                                <td><span  class="tdhead">TO,</span>
                                    <div><?php echo $val['store_name']; ?></div>
                                    <div><?php echo $val['address1']; ?> </div>
                                    <div>Mobile : <?php echo ($val['mobil_number']) ? $val['mobil_number'] : '-'; ?></div>
                                    <div>Email :  <?php echo ($val['email_id']) ? $val['email_id'] : '-'; ?></div>
                                    <div>GSTIN : <?php echo ($val['tin']) ? $val['tin'] : '-'; ?></div>
                                </td>
                                <td align="right" style="vertical-align:top;">
                                    <span  class="tdhead">Quotation NO : </span><?php echo $val['q_no']; ?><br />
                                    <span  class="tdhead">Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="mscroll">
                    <table class="table table-striped table-bordered responsive" id="add_quotation" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr><td width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class="first_td1">HSN Code</td>
                                <td width="10%" class=" first_td1 hide_class">Category</td>
                                <td width="25%" class=" first_td1">Product Name</td>
                                <td width="10%" class=" first_td1 hide_class">Brand</td>
                                <td width="5%" class=" first_td1 hide_class">Unit</td>
                                <td  width="5%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="8%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <!--<td  width="5%" class="first_td1 action-btn-align ser-wid">Total</td>-->
                                <!--<td  width="7%" class="first_td1 action-btn-align proimg-wid hide_class">Discount%</td>-->
                                <td  width="6%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                <?php
                                $gst_type = $quotation[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {
                                        ?>
                                        <td  width="6%" class="first_td1 action-btn-align ser-wid" >SGST%</td>
                                    <?php } else { ?>
                                        <td  width="6%" class="first_td1 action-btn-align ser-wid" >IGST%</td>

                                        <?php
                                    }
                                }
                                ?>
                                <td  width="7%" class="first_td1 action-btn-align qty-wid">Net Value</td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>

                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class="">
                                            <?php echo!empty($vals['hsn_sac_name']) ? $vals['hsn_sac_name'] : '-'; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td class="">
                                            <?php echo $vals['product_name'] ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['brands']) ? $vals['brands'] : '-' ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['unit']) ? $vals['unit'] : '-' ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="text_right">
                                            <?php echo number_format($vals['per_cost'], 2) ?>
                                        </td>
                <!--                                        <td class="text_right">
                                        <?php echo number_format(($vals['quantity'] * $vals['per_cost']), 2) ?>
                                        </td>-->
                <!--                                        <td class="action-btn-align hide_class">
                                        <?php echo $vals['discount'] ?>
                                        </td>-->

                                        <td class="action-btn-align">
                                            <?php echo $vals['tax'] ?>
                                        </td>
                                        <?php
                                        $gst_type = $quotation[0]['state_id'];
                                        if ($gst_type != '') {
                                            if ($gst_type == 31) {
                                                ?>
                                                <td class="action-btn-align" >
                                                    <?php echo $vals['gst']; ?>
                                                </td>
                                            <?php } else { ?>
                                                <td class="action-btn-align" >
                                                    <?php echo $vals['igst']; ?>
                                                </td>

                                                <?php
                                            }
                                        }
                                        ?>
                                        <td class="text_right">
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
                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="3" style="width:70px; text-align:right;"><b>Total</b></td>
                                <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                                <td colspan="3" style="text-align:right;"><b>Sub Total</b></td>
                                <td class="text_right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="7" style="text-align:right;"><strong><?php echo $val['tax_label']; ?></strong> </td>
                                <td class="text_right">
                                    <?php echo number_format($val['tax'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="7"style="text-align:right;"><strong>Net Total</strong></td>
                                <td class="text_right"><?php echo number_format($val['net_total'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="11" style=""><span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo $val['remarks']; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="inner-sub-tit mstyle hide_class">TERMS AND CONDITIONS</div>
                <div class="row hide_class">
                    <div class="col-md-3">Delivery Schedule : <span class="termcolor"><?php echo ($val['delivery_schedule'] != '1970-01-01') ? $val['delivery_schedule'] : '-'; ?></span></div>
                    <div class="col-md-3">Notification Date : <span class="termcolor"><?php echo ($val['notification_date'] != '1970-01-01') ? $val['notification_date'] : '-'; ?></span></div>
                    <div class="col-md-3">Mode of Payment : <span class="termcolor"><?php echo ($val['mode_of_payment'] != '') ? $val['mode_of_payment'] : '-'; ?></span></div>
                    <div class="col-md-3">Validity : <span class="termcolor"><?php echo ($val['validity'] != '') ? $val['validity'] : '-'; ?></span></div>

                </div>
                <div class="hide_class action-btn-align footer-button">
                    <?php if ($val['estatus'] == 2) { ?>

                        <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                        <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                        <!--<input type="button" class="btn btn-success" id='send_mail'  value="Send Email"/>-->
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>" class="btn complete"><span class="glyphicon"></span> Complete </a>

                        <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                        <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                        <!--<input type="button" class="btn btn-success" id='send_mail' value="Send Email"/>-->
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
<script>
    $(document).ready(function () {
        $('#send_mail').click(function () {
            var s_html = $('.size_html');
            for_loading();
            $.ajax({
                url: BASE_URL + "quotation/send_email",
                type: 'GET',
                data: {
                    id:<?= $quotation[0]['id'] ?>
                },
                success: function (result) {
                    for_response();
                }
            });
        });
    });

    $('.print_btn').click(function () {
        window.print();
    });
    $(document).ready(function () {
        window.print();
    });

</script>
