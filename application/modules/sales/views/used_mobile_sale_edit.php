<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery.scannerdetection.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js/sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css" />
<script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/toastr.min.css" />
<script type='text/javascript' src='<?= $theme_path; ?>/js/toastr.min.js'></script>

<style type="text/css">
    .text_right {



        text-align: right;





    }



    .box,
    .box-body,
    .content {
        padding: 0;
        margin: 0;
        border-radius: 0;
    }



    #top_heading_fix h3 {
        top: -57px;
        left: 6px;
    }



    #TB_overlay {
        z-index: 20000 !important;
    }



    #TB_window {
        z-index: 25000 !important;
    }



    .dialog_black {
        z-index: 30000 !important;
    }



    #boxscroll22 {
        max-height: 291px;
        overflow: auto;
        cursor: inherit !important;
    }



    .error_msg,
    em {
        color: rgb(255, 0, 0);
        font-size: 12px;
        font-weight: normal;
    }



    .ui-datepicker td.ui-datepicker-today a {



        background: #999999;



    }

    table.dataTable tr td:first-child {

        text-align: left !important;

    }



    .auto-asset-search ul#country-list li:hover {



        background: #c3c3c3;



        cursor: pointer;



    }



    .auto-asset-search ul#product-list li:hover {



        background: #c3c3c3;



        cursor: pointer;



    }



    .auto-asset-search ul#country-list li {



        background: #dadada;



        margin: 0;



        padding: 5px;



        border-bottom: 1px solid #f3f3f3;



    }



    .auto-asset-search ul#product-list li {



        background: #dadada;



        margin: 0;



        padding: 5px;



        border-bottom: 1px solid #f3f3f3;



        width: 200px;



    }



    .auto-asset-search ul#service-list li:hover {



        background: #c3c3c3;



        cursor: pointer;



    }



    .auto-asset-search ul#service-list li {



        background: #dadada;



        margin: 0;



        padding: 5px;



        border-bottom: 1px solid #f3f3f3;



        width: 200px;



    }



    ul li {



        list-style-type: none;



    }



    .btn-info {
        background-color: #3db9dc;
        border-color: #3db9dc;
        color: #fff;
    }



    .btn-info:hover {
        background-color: #25a7cb;
    }



    .round-off {
        border-radius: 0px;
    }



    td a.round-off.btn {
        border: none !important;
    }



    .round-off .r-plus {
        position: relative;
        top: 1px;
        left: 1px;
    }

    .invedit_left tbody tr td:last-child {
        text-align: left !important;
    }
</style>



<?php
$model_numbers_json = array();



if (!empty($products)) {



    foreach ($products as $list) {



        $model_numbers_json[] = '{ id: "' . $list['id'] . '", value: "' . $list['product_name'] . '"}';
    }
}



$model_numbers_extra = array();



if (!empty($products)) {



    foreach ($products as $list) {



        if (!empty($list['model_no'])) {



            $model_numbers_extra[] = '{ id: "' . $list['id'] . '", value: "' . $list['model_no'] . '"}';
        }
    }
}



$customers_json = array();



if (!empty($customers)) {



    foreach ($customers as $list) {



        $customers_json[] = '{ id: "' . $list['id'] . '", value: "' . $list['store_name'] . '"}';
    }
}
?>



