<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
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
    <div class="media mt--20 hide_class">
        <h4 class="">Delivery Challan
        </h4>
    </div>
    <div class="contentpanel enquiryview  ptpb-10  viewquo mb-45">

        <?php
//        echo "<pre>";
//        echo "1";
//        print_r($po);
//        exit;
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                    <tr class="tbor">
                        <td colspan="2">GSTIN NO : <?= $company_details[0]['gstin'] ?></td>
                        <td  colspan="2" align="right">Cell : <?= $company_details[0]['mobile_number'] ?> </td>
                    </tr>
                    <tr>
                        <td colspan="2"><span  class="tdhead">TO,</span>
                            <div><b><?php echo $val['store_name']; ?></b></div>
                            <div><?php echo $val['address1']; ?> </div>
                            <div> <?php echo $val['mobil_number']; ?></div>
                            <div> <?php echo $val['email_id']; ?></div>
                        </td>

                        <td class="action-btn-align" colspan="2"> <img src="<?= $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px"></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td><span class="tdhead">Firm Name</span></td>
                        <td><?php echo $val['firm_name']; ?></td>
                        <td><span  class="tdhead">Customer Name:</span></td>
                        <td><?php echo $val['store_name']; ?></td>


                    </tr>
                    <tr>
                        <td><span  class="tdhead">Customer GSTIN:</span></td>
                        <td><?= $val['tin'] ?></td>
                        <td><span  class="tdhead"> Date:</span></td>
                        <td><?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>

                    </tr>
                </table>
                <form method="post" action="<?php echo $this->config->item('base_url') . 'delivery_challan/dc_edit/' . $val['id'] ?>" id="add_delivary" >
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                        <thead>
                            <tr>
                                <td width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class="hide_class first_td1">Category</td>
                                <td width="10%" class="first_td1">Product Name</td>
                                <td width="10%" class="hide_class first_td1">Brand</td>
                                <td width="5%" class="hide_class first_td1">Unit</td>
                                <td width="8%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td width="8%" class="first_td1 action-btn-align ser-wid">Delivery QTY</td>
                                <td width="8%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <td width="5%" class="first_td1 action-btn-align ser-wid">Total</td>
                                <td width="7%" class="first_td1 action-btn-align proimg-wid">Discount%</td>
                                <td width="5%" class="first_td1 action-btn-align proimg-wid">CGST %</td>
                                <?php
                                $gst_type = $po[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {
                                        ?>
                                        <td  width="5%" class="first_td1 action-btn-align proimg-wid" >SGST %</td>
                                    <?php } else { ?>
                                        <td  width="5%" class="first_td1 action-btn-align proimg-wid" >IGST %</td>

                                        <?php
                                    }
                                }
                                ?>
                                <td width="5%" class="first_td1 action-btn-align qty-wid">Net Value</td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($po_details) && !empty($po_details)) {
                                foreach ($po_details as $vals) {
                                    ?>
                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>

                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['categoryName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['product_name']; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['brands']) ? $vals['brands'] : '-' ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo!empty($vals['unit']) ? $vals['unit'] : '-' ?>
                                        </td>
                                        <td class="action-btn-align act_qty">
                                            <?php if ($val['delivery_status'] != 'delivered') { ?>
                                                <input type="checkbox"  class="delivary hide_class"  />&nbsp;&nbsp;
                                            <?php } ?>
                                            <input type="hidden" name="id[]" value=" <?php echo $vals['id']; ?>"  />
                                            <input type="hidden" name="total_qty" value=" <?php echo $val['total_qty']; ?>"  />

                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="action-btn-align del_qty">
                                            <?php echo $vals['delivery_quantity'] ?>
                                        </td>
                                        <td class="text_right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                                        <td class="text_right">
                                            <?php echo number_format(($vals['quantity'] * $vals['per_cost']), 2) ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['discount'] ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['tax'] ?>
                                        </td>
                                        <?php
                                        $gst_type = $po[0]['state_id'];
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
                                <td colspan="2" style="width:70px; text-align:right;"><b>Total</b></td>
                                <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                <td class="action-btn-align"><?php echo $val['delivery_qty']; ?></td>
                                <td colspan="5" style="text-align:right;"><b>Sub Total</b></td>
                                <td class="text_right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3"  class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="9" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text_right">
                                    <?php echo number_format($val['tax'], 2); ?>

                            </tr>
                            <tr>
                                <td colspan="3"  class="hide_class" style="width:70px; text-align:right;"></td>
                                <td colspan="9"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text_right"><?php echo number_format($val['net_total'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="12" style="">
                                    <span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo $val['remarks']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="14" style="">
                                    <span style="float:left;  top:12px;"><b>Signature&nbsp;&nbsp;&nbsp;</b></span>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="hide_class action-btn-align">
                        <a href="<?php echo $this->config->item('base_url') . 'delivery_challan/delivery_challan_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                        <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                        <?php if ($val['delivery_status'] == 'partially_delivered' || $val['delivery_status'] == 'pending') { ?>
                            <a type="submit" class="btn btn-success" id="save_delivary"><span class="glyphicon  glyphicon-check"></span> Delivered </a>
                        <?php } ?>
                    </div>
                </form>
                <?php
            }
        } else {
            ?>
            <center>No Data Found</center>
        <?php }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->
<script>
    $('.print_btn').click(function () {
        window.print();
        return false;
    });
    var qtys = $('.delivary').closest('tr').find('td.del_qty').text();
    $('.delivary').click(function () {

        var qty = $(this).closest('tr').find('td.del_qty').text();
        if ($(this).prop('checked') == true) {
            $(this).closest('tr').find('input.delivary').prop('checked', true);
            $(this).closest('tr').find('td.del_qty').html('<input type="text" class="delivery_qty required" style="width:70px" value="' + Number(qty) + '" name="delivery_quantity[]"/><span class="error_msg"></span>');
        }

        if ($(this).prop('checked') == false) {
            $(this).closest('tr').find('input.delivary').prop('checked', false);
            $(this).closest('tr').find('td.del_qty').text(qtys);
        }
    });
    $(document).on('click', '#save_delivary', function () {
        var m = 0;
        $('#app_table').find('input.required').each(function () {
            this_val = $.trim($(this).val());
            this_val2 = $.trim($(this).closest('tr').find('.act_qty').text());
            this_id = $(this);
            if (Number(this_val) > Number(this_val2)) {
                this_id.closest('tr td.del_qty').find('span.error_msg').text('Invalid Quantity').css({'display': 'inline-block'});
                m++;
            } else {
                this_id.closest('tr td.del_qty').find('span.error_msg').text('').css('display', 'none');
            }
        });
        if (m > 0)
        {
            return false;
        } else {
            $('#add_delivary').submit();
        }
    });
</script>

