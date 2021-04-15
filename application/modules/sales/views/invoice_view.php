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

                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo-login2.png" /></div>

            </td>

            <td width="85%">

                <div class="print_header_tit" >

                    <h3> <?= $company_details[0]['firm_name'] ?></h3>

                    <p></p>

                    <p class="pf">  <?= $company_details[0]['address'] ?>,

                    </p>

                    <p></p>

                    <p class="pf"> Pin Code : <?= $company_details[0]['pincode'] ?></p>

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

                        <td>GSTIN NO : <?= $company_details[0]['gstin'] ?></td>

                        <td align="center"><b>TAX INVOICE</b></td>

                        <td align="right">Cell : <?= $company_details[0]['mobile_number'] ?> </td>

                    </tr>

                    <tr>



                        <td style=""><span  class="tdhead">TO,</span>

                            <div><?php echo $val['store_name']; ?></div>

                            <div><?php echo $val['address1']; ?> </div>

                            <div>Mobile : <?php echo ($val['mobil_number']) ? $val['mobil_number'] : '-'; ?></div>

                            <div>Email :  <?php echo ($val['email_id']) ? $val['email_id'] : '-'; ?></div>

                            <div>GSTIN : <?php echo ($val['tin']) ? $val['tin'] : '-'; ?></div>

                        </td>

                        <td align="center"></td>

                        <td align="right" style="vertical-align:top;">Invoice No : <?php echo '' . $val['inv_id']; ?><br /> Reference No :  <?php echo $val['q_no']; ?><br /> Date : <?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?><br />Sales Man : <?php

                            $sales_man = (!empty($val['sales_man_name']) ? $val['sales_man_name'] : '-');

                            echo $sales_man;

                            ?>

                        </td>

                    </tr>



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

                            <td width="8%" class="first_td1 action-btn-align ser-wid">Unit Price</td>

                            <!--<td width="6%" class="first_td1 action-btn-align ser-wid">Total</td>-->

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

                            <td width="8%" class="first_td1 action-btn-align qty-wid">Basic&nbsp;Value</td>

                        </tr>

                    </thead>

                    <tbody id='app_table'>

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

                                        <?php echo $vals['quantity'] ?>

                                    </td>

                                    <td class="text_right">

                                        <?php echo number_format($vals['per_cost'], 2); ?>

                                    </td>

                                    <!--<td class="text_right">-->

                                    <?php //echo number_format(($vals['quantity'] * $vals['per_cost']), 2) ?>

                                    <!--</td>-->

                <!--                                    <td class="action-btn-align">

                                    <?php //echo $vals['discount'] ?>

                                    </td>-->

                                    <td class="action-btn-align">

                                        <?php echo $vals['tax'] ?>

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

                            <td colspan="3" style="width:70px; text-align:right;">Total</td>

                            <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>

                            <td colspan="3" style="text-align:right;">Sub Total : </td>

                            <td class="text_right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                        </tr>

        <!--                        <tr>

                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                            <td colspan="4" style="width:70px; text-align:right;" class="bor-tb0"></td>

                            <td colspan="3" style="text-align:right;" class="bor-tb0 bor-tr0">Advance Amount : </td>

                            <td class="text_right bor-tb0"><?php //echo (!empty($val['advance'])) ? number_format($val['advance'], 2) : 0.00;    ?></td>

                        </tr>-->

                        <?php if ($val['tax_label'] != '') { ?>

                            <tr>

                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                                <td colspan="4" style="width:70px; text-align:right;" class="bor-tb0"></td>

                                <td colspan="3"  style="text-align:right;" class="bor-tb0"><?php echo $val['tax_label']; ?> </td>

                                <td class="text_right bor-tb0"><?php echo number_format($val['tax'], 2); ?></td>

                            </tr> <?php } ?>

                        <?php

                        foreach ($val['other_cost'] as $key) {

                            ?>

                            <tr>

                                <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                                <td colspan="4" class="bor-tb0" style="width:70px; text-align:right;"></td>

                                <td colspan="3" style="text-align:right;"><?php echo $key['item_name']; ?> </td>

                                <td class="text_right"><?php echo number_format($key['amount'], 2); ?></td>

                            </tr>

                        <?php }

                        ?>



                        <tr>

                            <td colspan="3" style="width:70px; text-align:right;" class="hide_class"></td>

                            <td colspan="4" class="bor-tb0">	</td>

                            <td colspan="3" style="text-align:right;" class="bor-tb0">Add CGST : </td>

                            <td class="text_right bor-tb0"><?php echo number_format($cgst, 2); ?></td>

                        </tr>

                        <tr>

                            <td colspan="3" class="hide_class"></td>

                            <td colspan="4" class="bor-tb0"></td>

                            <?php

                            $gst_type = $quotation[0]['state_id'];

                            if ($gst_type != '') {

                                if ($gst_type == 31) {

                                    ?>

                                    <td colspan="3" style="text-align:right;" class="bor-tb0">Add SGST : </td>

                                <?php } else { ?>

                                    <td colspan="3" style="text-align:right;" class="bor-tb0">Add IGST : </td>



                                    <?php

                                }

                            }

                            ?>

                            <td class="text_right bor-tb0" ><?php echo number_format($sgst, 2); ?></td>



                        </tr>

                        <tr>

                            <td colspan="3" style="width:70px; text-align:right;" class="hide_class"></td>

                            <td colspan="4" class="bor-tb0">ACC No : <?php echo $val['account_num']; ?></td>

                            <td colspan="3"style="text-align:right;" class="bor-tb0">Transport Charge : </td>

                            <td class="text_right bor-tb0" ><?php echo number_format($val['transport'], 2); ?></td>



                        </tr>

                        <tr>

                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                            <td colspan="4" class="bor-tb0">

                                IFSC Code : <?php echo $val['ifsc']; ?>

                            </td>

                            <td colspan="3"style="text-align:right;" class="bor-tb0">Labour Charge : </td>

                            <td class="text_right bor-tb0" ><?php echo number_format($val['labour'], 2); ?></td>



                        </tr>

                        <tr>

                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                            <td colspan="4" class="bor-tb0">

                                Bank Name : <?php echo $val['bank_name']; ?>

                            </td>

                            <td colspan="3" style="text-align:right;" class="bor-tb0 bor-tr0">Round Off ( - ) :<br>



                            </td>

                            <td class="text_right bor-tb0" ><?php echo number_format($val['round_off'], 2); ?></td>



                        </tr>

                        <tr>

                            <td colspan="3" class="hide_class" style="width:70px; text-align:right;"></td>

                            <td colspan="4" class="bor-tb0">

                                <?php echo $in_words; ?>

                            </td>

                            <td colspan="3" style="text-align:right;font-weight:bold; font-size:15px;" class="bor-tb0">Net Total : </td>

                            <td class="text_right bor-tb0" style="font-size:15px;"><?php echo number_format($net_total, 2); ?></td>



                        </tr>

                        <tr>

                            <td colspan="125"><span style="float:left; top:12px;">Remarks&nbsp;:&nbsp;</span> <?php echo $val['remarks']; ?>

                            </td>

                        </tr>

                    </tfoot>

                </table>

                <div  class="sign" style="margin-top:40px; display: none;">

                    <table class="table" cellpadding="0" cellspacing="0">

                        <tr class="tbor">

                            <td>Customer's Signature</td>

                            <td align="center"></td>

                            <td align="right">Signature</td>

                        </tr>

                    </table>

                </div>

                <div class="hide_class action-btn-align">

                    <a href="<?php echo $this->config->item('base_url') . 'sales/invoice_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                    <?php if ($quotation[0]['customer_type'] == 3) { ?>

                        <button class="btn btn-defaultprint6" data-toggle="dropdown"><span class="glyphicon glyphicon-print" ></span> Print</button>

                        <ul class="dropdown-menu dropdown-menu-left" style="bottom: auto; top: 98%;margin-left: 630px;">

                            <li><a href="javascript:void(0);" class="print_cus" mode="1" sr_id="<?php echo $quotation[0]['id']; ?>"><i class="icon-copy3"></i> Customer Invoice</a></li>

                            <li><a href="javascript:void(0);" class="print_con" mode="2" sr_id="<?php echo $quotation[0]['id']; ?>"><i class="icon-copy4"></i> Contractor Invoice</a></li>

                        </ul>

                    <?php } else { ?>

                        <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>

                    <?php } ?>

                    <?php if ((isset($_GET['notification']) && $_GET['notification'] != '') || ($user_info[0]['role'] == 1 && $quotation[0]['invoice_status'] == 'waiting')) { ?>

                        <button class="btn btn-defaultprint6" id="approve">Approve</button>

                    <?php } ?>

                    <input type="button" class="btn btn-success" id='send_mail' style="float:right;top: 100%"  value="Send Email"/>





                </div>



                <?php

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

                url: BASE_URL + "sales/send_email",

                type: 'GET',

                data: {

                    id:<?= $quotation[0]['id'] ?>

                },

                success: function (result) {

                    alert(result);

                    for_response();

                }

            });

        });

        $('.print_con').click(function () {

            ConfirmDialog('Are you sure want to Print invoice ?');



        });

        $('.print_cus').click(function () {

            var sr_id = $(this).attr('sr_id');

            var url = '<?php echo base_url(); ?>sales/customer_invoice_pdf/' + sr_id;

            window.open(url, '_blank');

        });

        $('#approve').click(function () {

            var id = '<?php echo $quotation[0]['id'] ?>';

            var user = '<?php echo $user_info[0]['role'] ?>';

            if (user == 1)

            {

                $.ajax({

                    url: BASE_URL + "sales/approve_invoice",

                    type: 'POST',

                    data: {

                        id: id,

                    },

                    success: function (result) {

                        if (result == 'success') {

                            swal({

                                title: "Success!",

                                text: "Invoice Approved!",

                                type: "success"

                            }, function () {

                                window.location = BASE_URL + "sales/invoice_list";

                            });

                        }

                    }

                });

            } else {

                sweetAlert("Oops..!", "You Dont Have Permission to approve the invoice!", "error");

                return false;

            }

        });

        $('.print_btn').click(function () {

            ConfirmDialog('Are you sure want to Print invoice ?');

        });

        function ConfirmDialog(message) {

            $('<div></div>').appendTo('body')

                    .html('<div><h6><strong>' + message + '</strong></h6></div>')

                    .dialog({

                        modal: true, title: 'Print Confirm', zIndex: 10000, autoOpen: true,

                        width: '300px', resizable: false,

                        buttons: {

                            Yes: function () {

                                // $(obj).removeAttr('onclick');

                                // $(obj).parents('.Parent').remove();



                                window.print();

                                $(this).dialog("close");

                            },

                            No: function () {

                                $(this).dialog("close");

                            }

                        },

                        close: function (event, ui) {

                            $(this).remove();

                        }

                    });

        }



    });



</script>