<div class="mainpanel">







    <div id='empty_data'></div>



    <div class="contentpanel mb-25">



        <div class="media">



            <h4>Update Used Sales Invoice</h4>



        </div>
        <table class="static1" style="display: none;">



            <tr>



                <td colspan="4" style="width:70px; text-align:right;"></td>



                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" tabindex="-1" name="item_name[]" class="tax_label text_right" style="width:100%;"></td>



                <td>



                    <input type="text" name="amount[]" class="totaltaxs text_right" tabindex="-1" style="width:70px;">



                    <input type="hidden" name="type[]" class="text_right" value="invoice" style="width:70px;">



                </td>



                <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>



            </tr>



        </table>



        <table class="static" style="display: none;">



            <tr>



                <td class="action-btn-align s_no"></td>



                <td>



                    <input type="text" tabindex="8" name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' style="width:100%;font-weight: 600;" />



                    <span class="error_msg"></span>



                    <input type="hidden" name="product_id[]" id="product_id" class=' tabwid form-align product_id' />



                    <input type="hidden" name="product_type[]" id="type" class=' tabwid form-align type' />



                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>



                </td>

                <td>


                    <div class="ime_code_select">
                        <div tabindex="0">


                            <select id="ime_code_id" class="form-control multi_select ime_code_id " multiple="multiple" autocomplete="off" name="ime_code_id[]">

                                <option>Select</option>


                            </select>

                        </div>

                    </div>
                    <input type="hidden" name='ime_code_val[]' style="width:70px;" class="ime_code_val required" id="ime_code_vals" />
                    <span class="error_msg ime_code_error"></span>
                </td>

                <td style="display:none;">



                    <select id="cat_id" tabindex="-1" style="display:none;" class='cat_id static_style' name='categoty[]'>



                        <option value="">Select</option>



                        <?php
                        if (isset($category) && !empty($category)) {



                            foreach ($category as $val) {
                        ?>



                                <option value='<?php echo $val['cat_id'] ?>'><?php echo $val['categoryName'] ?></option>



                        <?php
                            }
                        }
                        ?>



                    </select>



                </td>







                <!--<td class="action-btn-align">



                    <input type="hidden"  class='form-align  tabwid model_no_extra'  style="width:100%"/>



                    <input type="text"  tabindex="-1"   name='unit[]' style="width:70px;" class="unit" />



                </td>-->

                <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="" />

                <td> <select name='brand[]' tabindex="-1" class='brand_id' style="display:none;">



                        <option>Select</option>



                        <?php
                        if (isset($brand) && !empty($brand)) {



                            foreach ($brand as $val) {
                        ?>



                                <option value='<?php echo $val['id'] ?>'><?php echo $val['brands'] ?></option>



                        <?php
                            }
                        }
                        ?>



                    </select>



                    <div class="avl_qty"></div>



                    <div class="col-xs-8">



                        <input type="text" tabindex="8" name='quantity[]' data-stock="0" readonly exist_qty="0" style="width:70px;" class="qty quantity" id="qty" /></div>

                    <input type="hidden" name='quantity_old[]' style="width:70px;" value="" />



                    <div class="col-xs-4"> <span class="label label-success stock_qty"> 0 </span></div>



                    <span class="error_msg"></span>



                </td>



                <td>



                    <input type="text" tabindex="8" name='per_cost[]' style="width:70px;" class="selling_price percost " id="price" />
                    <input type="hidden" name="sp_with_gst[]" class="sp_with_gst">
                    <input type="hidden" name="sp_without_gst[]" class="sp_without_gst" value="">



                    <span class="error_msg"></span>



                </td>



                <!--<td class="action-btn-align">



                <input type="text" tabindex="-1"  style="width:70px;" class="gross" />



            </td>-->



                <!--                <td>



                    <input type="text"  name='discount[]' style="width:70px;" class="discount" />



                </td>-->

                <td class="action-btn-align">

                    <input type="text" style="width:75px;" class="hsn_code" readonly="readonly" autocomplete="off" />

                </td>

                <td class="action-btn-align cgst_td">



                    <input type="text" tabindex="-1" name='tax[]' style="width:70px;" class="pertax" readonly="readonly" />



                </td>



                <td class="action-btn-align sgst_td">



                    <input type="text" tabindex="-1" name='gst[]' style="width:70px;" class="gst" readonly="readonly" />



                </td>



                <td class="action-btn-align igst_td">



                    <input type="text" tabindex="-1" name='igst[]' style="width:70px;" class="igst wid50" readonly="readonly" />



                </td>



                <td>



                    <input type="text" tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />



                </td>



                <td class="action-btn-align"><a id='delete_group' tabindex="-1" class="btn btn-danger delete_group"><span class="glyphicon glyphicon-trash"></span></a></td>



            </tr>



        </table>



        <?php
        if (isset($quotation) && !empty($quotation)) {



            foreach ($quotation as $val) {
        ?>



                <form action="<?php echo $this->config->item('base_url'); ?>sales/update_used_invoice" method="post" class=" panel-body">

                <input type="hidden" id="sale_cat_type" name="sale_cat_type" value="<?php echo $category[0]['cat_id'];?>" />

                    <input type="hidden" name="quotation[q_id]" value="<?php echo trim($val['q_id']); ?>" />



                    <input type="hidden" id="firm" name="quotation[firm_id]" value="<?php echo $val['firm_id']; ?>" />



                    <input type="hidden" name="quotation[ref_name]" value="<?php echo $val['ref_name']; ?>" />



                    <input type="hidden" name="quotation[inv_id]" value="<?php echo $val['inv_id']; ?>" />



                    <input type="hidden" name="cus_type" value="  <?php echo $val['customer_type']; ?>" />



                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline invedit_left">



                        <tr>



                            <td colspan="2"><span class="tdhead">TO,</span>



                                <div><b><?php echo $val['store_name']; ?></b></div>



                                <div><?php echo $val['address1']; ?> </div>



                                <div> <?php echo $val['mobil_number']; ?></div>



                                <div> <?php echo $val['email_id']; ?></div>



                            </td>



                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px"></td>



                            <td colspan="2"></td>



                        </tr>



                        <tr>



                            <td width="25%"><span class="tdhead">Invoice NO :</span> </td>



                            <td width="25%" class=""><span class="tdhead"> <?php echo $val['inv_id']; ?> </span></td>



                            <td width="25%"><span class="tdhead">Shop Name :</span></td>



                            <td width="25%"><?php echo $val['firm_name']; ?><input type="hidden" tabindex="-1" id="firm_id" value="<?php echo $val['firm_id']; ?>"></td>



                        </tr>



                        <?php if ($val['customer_type'] == 3 || $val['customer_type'] == 4) { ?>



                            <tr>



                                <td class="first_td1"><span class="tdhead">Customer:</span></td>



                                <td><span class="tdhead"> <?php echo $val['store_name']; ?> </span></td>



                                <td class="first_td1"> </td>



                                <td></td>



                            </tr>



                        <?php } ?>



                        <tr>



                            <td width="25%" class="first_td1"><span class="tdhead">Bill Type :</span></td>



                            <td width="25%"><input type="radio" tabindex="1" class="receiver" value="cash" name="quotation[bill_type]" <?php echo ($val['customer_type'] == '1' || $val['customer_type'] == '3') ? 'checked' : '' ?> />Cash Sale



                                <input type="radio" tabindex="1" class="receiver" value="credit" name="quotation[bill_type]" <?php echo ($val['customer_type'] == '2' || $val['customer_type'] == '4') ? 'checked' : '' ?> />Credit Sale<br>



                                <span id="type1" class="error_msg"></span>



                            </td>



                            <td width="25%" class="first_td1"><span class="tdhead">Reference NO :</span> </td>



                            <td width="25%"><?php echo $val['q_no']; ?></td>



                        </tr>



                        <tr>


                            <input type="hidden" tabindex="2" name="quotation[customer_po]" class="form-control required" style="width:200px; display: inline" id="customer_po" value="123" />



                            <td width="25%">



                                <span class="tdhead"> Date :</span>



                            </td>



                            <td width="25%"><input type="text" tabindex="5" class="form-control required datepicker" name="quotation[created_date]" style="width:200px; display: inline" value="<?php echo $val['created_date']; ?> " />



                                <span class="error_msg"></span>



                            </td>



                            <td width="25%" class="first_td"><span class="tdhead">GSTIN NO :</span></td>



                            <td width="25%">
                                <input type="text" name="customer[tin]" value=" <?php echo $val['tin']; ?>" id="tin">
                                <span id="gstin_err" class="error_msg"></span>
                            </td>



                        </tr>







                        <tr>

                            <input type="hidden" name="quotation[delivery_status]" id="delivery_status" value="delivered" />

                            <td>



                                <span class="tdhead"></span>



                            </td>



                            <td>



                            </td>

                            <td width="25%">



                                <span class="tdhead"> IMEI Detection :</span>



                            </td>



                            <td width="25%">


                                <div class="input-group" style="width:65%;">

                                    <input type="text" name="bar_code_detection" maxlength="15" class="bar_code_detection  form-align" id="bar_code_detection" autocomplete="off">

                                    <div class="input-group-addon" style="padding: 5px 12px;">

                                        <a href="javascript:" style="border: 0px solid #cbced4 !important;"> <i class="fa fa-barcode" onclick="ime_code_scan()"></i></a>

                                    </div>

                                </div>




                            </td>



                            <input type="hidden" name="customer[id]" id="customer_id" class='id_customer form-align tabwid' value="<?php echo $val['customer']; ?>" />



                            <input type="hidden" name="pc_id" id="pc_id" class='id_customer form-align tabwid' value="<?php echo $val['id']; ?>" />







                        </tr>





                    </table>



                    <table class="table  table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">

                        <thead>


                            <tr style="text-align:center;">


                                <td width="3%" class="first_td1">S.No</td>

                                <td width="20%" class="first_td1">Product Name</td>
                                <td width="15%" class="first_td1">IMEI Code</td>

                                <td width="10%" class="first_td1 action-btn-align">QTY</td>

                                <td width="8%" class="first_td1 action-btn-align">Unit Price</td>

                                <!-- <td width="4%" class="first_td1 action-btn-align">Total</td>-->

                                <td width="6%" class="first_td1 action-btn-align">HSN Code</td>

                                <td width="5%" class="first_td1 action-btn-align proimg-wid">CGST %</td>


                                <?php
                                $gst_type = $quotation[0]['state_id'];



                                //     if ($gst_type != '') {



                                if ($gst_type == 31) {
                                ?>



                                    <td width="5%" class="first_td1 action-btn-align proimg-wid">SGST%</td>



                                <?php } else { ?>



                                    <td width="5%" class="first_td1 action-btn-align proimg-wid">IGST%</td>







                                <?php
                                    //    }
                                }
                                ?>



                                <td width="7%" class="first_td1 action-btn-align">Net Value</td>



                                <td width="2%" class="action-btn-align">



                                    <a id='add_group' tabindex="7" class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span></a>



                                </td>



                            </tr>



                        </thead>







                        <tbody id='app_table'>



                            <?php
                            $cgst = 0;



                            $sgst = 0;



                            $i = 1;



                            if (isset($quotation_details) && !empty($quotation_details)) {







                                foreach ($quotation_details as $vals) {


                                    $cgst1 = ($vals['tax'] / 100) * ($vals['per_cost'] * $vals['quantity']);



                                    $gst_type = $quotation[0]['state_id'];



                                    if ($gst_type != '') {



                                        if ($gst_type == 31) {







                                            $sgst1 = ($vals['gst'] / 100) * ($vals['per_cost'] * $vals['quantity']);
                                        } else {



                                            $sgst1 = ($vals['igst'] / 100) * ($vals['per_cost'] * $vals['quantity']);
                                        }
                                    }



                                    $cgst += $cgst1;



                                    $sgst += $sgst1;



                                    if (isset($val['round_off']) && $val['round_off'] > 0) {



                                        if ($val['net_total'] > ($val['subtotal_qty'] + $val['transport'] + $val['labour'])) {



                                            $round_off_plus = $val['round_off'];



                                            $round_off_minus = 0;
                                        } else if ($val['net_total'] < ($val['subtotal_qty'] + $val['transport'] + $val['labour'])) {



                                            $round_off_minus = $val['round_off'];



                                            $round_off_plus = 0;
                                        } else {



                                            $round_off_plus = 0;



                                            $round_off_minus = 0;
                                        }
                                    }



                                    //                                    if ($val['advance'] != '') {
                                    //                                        $net_total = $val['net_total'] - $val['advance'];
                                    //                                    }
                            ?>



                                    <tr class="tr_<?php echo $vals['product_id']; ?>">



                                        <td class="action-btn-align s_no">



                                            <?php echo $i; ?>



                                        </td>



                                        <td>



                                            <input type="text" name="model_no[]" tabindex="6" id="model_no" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['product_name']; ?>" style="width:100%;font-weight: 600;" />



                                            <span class="error_msg error_msg_qty"></span>



                                            <input type="hidden" name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                            <input type="hidden" name="old_product_qty[]" value="<?php echo $vals['quantity']; ?>" />
                                            <input type="hidden" name="old_product_id[]" id="old_product_id" class='old_product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                            <input type="hidden" name="old_firm_id[]" id="old_firm_id" class='old_firm_id tabwid form-align' value="<?php echo $val['firm_id']; ?>" />
                                            <input type="hidden" name="old_cat_id[]" id="old_cat_id" class='old_cat_id tabwid form-align' value="<?php echo $vals['category']; ?>" />

                                            <input type="hidden" name="product_type[]" id="type" class=' tabwid form-align type' value="<?php echo $vals['type']; ?>" />



                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>



                                            <select id="brand_id" tabindex="-1" name='brand[]' class='brand_id' id="brand_id" style="display:none;">



                                                <option value='<?php echo $vals['id'] ?>'> <?php echo $vals['brands'] ?> </option>



                                                <?php
                                                if (isset($brand) && !empty($brand)) {



                                                    foreach ($brand as $valss) {
                                                ?>



                                                        <option value='<?php echo $valss['id'] ?>'> <?php echo $valss['brands'] ?></option>



                                                <?php
                                                    }
                                                }
                                                ?>



                                            </select>



                                        </td>


                                        <td>

                                            <div class="ime_code_select">
                                                <div tabindex="0">


                                                    <select id="ime_code_id" class="form-control multi_select ime_code_id " multiple="multiple" autocomplete="off" name="ime_code_id[]">

                                                        <option value="">Select</option>
                                                        <?php
                                                        if (isset($vals['ime_code_all_details']) && !empty($vals['ime_code_all_details'])) {
                                                            foreach ($vals['ime_code_all_details'] as $val_imie) {
                                                        ?>
                                                                <option value='<?php echo $val_imie['ime_code'] ?>' <?php
                                                                                                                    if (in_array($val_imie['ime_code'], $vals['ime_code_details'])) {
                                                                                                                        echo "selected";
                                                                                                                    }
                                                                                                                    ?>><?php echo $val_imie['ime_code'] ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>


                                                    </select>

                                                </div>

                                            </div>

                                            <input type="hidden" name='ime_code_val[]' style="width:70px;" class="ime_code_val required" value="<?php echo $vals['ime_code_details_hidden']; ?>" id="ime_code_vals" />


                                            <span class="error_msg ime_code_error"></span>
                                        </td>



                                        <td style="display:none;">



                                            <select id='cat_id' tabindex="-1" style="display:none;" class='static_style' name='categoty[]'>



                                                <option value='<?php echo $vals['cat_id'] ?>'><?php echo $vals['categoryName'] ?></option>







                                                <?php
                                                if (isset($category) && !empty($category)) {



                                                    foreach ($category as $va) {
                                                ?>



                                                        <option value='<?php echo $va['cat_id'] ?>'><?php echo $va['categoryName'] ?></option>



                                                <?php
                                                    }
                                                }
                                                ?>



                                            </select>







                                        </td>

                                        <input type="hidden" class='form-align tabwid model_no_extra' value="<?php echo $vals['model_no']; ?>" style="width:100%" />
                                        <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit']; ?>" />


                                        <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>



                                            <td>



                                                <input type="hidden" name='available_quantity[]' style="width:70px;" class="code form-control colournamedup tabwid form-align " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly" />




                                                <div class="col-xs-8"> <input readonly type="text" tabindex="6" name='quantity[]' style="width:70px;margin-top: 2px;" class="qty required quantity" exist_qty="<?php echo round($vals['quantity']); ?>" data-stock="<?php echo round($vals['quantity']); ?>" value="<?php echo round($vals['quantity']); ?>" /></div>


                                                <input type="hidden" name='quantity_old[]' style="width:70px;" value="<?php echo $vals['quantity'] ?>" />




                                                <div class="col-xs-4"> <span class="label label-success stock_qty"> <?php echo $vals['stock'][0]['quantity'] ?> </span></div>







                                                <span class="error_msg error_msg_qty"></span>



                                            </td>



                                        <?php } else { ?>



                                            <td>
                                                <div class="avl_qty"></div>



                                                <div class="col-xs-8">

                                                    <input type="text" tabindex="6" name='quantity[]' style="width:70px;" class="qty required quantity" exist_qty="<?php echo $vals['quantity'] ?>" value="<?php echo $vals['quantity'] ?>" />


                                                    <input type="hidden" name='quantity_old[]' style="width:70px;" value="<?php echo $vals['quantity'] ?>" />


                                                </div>



                                                <div class="col-xs-4"> <span class="label label-success stock_qty"> 0 </span></div>



                                                <span class="error_msg error_msg_qty"></span>



                                            </td>


                                        <?php } ?>



                                        <td>


                                            <input type="text" tabindex="6" name='per_cost[]' style="width:70px;" class="selling_price percost required" value="<?php echo $vals['per_cost'] ?>" />
                                            <input type="hidden" name="sp_with_gst[]" class="sp_with_gst" value="<?php echo $vals['sp_with_gst'] ?>">
                                            <input type="hidden" name="sp_without_gst[]" class="sp_without_gst" value="<?php echo $vals['sp_without_gst'] ?>">


                                            <span class="error_msg "></span>



                                        </td>


                                        <td class="action-btn-align">

                                            <input type="text" style="width:75px;" class="hsn_code" readonly="readonly" autocomplete="off" value="<?php echo $vals['hsn_sac']; ?>" />

                                        </td>
                                        <td>



                                            <input maxlength="8" type="text" tabindex="-1" name='tax[]' readonly="readonly" style="width:70px;" class="pertax" value="<?php echo number_format($vals['tax'], 2); ?>" />



                                        </td>



                                        <?php
                                        $gst_type = $quotation[0]['state_id'];



                                        if ($gst_type == 31) {
                                        ?>

                                            <td>


                                                <input maxlength="8" type="text" tabindex="-1" name='gst[]' readonly="readonly" style="width:70px;" class="gst" value="<?php echo number_format($vals['gst'], 2); ?>" />


                                            </td>


                                        <?php } else { ?>



                                            <td>



                                                <input type="text" name='igst[]' tabindex="-1" style="width:70px;" class="igst" readonly="readonly" value="<?php echo number_format($vals['igst'], 2); ?>" />



                                            </td>



                                        <?php
                                        }
                                        //   }
                                        ?>



                                        <td>



                                            <input type="text" tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>" />



                                        </td>



                                        <input type="hidden" value="<?php echo trim($val['q_id']); ?>" class="del_id" />



                                        <td width="2%" class="action-btn-align"><a id='delete_label' value="<?php echo $vals['del_id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>



                                    </tr>



                            <?php
                                    $i++;
                                }
                            }
                            ?>



                        </tbody>



                        <tbody>



                            <td colspan="3" style="width:70px; text-align:right !important;">Total</td>



                            <td><input type="text" tabindex="-1" name="quotation[total_qty]" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px; margin-left:10px;" id="total" /></td>



                            <td colspan="4" style="text-align:right;">Sub Total</td>



                            <td><input type="text" name="quotation[subtotal_qty]" tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>" class="final_sub_total text_right" style="width:70px;" /><input type="hidden" class="temp_sub_total" value="" /></td>







                            <td></td>





                            <input type="hidden" name="advance" tabindex="-1" readonly="readonly" value="<?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?>" class="advance text_right" style="width:70px;" />


                            <tr>

                                <td colspan="5" style="width:70px; text-align:right;"></td>

                                <td colspan="3" style="text-align:right;font-weight:bold;"><input type="text" tabindex="-1" name="quotation[tax_label]" class='tax_label text_right' value="<?php echo $val['tax_label']; ?>" style="width:100%;" /></td>

                                <td>

                                    <input type="text" name="quotation[tax]" value="<?php
                                                                                    if ($val['tax'] != 0) {
                                                                                        echo $val['tax'];
                                                                                    }
                                                                                    ?>" class='totaltax text_right' tabindex="-1" style="width:100px;" />

                                </td>

                                <td></td>

                            </tr>


                            <input type="hidden" name="quotation[round_off]" tabindex="-1" value="<?php echo $val['round_off']; ?>" class="round_off text_right" style="width:70px;" readonly />

                        </tbody>

                        <input type="hidden" name="quotation[transport]" value="0" class="transport text_right" tabindex="-1" style="width:70px;" />
                        <tbody class="additional">


                            <tr>

                                <input type="hidden" tabindex="-1" name="quotation[labour]" value="<?php echo $quotation[0]['labour']; ?>" class="labour text_right" style="width:70px;" />

                                <td colspan="2" style="text-align:right;">Taxable Charge</td>



                                <td><input type="text" tabindex="-1" name="quotation[taxable_price]" value="<?php echo $quotation[0]['taxable_price']; ?>" readonly="readonly" class=" text_right taxable_price" style="width:70px;" /></td>


                                <td colspan="1" style="text-align:right !important;">CGST:</td>



                                <td><input tabindex="-1" type="text" name="quotation[cgst_price]" value="<?php echo $val['cgst_price']; ?>" readonly class="add_cgst text_right cgst_price" style="width:70px;" /></td>



                                <?php
                                $gst_type = $quotation[0]['state_id'];


                                if ($gst_type == 31) {
                                ?>

                                    <td colspan="1" style="text-align:right;">SGST:</td>

                                <?php } else { ?>


                                    <td colspan="1" style="text-align:right;">IGST:</td>


                                <?php
                                }
                                ?>

                                <td><input type="text" tabindex="-1" value="<?php echo $val['sgst_price']; ?>" name="quotation[sgst_price]" readonly class="add_sgst sgst_price text_right" style="width:70px;" /></td>





                                <input type="hidden" name="quotation[transport]" value="<?php echo $quotation[0]['transport']; ?>" class="transport text_right" tabindex="-1" style="width:70px;" />








                                <td colspan="1" style="text-align:right;font-weight:bold;">Net Total</td>

                                <td><input type="text" tabindex="-1" name="quotation[net_total]" readonly="readonly" class="final_amt text_right" style="width:70px;" value="<?php echo $quotation[0]['net_total']; ?>" /></td>

                                <td></td>


                            </tr>

                            <tr>
                                <td colspan="11">
                                    <span>Remarks&nbsp;</span>
                                    <input name="quotation[remarks]" tabindex="-1" type="text" class="form-control" value="<?php echo $val['remarks']; ?>" style="width:100%; display: inline" />
                                </td>
                            </tr>



                        </tbody>









                    </table>



                    <input type="hidden" name="gst_type" id="gst_type" class="gst_type" value="<?php echo $quotation[0]['state_id']; ?>" />


                    <input type="hidden" name="quotation[credit_days]" id="credit_days" class='credit_days' value="<?php echo $val['credit_days']; ?>" />



                    <input type="hidden" name="quotation[credit_limit]" id="c_id" class='credit_limit' value="<?php echo $val['credit_limit']; ?>" />



                    <input type="hidden" name="quotation[temp_credit_limit]" id="temp_credit_limit" class='temp_credit_limit' value="<?php echo $val['temp_credit_limit']; ?>" />



                    <input type="hidden" name="quotation[approved_by]" id="approved_by" class='approved_by' value="<?php echo $val['approved_by']; ?>" />







                    <div class="action-btn-align">



                        <button class="btn btn-info " tabindex="9" id="save"> Update </button>



                        <a href="<?php echo $this->config->item('base_url') . 'sales/invoice_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>



                    </div>



                </form>



                <br />



        <?php
            }
        }
        ?>



    </div><!-- contentpanel -->



</div><!-- mainpanel -->







<script type="text/javascript">
    $('.multi_select').fSelect();

    var formHasChanged = false;



    var submitted = false;

    $('#tin').on('blur', function() {
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
        var gstin_val = $.trim($('#tin').val());
        if (gstinformat.test(gstin_val)) {

            $('#gstin_err').text('').css('display', 'inline-block');
            $('#gstin_err').text('');
        } else if (gstin_val == '') {
            $('#gstin_err').text('');
        } else {
            $('#gstin_err').text('Enter valid GSTIN').css('display', 'inline-block');
        }
    });


    $('#save').on('click', function() {



        m = 0;

        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
        var gstin_val = $.trim($('#tin').val());
        if (gstinformat.test(gstin_val)) {

            $('#gstin_err').text('').css('display', 'inline-block');
            $('#gstin_err').text('');
        } else if (gstin_val == '') {
            $('#gstin_err').text('');
        } else {
            $('#gstin_err').text('Enter valid GSTIN').css('display', 'inline-block');
            m++;
        }



        $('.required').each(function() {







            var tr = $('#app_table tr').length;



            if (tr > 1)



            {



                test = $(this).closest('tr td').find('input.model_no').val();



                if (test == '') {



                    $(this).closest('tr').remove();



                }



            }







        });



        $('.required').each(function() {

            this_val = $.trim($(this).val());

            this_id = $(this).attr("id");

            this_class = $(this).attr("class");


            if (this_val == "") {



                if (this_id == "ime_code_vals") {


                    this_class = $(this).closest('tr').attr('class');

                    if (this_class != undefined) {
                        $(this).closest('tr td').find('.error_msg').text('Please add IMEI code').css('display', 'inline-block');
                        $(this).closest('div .form-group').find('.error_msg').text('Please add IMEI code').css('display', 'inline-block');
                        m++;
                    } else {
                        $(this).closest('tr td').find('.error_msg').text('');
                        $(this).closest('div .form-group').find('.error_msg').text('');
                    }

                } else {

                    $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');

                    $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');

                    m++;
                }



            } else {

                $(this).closest('tr td').find('.error_msg').text('');

                $(this).closest('div .form-group').find('.error_msg').text('');

            }

        });



        if ($('.receiver:checked').length <= 0)



        {



            $("#type1").html("This field is required");



            m = 1;



        } else



        {



            $("#type1").html("");



        }




        $('.quantity').each(function(i) {



            var qty = $(this).closest('tr').find('.stock_qty').text();

            this_val = $.trim($(this).val());

            this_val_exists = $.trim($(this).attr('exist_qty'));



            if (Number(this_val_exists) < Number(this_val)) {
                var add_val = Number(this_val) - Number(this_val_exists);



                if (Number(add_val) > Number(qty)) {

                    $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');

                    m++;

                } else {
                    //alert('pass');

                    $(this).closest('td').find('.error_msg').text("");

                }
            }




        });


        if (m > 0) {



            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)



            }, 500);



            return false;



        } else {



            submitted = true;



        }



    });



    $(document).ready(function() {



        $('#approve').click(function() {



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
                    success: function(result) {



                        if (result == 'success') {



                            swal({
                                title: "Success!",
                                text: "Invoice Approved!",
                                type: "success"



                            }, function() {



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



        // var $elem = $('#scroll');



        //  window.csb = $elem.customScrollBar();



        $('#customer_po').focus();



        $("#customer_name").keyup(function() {



            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer",
                data: 'q=' + $(this).val(),
                success: function(data) {



                    $("#suggesstion-box").show();



                    $("#suggesstion-box").html(data);



                    $("#search-box").css("background", "#FFF");



                }



            });



        });



        $('body').click(function() {



            $("#suggesstion-box").hide();



        });



        val = $('#firm_id').val();



        if (val != '') {



            $.ajax({
                type: 'POST',
                data: {
                    firm_id: val
                },
                url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',
                success: function(data) {



                    var result = JSON.parse(data);



                    if (result != null && result.length > 0) {



                        option_text = '<option value="">Select Category</option>';



                        $.each(result, function(key, value) {



                            option_text += '<option value="' + value.cat_id + '">' + value.categoryName + '</option>';



                        });



                        $('.cat_id').html(option_text);



                        $('.model_no,.model_no_extra').removeAttr('readonly', 'readonly');







                    } else {



                        $('.cat_id,.model_no,.model_no_extra').val('');



                        $('.model_no,.model_no_extra').attr('readonly', 'readonly');



                    }



                }



            });



        } else {



            $('.cat_id,.model_no,.model_no_extra').val('');



            $('.model_no,.model_no_extra').attr('readonly', 'readonly');



        }











    });







    $('#add_group').bind('keypress click', function() {



        var tableBody = $(".static").find('tr').clone();

        //        var tab_index = $(".static").find('tr:last td  input.model_no').attr('tabindex');

        //        var inc_val = 1;

        //        var tab_inc = parseInt(tab_index) + parseInt(inc_val);





        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');



        $('#app_table').append(tableBody);

        //        $(".static").find('tr:last td  input.model_no').attr('tabindex', tab_inc);

        //        var tab_save = parseInt(tab_inc) + parseInt(1);

        //     $("#save").attr('tabindex', '');

        if ($('#gst_type').val() != '')



        {



            if ($('#gst_type').val() == 31)



            {



                $('#add_quotation').find('tr td.sgst_td').show();



                $('#add_quotation').find('tr td.igst_td').hide();







            } else {



                $('#add_quotation').find('tr td.igst_td').show();



                $('#add_quotation').find('tr td.sgst_td').hide();



            }



        } else {



            $('#add_quotation').find('tr td.igst_td').show();



            $('#add_quotation').find('tr td.sgst_td').hide();



        }







        var i = 1;



        $('#app_table tr').each(function() {



            $(this).closest("tr").find('.s_no').html(i);



            i++;



        });



    });



    $('#delete_label').on('click', function() {



        $(this).closest("tr").remove();



        calculate_function();



    });



    $('.del').on('click', function() {



        var del_id = $(this).closest('tr').find('.del_id').val();



        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "sales/delete_inv_by_id",
            data: {
                del_id: del_id

            },
            success: function(datas) {



                calculate_function();



            }



        });



    });



    $('#add_group_service').click(function() {



        var tableBody = $(".static_ser").find('tr').clone();



        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');



        $('#app_table').append(tableBody);



    });



    $('#add_label').click(function() {



        var tables = $(".static1").find('tr').clone();



        $('.add_cost').append(tables);



    });



    $(document).on('click','.delete_group',function() {



        $(this).closest("tr").remove();



        calculate_function();



        var i = 1;



        $('#app_table tr').each(function() {



            $(this).closest("tr").find('.s_no').html(i);



            i++;



            // $(this).text(i++);



        });



    });











    $('#delete_label').on('click', function() {



        $(this).closest("tr").remove();



        calculate_function();



    });



    $(".remove_comments").on('click', function() {



        $(this).closest("tr").remove();



        var full_total = 0;



        $('.total_qty').each(function() {



            full_total = full_total + Number($(this).val());



        });



        $('.full_total').val(full_total);



        console.log(full_total);



    });



    $('.qty,.percost,.pertax,.totaltax,.gst,.igst,.discount,.transport,.labour').on('keyup', function() {



        calculate_function();



    });



    $(".r-plus").on('click', function() {



        var round_off = $('.round_off').val();



        $('.temp_round_off_plus').val(round_off);



        $('.temp_round_off_minus').val(0);



        calculate_function();



    });



    $(".r-minus").on('click', function() {



        var round_off = $('.round_off').val();



        $('.temp_round_off_minus').val(round_off);



        $('.temp_round_off_plus').val(0);



        calculate_function();



    });



    function calculate_function() {


        var final_qty = 0;

        var final_sub_total = 0;

        var total_gst_price = 0.00;

        var total_cgst_price = 0.00;

        var total_sgst_price = 0.00;



        var transport = Number($('.transport').val());
        var labour = Number($('.labour').val());
        var advance = Number($('.advance').val());
        var cgst = 0;
        var sgst = 0;



        $('.qty').each(function() {

            var qty = $(this);

            var percost = $(this).closest('tr').find('.percost');

            var pertax = $(this).closest('tr').find('.pertax');

            var gst = $(this).closest('tr').find('.gst');

            var igst = $(this).closest('tr').find('.igst');

            var subtotal = $(this).closest('tr').find('.subtotal');


            if (Number(qty.val()) != 0) {


                tot = Number(qty.val()) * Number(percost.val());

                $(this).closest('tr').find('.gross').val(tot);

                subtotal.val(tot.toFixed(2));

                var total_cgst_per = Number(pertax.val());

                var total_sgst_per = Number(gst.val());

                var total_igst_per = Number(igst.val());



                if ($('#gst_type').val() == 31) {
                    var total_taxgst_per = total_cgst_per + total_sgst_per;
                    var cgst_price = (Number(tot) * Number(total_cgst_per / 100)).toFixed(2);
                    var sgst_price = (Number(tot) * Number(total_sgst_per / 100)).toFixed(2);

                } else {
                    $('.igst_sgst').text('IGST');
                    var cgst_price = (Number(tot) * Number(total_cgst_per / 100)).toFixed(2);
                    var total_taxgst_per = total_cgst_per + total_igst_per;
                    var sgst_price = (Number(tot) * Number(total_igst_per / 100)).toFixed(2);
                }




                var price_without_gst = $(this).closest('tr').find('.sp_without_gst');
                var price_with_gst = $(this).closest('tr').find('.sp_with_gst');

                var gst_price = (Number(cgst_price) + Number(sgst_price)).toFixed(2);

                var wo_gst_price = (Number(tot) - Number(gst_price)).toFixed(2);


                price_without_gst.val(wo_gst_price);

                price_with_gst.val(tot.toFixed(2));

                total_gst_price = (Number(total_gst_price) + Number(gst_price));

                total_cgst_price = (Number(total_cgst_price) + Number(cgst_price));
                total_sgst_price = (Number(total_sgst_price) + Number(sgst_price));

                final_sub_total = final_sub_total + tot;

                final_qty = final_qty + Number(qty.val());

            } else {
                subtotal.val('0.00');
            }



        });



        $('.total_qty').val(final_qty);



        var taxable_price = final_sub_total - Number(total_gst_price).toFixed(2);

        $('.taxable_price').val(taxable_price.toFixed(2));

        $('.cgst_price').val(total_cgst_price.toFixed(2));

        $('.sgst_price').val(total_sgst_price.toFixed(2));

        $('.final_sub_total').val(final_sub_total.toFixed(2));

        var totaltax = $('.totaltax').val();
        if (totaltax)
            final_sub_total = final_sub_total + parseInt(totaltax);

        $('.final_amt').val(final_sub_total.toFixed(2));



    }







    $('.cat_id,.brand_id,.pro_class').on('change', function() {



        $('.cat_id,.brand_id,.pro_class').on('click', function() {



            var cat_id = $(this).closest('tr').find('.cat_id').val();



            var brand_id = $(this).closest('tr').find('.brand_id').val();



            var model_no = $(this).closest('tr').find('.product_id').val();



            var this_ = $(this).closest('tr').find('.avl_qty');



            $.ajax({
                url: BASE_URL + "sales/get_stock",
                type: 'GET',
                data: {
                    cat_id: cat_id,
                    brand_id: brand_id,
                    model_no: model_no



                },
                success: function(result) {



                    this_.html(result);



                }



            });



        });



    });



    $(".datepicker").datepicker({
        setDate: new Date(),
        yearRange: "-10:+100",
        changeMonth: true,
        changeYear: true,
        onClose: function() {



            $("#app_table").find('tr:first td  input.model_no').focus();



        }



    });







    $('#search').on('click', function() {



        for_loading();



        $.ajax({
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                style: $('#style').val(),
                supplier: $('#supplier').val(),
                supplier_name: $('#supplier').find('option:selected').text(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()



            },
            success: function(result) {



                for_response();



                $('#result_div').html(result);



            }



        });



    });
</script>



<script>
    // $(document).ready(function () {







    $('body').on('keydown', '#add_quotation input.model_no', function(e) {



        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];



        var _this = $(this);



        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function(request, response) {



                var val = _this.closest('tr input.model_no').val();



                var product_data = [];



                cat_id = $('#firm_id').val();



                cust_id = $('#customer_id').val();

                if ($.trim(val).length != 0) {

                    $.ajax({
                        type: 'POST',
                        data: {
                            firm_id: cat_id,
                            pro: val,
                            category_id: $('#sale_cat_type').val()
                        },
                        async: false,
                        url: '<?php echo base_url(); ?>quotation/get_product_by_frim_id',
                        success: function(data) {



                            product_data = JSON.parse(data);







                        }



                    });

                }

                // filter array to only entries you want to display limited to 10



                var outputArray = new Array();



                for (var i = 0; i < product_data.length; i++) {



                    //     if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {



                    outputArray.push(product_data[i]);



                    //   }



                }

                if (outputArray.length == 0) {
                    var nodata = 'No Product Found';
                    outputArray.push(nodata);
                }

                response(outputArray.slice(0, 10));



            },
            //position: {collision: "flip"},



            minLength: 0,
            delay: 0,
            autoFocus: true,
            select: function(event, ui) {



                this_val = $(this);



                product = ui.item.value;



                $(this).val(product);



                model_number_id = ui.item.id;



                $.ajax({
                    type: 'POST',
                    data: {
                        model_number_id: model_number_id,
                        c_id: cust_id,
                        firm_id: $('#firm').val()
                    },
                    url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/" + cat_id,
                    success: function(data) {



                        var result = JSON.parse(data);

                        if (result != null && result.length > 0) {



                            var ime_result = result[0].ime_details;


                            var option_text = '';



                            if (ime_result != null && ime_result.length > 0) {


                                option_text += '<div  tabindex="0"><select id="ime_code_id" class="form-control multi_select ime_code_id" multiple="multiple" autocomplete="off" name="ime_code_id[]">';

                                option_text += '<option value="">Select</option>';


                                $.each(ime_result, function(key, value) {

                                    //console.log(value.ime_code);

                                    selected = '';
                                    if (key == 0)
                                        selected = 'selected';

                                    option_text += '<option  value="' + value.ime_code + '"  ' + selected + '>' + value.ime_code + '</option>';

                                });

                                option_text += '</select></div>';

                                this_val.closest('tr').find('td .ime_code_select').empty();

                                this_val.closest('tr').find('td .ime_code_select').append(option_text);


                                this_val.closest('tr').find('td .multi_select').fSelect();



                                var datas = this_val.closest('tr').find('td .ime_code_id').val();


                                this_val.closest('tr').find('td .ime_code_val').val(datas);


                            } else {

                                // $('#sales_man').html('');

                                this_val.closest('tr').find('.ime_code_id').html(option_text);

                            }



                            if (result[0].quantity != null) {



                                this_val.closest('tr').find('.stock_qty').html(result[0].quantity);

                                this_val.closest('tr').find('.qty').attr('data-stock', result[0].quantity);

                            } else {



                                this_val.closest('tr').find('.stock_qty').html('0');
                                this_val.closest('tr').find('.qty').attr('data-stock', 0);


                            }


                            this_val.closest('tr').find('.qty').val('1');

                            this_val.closest('tr').find('.hsn_code').val(result[0].hsn_sac);


                            this_val.closest('tr').find('.unit').val(result[0].unit);



                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);



                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);



                            //  this_val.closest('tr').find('.pertax').val(result[0].cgst);



                            // this_val.closest('tr').find('.gst').val(result[0].sgst);



                            // this_val.closest('tr').find('.discount').val(result[0].discount);



                            if (result[0].selling_price != '') {


                                this_val.closest('tr').find('.selling_price').val(result[0].sales_price);
                                this_val.closest('tr').find('.sp_with_gst').val(result[0].sales_price);
                                this_val.closest('tr').find('.sp_without_gst').val(result[0].sales_price_without_gst);



                            } else {



                                this_val.closest('tr').find('.selling_price').val('0');



                            }


                            this_val.closest('tr').addClass('tr_' + result[0]['id']);

                            this_val.closest('tr').find('.type').val(result[0].type);



                            this_val.closest('tr').find('.product_id').val(result[0].id);



                            this_val.closest('tr').find('.model_no').val(result[0].product_name);



                            this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);



                            this_val.closest('tr').find('.product_description').val(result[0].product_description);



                            if ($('#gst_type').val() != '')



                            {



                                if ($('#gst_type').val() == 31)



                                {



                                    this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                    this_val.closest('tr').find('.gst').val(result[0].sgst);



                                } else {



                                    this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                    this_val.closest('tr').find('.igst').val(result[0].igst);







                                }



                            } else {
                                this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                this_val.closest('tr').find('.igst').val(result[0].igst);
                            }



                            calculate_function();
                            this_val.closest('tr').find('.igst').val(result[0].igst);



                            var name = $('#app_table tr:last').find('.model_no').val();



                            if (name != '') {



                                $('#add_group').trigger('click');

                                this_val.closest('tr').find('.qty').focus();

                                //                                var tab_model = this_val.closest('tr').find('.model_no').attr('tabindex');

                                //                                this_val.closest('tr').find('.qty').attr('tabindex', '');

                                //                                this_val.closest('tr').find('.percost').attr('tabindex', '');

                                //                                var tab_save = parseInt(tab_model) + parseInt(1);

                                //  $("#save").attr('tabindex', '');



                            }



                        }

                    }



                });



            }



        });



    });











    $(document).ready(function() {



        $('body').on('keydown', 'input.model_no_extra', function(e) {



            //var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];



            var product_data = [];



            cat_id = $('#firm_id').val();



            cust_id = $('#customer_id').val();



            $.ajax({
                type: 'POST',
                data: {
                    firm_id: cat_id
                },
                async: false,
                url: '<?php echo base_url(); ?>quotation/get_model_no_by_frim_id',
                success: function(data) {



                    product_data = JSON.parse(data);



                }



            });



            $(".model_no_extra").autocomplete({
                source: function(request, response) {



                    // filter array to only entries you want to display limited to 10



                    var outputArray = new Array();



                    for (var i = 0; i < product_data.length; i++) {



                        if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {



                            outputArray.push(product_data[i]);



                        }



                    }


                    if (outputArray.length == 0) {
                        var nodata = 'No Product Found';
                        outputArray.push(nodata);
                    }
                    response(outputArray.slice(0, 10));



                },
                minLength: 0,
                delay: 0,
                autoFill: false,
                select: function(event, ui) {



                    this_val = $(this);



                    product = ui.item.value;



                    $(this).val(product);



                    model_number_id = ui.item.id;



                    $.ajax({
                        type: 'POST',
                        data: {
                            model_number_id: model_number_id,
                            c_id: cust_id
                        },
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/" + cat_id,
                        success: function(data) {







                            var result = JSON.parse(data);



                            if (result != null && result.length > 0) {



                                if (result[0].quantity != null) {



                                    this_val.closest('tr').find('.stock_qty').html(result[0].quantity);



                                } else {



                                    this_val.closest('tr').find('.stock_qty').html('0');



                                }



                                this_val.closest('tr').find('.unit').val(result[0].unit);



                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);



                                //this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                //this_val.closest('tr').find('.gst').val(result[0].sgst);



                                //this_val.closest('tr').find('.discount').val(result[0].discount);



                                if (result[0].selling_price != '') {



                                    this_val.closest('tr').find('.selling_price').val(result[0].sales_price);
                                    this_val.closest('tr').find('.sp_with_gst').val(result[0].sales_price);
                                    this_val.closest('tr').find('.sp_without_gst').val(result[0].sales_price_without_gst);



                                } else {



                                    this_val.closest('tr').find('.selling_price').val('0');



                                }



                                this_val.closest('tr').find('.type').val(result[0].type);



                                this_val.closest('tr').find('.product_id').val(result[0].id);



                                this_val.closest('tr').find('.model_no').val(result[0].product_name);



                                this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);



                                this_val.closest('tr').find('.product_description').val(result[0].product_description);



                                if ($('#gst_type').val() != '')



                                {



                                    if ($('#gst_type').val() == 31)



                                    {



                                        this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                        this_val.closest('tr').find('.gst').val(result[0].sgst);



                                    } else {



                                        this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                        this_val.closest('tr').find('.igst').val(result[0].igst);







                                    }



                                } else {
                                    this_val.closest('tr').find('.pertax').val(result[0].cgst);



                                    this_val.closest('tr').find('.igst').val(result[0].igst);

                                }



                                calculate_function();



                                var name = $('#app_table tr:last').find('.model_no').val();



                                if (name != '')
                                    $('#add_group').trigger('click');



                            }



                        }



                    });



                }



            });



        });



    });







    $(document).ready(function() {



        $('body').click(function() {



            $(this).closest('tr').find(".suggesstion-box1").hide();



        });



    });



    $('.pro_class').on('click', function() {



        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));



        $(this).closest('tr').find('.pertax').val($(this).attr('pro_cgst'));



        $(this).closest('tr').find('.gst').val($(this).attr('pro_sgst'));



        // $(this).closest('tr').find('.discount').val($(this).attr('pro_discount'));



        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));



        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));



        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));



        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));



        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));



        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));



        $(this).closest('tr').find(".suggesstion-box1").hide();



        calculate_function();



    });



    $('.ser_class').on('click', function() {



        $(this).closest('tr').find('.cat_id').val($(this).attr('ser_cat'));



        $(this).closest('tr').find('.pertax').val($(this).attr('ser_cgst'));



        $(this).closest('tr').find('.gst').val($(this).attr('ser_sgst'));



        // $(this).closest('tr').find('.discount').val($(this).attr('pro_discount'));



        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));



        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));



        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));



        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_name'));



        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "  " + $(this).attr('ser_description'));



        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));



        $(this).closest('tr').find(".suggesstion-box1").hide();



        calculate_function();



    });






    /*
     $('.ime_code_id').on('change', function () {

     var ime_id_val=$(this).val();

     $(this).closest('tr').find('td .ime_code_val').val(ime_id_val);

     $(this).closest('tr').find('td .qty').val(ime_id_val.length);

     calculate_function();
     });*/

    $('.ime_code_id').on('change', function() {

        var ime_id_val = $(this).val();



        if (!ime_id_val)
            var ime_id_val_length = 0;
        else
            var ime_id_val_length = ime_id_val.length;

        $(this).closest('tr').find('td .ime_code_val').val(ime_id_val);

        $(this).closest('tr').find('td .qty').val(ime_id_val_length);

        calculate_function();
    });


    $('.qty').on('keyup', function() {


        class_name = $(this).closest('tr').attr('class');



        var pro_qty = $(this).val();
        var stock_qty = $(this).attr('data-stock');


        if (Number(pro_qty) > Number(stock_qty)) {

            $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');



        } else {

            var product_id = $(this).closest('tr').find('td .product_id').val();
            // alert(product_id);
            // alert(pro_qty);
            set_ime_code_from_pro_id(product_id, pro_qty, class_name);

            $(this).closest('td').find('.error_msg').text("");
        }


    });

    function set_ime_code_from_pro_id(product_id, pro_qty, class_name) {

        var ime_val = $('.' + class_name + '').find('td .ime_code_val').val();

        var hidden_push_val = 1;
        if (ime_val != "") {
            hidden_ime = ime_val.split(",");
            var hidden_qty = hidden_ime.length;

            if (hidden_qty < pro_qty) {
                var ime_qty = pro_qty - hidden_qty;


            } else if (hidden_qty > pro_qty) {
                var ime_code = [];

                hidden_ime = ime_val.split(",");
                var hidden_qty = hidden_ime.length;
                var check_qty = hidden_qty - 1;

                $.each(hidden_ime, function(key, value) {
                    if (key < check_qty)
                        ime_code.push(value);
                });

                $('.' + class_name + '').find('td .ime_code_val').val(ime_code);
                var hidden_push_val = 0;
            }
        } else {

            ime_qty = pro_qty;
        }

        if (hidden_push_val != 0) {
            $.ajax({
                type: 'POST',
                data: {
                    product_id: product_id,
                    pro_qty: ime_qty,
                    ime_code: ime_val
                },
                async: false,
                url: '<?php echo base_url(); ?>sales/get_ime_code_from_productqty',
                success: function(data) {
                    var data = JSON.parse(data);

                    if (data.length > 0) {

                        var ime_code = [];

                        var ime_val = $('.' + class_name + '').find('td .ime_code_val').val();

                        if (ime_val == '') {
                            $.each(data, function(key, value) {
                                ime_code.push(value.ime_code);
                            });

                            $('.' + class_name + '').find('td .ime_code_val').val(ime_code);
                        } else {
                            var ime_code = [];

                            hidden_ime = ime_val.split(",");
                            $.each(hidden_ime, function(key, value) {
                                ime_code.push(value);
                            });
                            $.each(data, function(key, value) {
                                ime_code.push(value.ime_code);
                            });

                            $('.' + class_name + '').find('td .ime_code_val').val(ime_code);
                        }




                    } else {
                        sweetAlert("Error...", "This Product is not available!", "error");

                        return false;
                    }


                }
            });

        }

    }

    function ime_code_scan() {


        bar_code = $('#bar_code_detection').val();
        cust_id = $('#customer_id').val();
        barcode = bar_code;




        if (cust_id == "") {
            toastr.clear();
            toastr.error("Customer field is required", 'Warning Message.!');
            return false;
        } else if (bar_code == "") {
            toastr.clear();
            toastr.error("IMEI code field is required", 'Warning Message.!');
            return false;
        } else if ((!($.isNumeric(bar_code))) && bar_code.length < 15) {
            toastr.clear();
            toastr.error("Invalid IMEI Code", 'Warning Message.!');
            return false;
        } else if (barcode != '' && cust_id != '') {

            var ime = 0;
            $('#app_table .ime_code_id').each(function() {

                hidden_ime = $(this).val();

                if (hidden_ime != "null") {
                    if (jQuery.inArray(barcode, hidden_ime) != '-1') {
                        toastr.clear();
                        toastr.error("IMEI Code Alreday Added", 'Warning Message.!');
                        ime++;
                        $(this).closest("td").find('.ime_code_error').text("IMEI Cdoe Alreday Added");

                    } else {
                        $(this).closest("td").find('.ime_code_error').text(" ");
                    }
                }


            });

            if (ime > 0) {
                return false;
            } else {

                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {
                        barcode: barcode,
                        cust_id: cust_id,
                        category_id: $('#sale_cat_type').val()
                    },
                    url: '<?php echo base_url(); ?>sales/get_all_products/',
                    success: function(data) {

                        result = JSON.parse(data);

                        if (result != null && result.length > 0) {

                            $.each(result, function(key, value) {

                                var prod_array = new Array();

                                $(".product_id").each(function() {

                                    prod_array.push($(this).val());

                                });

                                //var disabled = ''

                                $('#app_table tr').each(function() {

                                    val = $(this).closest("tr").find('.product_id').val();
                                    if (val == '')
                                        $(this).closest("tr").remove();

                                });



                                if (jQuery.inArray(value.id, prod_array) > -1 && prod_array.length > 0) {

                                    qty_val = $('#app_table .tr_' + value.id).find('.qty').val();

                                    var add = Number(qty_val) + Number(1);

                                    var select2 = 0;

                                    $('#app_table .tr_' + value.id).find(".fs-dropdown .fs-option").each(function() {

                                        imie_val = $(this).attr('data-value');

                                        if (imie_val == barcode) {
                                            $(this).trigger('click');
                                            //$(this).addClass('selected');

                                            //  $('#app_table .tr_' + value.id).find(".fs-label").text(barcode);
                                            select2++;


                                        }

                                    });

                                    if (select2 > 0) {
                                        $('#app_table .tr_' + value.id).find('.qty').val(add);
                                        calculate_function();
                                    } else {
                                        sweetAlert("Error...", "This Product is not available!", "error");

                                        return false;
                                    }

                                    /*  var data= $('#app_table .tr_' + value.id).find(".ime_code_id option[value='"+barcode+"']").attr("selected", "selected");
                                     alert(data);
                                     $('#app_table .tr_' + value.id).find('.qty').val(add);

                                     //$(""+multi_select+" option[value='" + barcode + "']").prop("selected", true);
                                     calculate_function();


                                     var ime_val=$('#app_table .tr_' + value.id).find('td .ime_code_val').val();
                                     product_id = $('#app_table .tr_' + value.id).find('.product_id').val();
                                     class_name='tr_' + value.id;
                                     if(ime_val!=""){
                                     ime_val=ime_val.split(",");

                                     if (jQuery.inArray(barcode, ime_val)!='-1') {
                                     toastr.clear();
                                     toastr.error("IME Cdoe Alreday Exists",'Warning Message.!');
                                     return false;
                                     }else{
                                     set_ime_code_from_pro_id(product_id,add,class_name);

                                     $('#app_table .tr_' + value.id).find('.qty').val(add);
                                     calculate_function();
                                     }
                                     }else{
                                     set_ime_code_from_pro_id(product_id,add,class_name);

                                     $('#app_table .tr_' + value.id).find('.qty').val(add);
                                     calculate_function();
                                     }*/


                                } else {

                                    $('#firm').val(result[0]['firm_id']);

                                    var tableBody = $(".static").find('tr').clone();

                                    $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');

                                    $('#app_table').append(tableBody);


                                    s = 1;
                                    $('#app_table tr').each(function() {

                                        $(this).closest("tr").find('.s_no').html(s);
                                        s++;

                                    });


                                    $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);

                                    if (result[0]['product_image'] == '')
                                        $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0]['product_image']);
                                    else
                                        $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");

                                    $(tableBody).closest('tr').find('.product_description').val(result[0]['product_description']);

                                    var ime_result = result[0]['ime_details'];
                                    var option_text = '';
                                    if (ime_result != null && ime_result.length > 0) {


                                        option_text += '<div  tabindex="0"><select id="ime_code_id" class="form-control multi_select ime_code_id" multiple="multiple" autocomplete="off" name="ime_code_id">';

                                        option_text += '<option value="">Select</option>';


                                        $.each(ime_result, function(key, value) {

                                            //console.log(value.ime_code);

                                            selected = '';
                                            if (value.ime_code == barcode)
                                                selected = 'selected';

                                            option_text += '<option  value="' + value.ime_code + '"  ' + selected + '>' + value.ime_code + '</option>';

                                        });

                                        option_text += '</select></div>';

                                        $(tableBody).closest('tr').find('td .ime_code_select').empty();



                                        $(tableBody).closest('tr').find('td .ime_code_select').append(option_text);


                                        $(tableBody).closest('tr').find('td .multi_select').fSelect();



                                        var datas = $(tableBody).closest('tr').find('td .ime_code_id').val();

                                        $(tableBody).closest('tr').find('td .ime_code_val').val(datas);



                                    } else {

                                        // $('#sales_man').html('');

                                        this_val.closest('tr').find('.ime_code_id').html(option_text);

                                    }

                                    $(tableBody).closest('tr').find('.qty').val('1');

                                    $(tableBody).closest('tr').addClass('tr_' + result[0]['id']);

                                    $(tableBody).closest('tr').find('.product_id').val(result[0]['id']);

                                    $(tableBody).closest('tr').find('.selling_price').val(result[0]['sales_price']);
                                    $(tableBody).closest('tr').find('.sp_with_gst').val(result[0]['sales_price']);
                                    $(tableBody).closest('tr').find('.sp_without_gst').val(result[0]['sales_price_without_gst']);

                                    $(tableBody).closest('tr').find('.qty').attr('data-stock', result[0]['qty']);
                                    $(tableBody).closest('tr').find('td .hsn_code').val(result[0]['hsn_sac']);

                                    $(tableBody).closest('tr').find('.stock_qty').text(result[0]['qty']);

                                    $(tableBody).closest('tr').find('.type').val(result[0]['type']);

                                    $(tableBody).closest('tr').find('.brand_id').val(result[0]['brand_id']);

                                    $(tableBody).closest('tr').find('.unit').val(result[0]['unit']);

                                    $(tableBody).closest('tr').find('.cat_id').val(result[0]['category_id']);

                                    $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);

                                    $(tableBody).closest('tr').find('.model_no_extra').val(result[0]['model_no']);
                                    $(tableBody).closest('tr').find('.igst_td').hide();
                                    //$('#add_quotation').find('tr td.igst_td').hide();
                                    //  class_name=$(tableBody).closest('tr').attr('class');
                                    //  product_id=$(tableBody).closest('tr').find('.product_id').val();
                                    // var ime_code=[];
                                    // ime_code.push(barcode);

                                    // product_id=$(tableBody).closest('tr').find('.ime_code_val').val(ime_code);

                                    //  set_ime_code_from_pro_id(product_id,1,class_name);

                                    if ($('#gst_type').val() != '')

                                    {

                                        if ($('#gst_type').val() == 31)

                                        {

                                            $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);

                                            $(tableBody).closest('tr').find('.gst').val(result[0]['sgst']);

                                            $(tableBody).closest('tr').find('.igst').hide();

                                        } else {

                                            $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);

                                            $(tableBody).closest('tr').find('.igst').val(result[0]['igst']);

                                            $(tableBody).closest('tr').find('.gst').hide();

                                        }

                                    } else {
                                        $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);

                                        $(tableBody).closest('tr').find('.igst').val(result[0]['igst']);

                                        $(tableBody).closest('tr').find('.gst').hide();
                                    }

                                    calculate_function();

                                    // Firm(result[0]['firm_id'], result[0]['category_id']);

                                }



                            });

                        } else {

                            sweetAlert("Error...", "This Product is not available!", "error");

                            return false;

                        }



                    }

                });


            }

        } else {

            sweetAlert("Error...", "This Product is not available!", "error");

            return false;

        }
    }




    $(document).ready(function() {







        calculate_function();



    });



    $(window).bind('scannerDetectionReceive', function(event, data) {



        target_ele = event.target.activeElement;



    });
</script>

<style type="text/css">
    .error_msg_qty {


        color: red;
    }
</style>

<script>
    (function($) {







        $.fn.bootstrapSwitch = function(options) {







            var settings = $.extend({
                on: 'On',
                off: 'Off	',
                onLabel: '&nbsp;&nbsp;&nbsp;',
                offLabel: '&nbsp;&nbsp;&nbsp;',
                same: false, //same labels for on/off states



                size: 'md',
                onClass: 'primary',
                offClass: 'default'



            }, options);







            settings.size = ' btn-' + settings.size;



            if (settings.same) {



                settings.onLabel = settings.on;



                settings.offLabel = settings.off;



            }







            return this.each(function(e) {



                var c = $(this);



                var disabled = c.is(":disabled") ? " disabled" : "";







                var div = $('<div class="btn-group btn-toggle" style="white-space: nowrap;"></div>').insertAfter(this);



                var on = $('<button class="btn btn-primary ' + settings.size + disabled + '" style="float: none;display: inline-block;"></button>').html(settings.on).css('margin-right', '0px').appendTo(div);



                var off = $('<button class="btn btn-danger ' + settings.size + disabled + '" style="float: none;display: inline-block;"></button>').html(settings.off).css('margin-left', '0px').appendTo(div);







                function applyChange(b) {



                    if (b) {



                        on.attr('class', 'btn active btn-' + settings.onClass + settings.size + disabled).html(settings.on).blur();



                        off.attr('class', 'btn btn-default ' + settings.size + disabled).html(settings.offLabel).blur();



                    } else {



                        on.attr('class', 'btn btn-default ' + settings.size + disabled).html(settings.onLabel).blur();



                        off.attr('class', 'btn active btn-' + settings.offClass + settings.size + disabled).text(settings.off).blur();



                    }



                }



                applyChange(c.is(':checked'));







                on.click(function(e) {



                    e.preventDefault();



                    c.prop("checked", !c.prop("checked")).trigger('change')



                });



                off.click(function(e) {



                    e.preventDefault();



                    c.prop("checked", !c.prop("checked")).trigger('change')



                });







                $(this).hide().on('change', function() {



                    applyChange(c.is(':checked'))



                });



            });



        };



    }(jQuery));
</script>



<script>
    $("[name='checkbox1'],[name='checkbox2'], [name='checkbox10']").bootstrapSwitch();



    $('input').on('keypress', function() {



        formHasChanged = true;



    });



    $('select').on('click', function() {



        formHasChanged = true;



    });



















    $(window).bind('beforeunload', function() {



        if (formHasChanged && !submitted) {



            return 'Are you sure you want to leave?';



        }







    });











    function isNumber(evt, this_ele) {



        this_val = $(this_ele).val();



        evt = (evt) ? evt : window.event;



        var charCode = (evt.which) ? evt.which : evt.keyCode;



        if (evt.which == 13) { //Enter key pressed



            $(".thVal").blur();



            return false;



        }



        if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {



            return false;



        } else {



            return true;



        }







    }







    $('.pertax, .gst').on('keypress', function(event) {



        this_val = $(this).val();



        if ((event.which == 46 && this_val.indexOf('.') >= 0) || (event.which <= 45 || event.which == 47 || event.which >= 58)) {



            event.preventDefault();



        }



    });







    $('.pertax, .gst').on('keyup input', function(event) {



        this_val = $(this).val();



        toText = this_val.toString(); //convert to string



        firstDigit = toText.charAt(0);



        lastDigit = toText.charAt(toText.length - 1);



        if (firstDigit == '.' && toText.length == 1) {



            this_val = '0.';



        }



        if (firstDigit == '.' && toText.length > 1) {



            this_val = '0' + this_val;



        }



        $(this).val(this_val);



        if (lastDigit == '.' && toText.length > 1) {



            this_val = this_val + '0';



        }





        if (!this_val.match(/^[+-]?((\.\d+)|(\d+(\.\d+)?))$/)) {



            $(this).val('');



        }



    });

    $(document).keydown(function(e) {

        var keycode = e.keyCode;

        if (keycode == 113) {

            $('#add_group').trigger('click');

        }

    });
</script>