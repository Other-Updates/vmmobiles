<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!--<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery.scannerdetection.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
<style type="text/css">
    .text_right {

        text-align: right;

    }

    .modalcontent-top {
        margin: 105px 0 auto 0 !important;
    }

    .bootstrap-tagsinput {

        height: 72px;
        overflow-y: auto;
    }

    .modal-footer {
        border-top: 0px !important;
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

    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }

    .auto-asset-search ul#product-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }

    .ime_modal {
        margin-top: 40px;
        font-size: 9px;
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
    }

    ul li {
        list-style-type: none;
    }

    #suggesstion-box {
        z-index: 99;
    }

    .modal_scroll {
        height: 213px;
        overflow-y: auto;
    }

    .modal-dialog {
        width: 480px !important;
        margin: 30px auto;
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
            <h4>Update Purchase Request</h4>
        </div>
        <table class="static" style="display: none;">

            <tr>



            
                <td class="action-btn-align s_no"></td>

                <td>
                <input type="hidden" id="catname" class="catname" name ="catname" value=""/>
                    <select id='cat_id' tabindex="-1" class='form-align cat_id static_style class_req form-control' style="width:100%" name='categoty[]'>

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

                    <span class="error_msg"></span>

                    <input type="hidden" style="width:100%" class='form-align form-control tabwid model_no_extra ' readonly="readonly" />

                </td>

                <td style="display:none">



                </td>

                <td>

                    <input type="text" name="model_no[]" style="width:100%" id="model_no" class='form-align auto_customer tabwid model_no form-control' />

                    <span class="error_msg"></span>

                    <input type="hidden" name="product_id[]" id="product_id" class=' tabwid form-align product_id' />

                    <input type="hidden" name="old_product_id[]" id="old_product_id" class='old_product_id tabwid form-align' value="" />
                    <input type="hidden" name="old_firm_id[]" id="old_firm_id" class='old_firm_id tabwid form-align' value="" />

                    <input type="hidden" name="product_name" id="product_name" class='product_name tabwid form-align' />



                    <input type="hidden" name="type[]" id="type" class=' tabwid form-align type' />

                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>

                </td>

                <div id="add_modal">




                </div>

                <td>

                    <select tabindex="-1" name='brand[]' class="form-align form-control brand_id">

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

                    <span class="error_msg"></span>

                </td>
                <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="" />
                <!-- <td class="action-btn-align">

                <input type="text"  tabindex="-1"   name='unit[]' style="width:70px;" class="unit" />

                <span class="error_msg"></span>

            </td>-->

                <!-- <td>

                 <!--   <input type="text" tabindex="-1" name='available_quantity[]' style="width:70px;" class="form-control  stock_qty" value="0" readonly="readonly"/>-->

                <!--   <input type="text"  tabindex="-1"   name='quantity[]' style="width:70px;" class="qty form-control" id="qty"/>
                    <div class="col-md-9">
                            <input type="text" tabindex="-1"  name='available_quantity[]' style="width:60px;" class="form-control  stock_qty" value="0" readonly="readonly"/>

                            <input type="text"  tabindex=""   name='quantity[]' style="width:60px;" class="qty required form-control" />
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-info btn-xs ime_modal">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                    </div>


                    <span class="error_msg"></span>

                </td>-->
                <td class="ime_modal ime_code_error">
                    <div class="col-md-5">
                        <input type="text" tabindex="-1" name='available_quantity[]' style="width:50px;" class="form-control  stock_qty" value="0" readonly="readonly" />
                    </div>
                    <div class="col-md-5">
                        <input type="text" tabindex="" name='quantity[]' style="width:50px;" class="qty required  form-control" value="0" />
                    </div>
                    <input type="hidden" name="old_product_qty[]" value="0" />
                    <input type="hidden" name="po_details_id[]" value="0" />
                    <div class="col-md-2">
                        <a class="btn btn-info btn-xs ime_modal_add" style="margin-top:6px; margin-left:-5px;border-radius:0px;" title="Add IMEI Code">
                            <span class="fa fa-barcode"></span>
                        </a>

                        <input type="hidden" name="ime_code_value[]" id="ime_code_value" class='ime_code_value required tabwid form-align' value="" />
                    </div>

                    <span class="error_msg"></span>

                </td>

                <td style="text-align: center;">

                    <input type="text" tabindex="-1" name='per_cost[]' style="width:70px;" class="cost_price percost " id="price" />
                    <input type="hidden" name="price_with_gst[]" class="price_with_gst">
                    <input type="hidden" name="price_without_gst[]" class="price_without_gst">
                    <span class="error_msg"></span>

                </td>

                <td style="text-align: center;">

                     <input type="text" tabindex="-1" name='sale_cost[]' style="width:70px;" class="sales_price salecost " id="price" />
                </td>	

                <!-- <td class="action-btn-align">

                <input type="text"  tabindex="-1"   style="width:70px;" class="gross"  />

            </td>
            -->
                <td class="action-btn-align">

                    <input type="text" style="width:75px;" class="hsn_code" readonly="readonly" autocomplete="off" />

                </td>
                <input type="hidden" tabindex="-1" name='discount[]' style="width:70px;" class="discount" />
                <!-- <td>

                                <input type="text"    tabindex="-1"  name='discount[]' style="width:70px;" class="discount" />

                            </td>-->


                <td class="action-btn-align cgst_td">

                    <input type="text" tabindex="-1" name='tax[]' style="width:70px;" class="pertax" readonly="readonly" />

                </td>
                <?php if ($po[0]['state_id'] == 31) { ?>
                    <td class="action-btn-align sgst_td">

                        <input type="text" tabindex="-1" name='gst[]' style="width:70px;" class="gst" readonly="readonly" />

                    </td>
                <?php } else { ?>

                    <td class="action-btn-align igst_td">

                        <input type="text" tabindex="-1" name='igst[]' style="width:70px;" class="igst wid50" readonly="readonly" />

                    </td>

                <?php } ?>




                <input type="hidden" tabindex="-1" name='transport[]' style="width:70px;" class="transport" value="" />
                <!-- <td>

                <input type="text"   tabindex="-1"   name='transport[]' style="width:70px;" class="transport" />

            </td>-->

                <td>

                    <input type="text" tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />

                </td>


                <input type="hidden" value="" class=" ime_code" name="ime_code[]" id="" />




                <td class="action-btn-align">



                <a id='delete_group' class="btn btn-danger delete_group"><span class="glyphicon glyphicon-trash"></span></a>

                </td>

            </tr>

        </table>

        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
        ?>
                <form method="post" class="panel-body" id="po_edit_form">
                
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Shop Name</label>
                                <div class="col-sm-8">
                                    <select name="po[firm_id]" class="form-control form-align" id="firm" readonly="readonly" disabled>
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($firms) && !empty($firms)) {
                                            foreach ($firms as $firm) {
                                                $select = ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '';
                                        ?>
                                                <option value="<?php echo $firm['firm_id']; ?>" <?php echo $select; ?>> <?php echo $firm['firm_name']; ?> </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">PO NO <span style="color:#F00; font-style:oblique;">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" tabindex="-1" name="po[pr_no]" class=" form-control colournamedup form-align " value="<?php echo $val['pr_no']; ?>" id="pr_no">
                                    <input type="hidden" name="po[po_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $val['po_no']; ?>" id="po_id">
                                    <input type="hidden" name="pr_id" class=" form-control " readonly="readonly" value="<?php echo $val['id']; ?>" id="erp_po_id">
                                    <span id="pr_id_err" class="error_msg"></span>
                                    <span id="duplica_err" class="val" style="color:#F00; font-style:oblique;"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Supplier Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="supplier[store_name]" id="customer_name" class='  form-control auto_customer form-align' value="<?php echo $val['store_name']; ?>" readonly="readonly" />

                                    <input type="hidden" name="supplier[id]" id="customer_id" class='form-control  id_customer form-align tabwid' value="<?php echo $val['vendor']; ?>" />
                                    <div id="suggesstion-box" class="auto-asset-search"></div>
                                </div>
                            </div>

                            <input type="hidden" name="po[delivery_status]" value="delivered" />

                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Supplier Mobile No</label>
                                <div class="col-sm-8">
                                    <input type="text" name="supplier[mobil_number]" class="form-control form-align" id="customer_no" value="<?php echo $val['mobil_number']; ?>" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Supplier Email ID</label>
                                <div class="col-sm-8" id='customer_td'>
                                    <input type="text" name="supplier[email_id]" class=" form-control form-align " id="email_id" value="<?php echo $val['email_id']; ?>" readonly="readonly" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">GSTIN No</label>
                                <div class="col-sm-8">
                                    <input type="text" name="supplier[tin_no]" id="tin" class="form-control form-align" value="<?php echo $val['tin']; ?>" readonly="readonly" />
                                </div>
                            </div>

                            <input type="hidden" name="po[pr_status]" value="approved" />


                        </div>
                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Supplier Address</label>
                                <div class="col-sm-8">
                                    <textarea name="supplier[address1]" class=" form-control form-align" id="address1" readonly="readonly"><?php echo $val['address1']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" tabindex="1" class="form-align datepicker required" name="po[created_date]" placeholder="dd-mm-yyyy" id="form_date" value="<?= date('d-m-Y', strtotime($val['created_date'])); ?>" onblur="validate_date('form_date')">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>

                                    </div>
                                    <span class="error_msg invalid_date_error1"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Bill Type<span style="color:#F00; font-style:oblique;">*</span></label>
                                <div class="col-sm-8">
                                    <input type="radio" class="receiver" value="cash" name="po[po_type]" <?php echo ($val['po_type'] == 'cash') ? 'checked' : ''; ?> /> Cash Purchase &nbsp;
                                    <input type="radio" class="receiver" value="credit" name="po[po_type]" <?php echo ($val['po_type'] == 'credit') ? 'checked' : ''; ?> /> Credit Purchase<br>
                                    <span id="type1" class="error_msg"></span>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="mscroll">



                        <div id="modal_dynamic" style="display:none">

                            <div class="modal_div">
                                <div id="" class="modal fade in ime_code_modal_id " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center" style="display: none;">
                                    <div class="modal-dialog ">
                                        <div class="modal-content modalcontent-top">
                                            <div class="modal-header modal-padding modalcolor">

                                                <a class="close modal-close closecolor ime_code_moadal_dismiss" data-dismiss="modal"></a>
                                                <h3 id="myModalLabel" style="color:white;margin-top:10px">IMEI Code Update </h3>
                                            </div>
                                            <div class="modal-body modal_scroll">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h5 style="margin-top:28px;"><strong>Bar code scanner</strong></h5>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group-addonab" style="font-size:50px;">
                                                                <i class="fa fa-barcode"></i>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row col-md-12">
                                                        <div class="col-md-6">
                                                            <h5><strong>IMEI Code</strong></h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class=" form-control ime_code_width" name="brands" value="" id="colornameup" maxlength="15" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class=" form-control ime_code_width" name="brands" value="" id="colornameup" maxlength="15" autocomplete="off">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer action-btn-align">
                                                <button type="button" class="edit btn btn-info1 discard_ime_update" id="update_ime">Update</button>
                                                <button type="reset" class="btn btn-danger1 discard_ime_discard" id="" data-dismiss="modal"> Discard</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <table class="table  table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                            <thead>
                                <tr>
                                    <td width="2%" class="first_td1">S.No</td>
                                    <td width="10%" class="first_td1">Category</td>

                                    <td width="16%" class="first_td1">Product Name</td>
                                    <td width="10%" class="first_td1">Model</td>
                                    <!-- <td width="5%" class="first_td1">Unit</td>-->
                                    <td width="12%" class="first_td1 action-btn-align">QTY</td>
                                    <td width="8%" class="first_td1 action-btn-align">Unit Price</td>
                                    <td width="8%" class="first_td1 action-btn-align">Sell Price</td>
                                    <!-- <td width="5%" class="first_td1 action-btn-align">Total</td>-->
                                    <td width="5%" class="first_td1 action-btn-align">HSN Code</td>
                                    <!--  <td width="7%" class="first_td1 action-btn-align">Discount %</td>-->

                                    <td width="5%" class="first_td1 action-btn-align cgst_td">CGST %</td>
                                    <?php if ($val['state_id'] == 31) { ?>
                                        <td width="5%" class="first_td1 action-btn-align sgst_td">SGST %</td>
                                    <?php } else { ?>
                                        <td width="5%" class="first_td1 action-btn-align igst_td">IGST %</td>
                                    <?php } ?>
                                    <!-- <td width="6%" class="first_td1 action-btn-align">Transport</td>-->
                                    <td width="5%" class="first_td1">Net Value</td>
                                    <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add </a></td>
                                </tr>
                            </thead>
                            <tbody id='app_table'>
                                <?php
                                if (isset($po_details) && !empty($po_details)) {
                                    $i = 1;
                                    foreach ($po_details as $vals) {
                                ?>
                                        <tr class="" data-inc="">


                                            <td class="action-btn-align s_no">
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                            <input type="hidden" id="catname" class="catname" name ="catname" value="<?php echo $vals['categoryName'] ?>"/>
                                                <select id='cat_id' class='form-control cat_id static_style class_req required' name='categoty[]' style="width:100%">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (isset($category) && !empty($category)) {
                                                        foreach ($category as $va) {
                                                            $select = ($va['cat_id'] == $vals['category']) ? 'selected' : '';
                                                    ?>
                                                            <option value='<?php echo $va['cat_id'] ?>' <?php echo $select; ?>><?php echo $va['categoryName'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error_msg"></span>
                                                <input type="hidden" style="width:100%" class='form-control form-align  tabwid model_no_extra' value="<?php echo $vals['model_no']; ?>" />
                                            </td>
                                            <td style="display:none">

                                            </td>
                                            <td>
                                                <input type="text" name="model_no[]" id="model_no" style="width:100%" class='form-control form-align auto_customer tabwid model_no required' tabindex="1" value="<?php echo $vals['product_name']; ?>" />
                                                <span class="error_msg"></span>
                                                <input type="hidden" name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                                <input type="hidden" name="old_product_id[]" id="old_product_id" class='old_product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                                <input type="hidden" name="old_firm_id[]" id="old_firm_id" class='old_firm_id tabwid form-align' value="<?php echo $val['firm_id']; ?>" />
                                                <input type="hidden" name="old_cat_id[]" id="old_cat_id" class='old_cat_id tabwid form-align' value="<?php echo $vals['category']; ?>" />

                                                <input type="hidden" name="product_name" id="product_name" class='product_name tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                                <input type="hidden" name="type[]" id="type" class=' tabwid form-align type' value="<?php echo $vals['type']; ?>" />
                                                <!--                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>-->

                                            </td>
                                            <td>
                                                <select id='brand_id' name='brand[]' tabindex="1" class="form-control brand_id  test<?php echo $vals['brand'] ?>">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (isset($brand) && !empty($brand)) {
                                                        foreach ($brand as $va) {
                                                            $select = ($va['id'] == $vals['brand']) ? 'selected' : '';
                                                    ?>
                                                            <option value='<?php echo $va['id'] ?>' <?php echo $select; ?>><?php echo $va['brands'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error_msg"></span>
                                            </td>

                                            <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit']; ?>" />

                                            <td class="ime_modal ime_code_error">
                                                <div class="col-md-5">
                                                    <input type="text" tabindex="-1" name='available_quantity[]' style="width:50px;" class="form-control  stock_qty" value="<?php echo ($vals['stock'][0]['quantity'] != '') ? $vals['stock'][0]['quantity'] : '0'; ?>" readonly="readonly" />
                                                </div>

                                                <div class="col-md-5">
                                                    <input type="text" tabindex="" name='quantity[]' style="width:50px;" class="qty required form-control" value="<?php echo $vals['quantity']; ?>" />
                                                </div>

                                                <input type="hidden" name="old_product_qty[]" value="<?php echo $vals['quantity']; ?>" />
                                                <input type="hidden" name="po_details_id[]" value="<?php echo $vals['id']; ?>" />
                                                <div class="col-md-2">
                                                    <a class="btn btn-info btn-xs ime_modal_add" id="ime_code_add" style="margin-top:6px; margin-left:-5px; border-radius: 0px;" title="Add IMEI Code" onclick="">
                                                        <span class="fa fa-barcode"></span>
                                                    </a>

                                                    <input type="hidden" name="ime_code_value[]" id="ime_code_value" class='ime_code_value required tabwid form-align' value="<?php echo $vals['ime_codes']; ?>" />
                                                </div>

                                                <span class="error_msg"></span>

                                            </td>

                                            <td style="text-align: center;">
                                                <input type="text" tabindex="1" name='per_cost[]' style="width:70px;" class="cost_price percost required" value="<?php echo $vals['per_cost']; ?>" />
                                                <input type="hidden" name="price_with_gst[]" class="price_with_gst" value="<?php echo $vals['price_with_gst']; ?>">
                                                <input type="hidden" name="price_without_gst[]" class="price_without_gst" value="<?php echo $vals['price_without_gst']; ?>">
                                                <span class="error_msg"></span>
                                            </td>

                                            <td style="text-align: center;">
                                                <input type="text" tabindex="1" name='sale_cost[]' style="width:70px;" class="sales_price salecost required" value="<?php echo $vals['sale_cost']; ?>" />
											</td>	

                                            <!--<td class="action-btn-align">
                                        <input type="text"   tabindex="1"  style="width:70px;" class="gross"   />
                                    </td>-->

                                            <input type="hidden" tabindex="-1" name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount']; ?>" />


                                            <td class="action-btn-align">

                                                <input type="text" style="width:75px;" class="hsn_code" readonly="readonly" autocomplete="off" value="<?php echo $vals['hsn_sac']; ?>" />

                                            </td>

                                            <td class="action-btn-align cgst_td <?php echo $val['state_id']; ?>">
                                                <input type="text" tabindex="1" name='tax[]' style="width:70px;" class="pertax" value="<?php echo number_format($vals['tax'], 2); ?>" readonly="readonly" />
                                            </td>
                                            <?php if ($val['state_id'] == 31) { ?>
                                                <td class="action-btn-align sgst_td">
                                                    <input type="text" tabindex="1" name='gst[]' style="width:70px;" class="gst" value="<?php echo number_format($vals['gst'], 2); ?>" readonly="readonly" />
                                                </td>
                                            <?php } else { ?>
                                                <td class="action-btn-align igst_td">
                                                    <input type="text" tabindex="1" name='igst[]' style="width:70px;" class="igst wid50" value="<?php echo number_format($vals['igst'], 2); ?>" readonly="readonly" />
                                                </td>

                                            <?php } ?>
                                            <input type="hidden" tabindex="-1" name='transport[]' style="width:70px;" class="transport" value="" />
                                            <input type="hidden" value="" class=" ime_code_first" name="ime_code[]" id="" />

                                            <td>
                                                <input type="text" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['price_with_gst']; ?>" />
                                            </td>
                                            <td class="action-btn-align"><a id='delete_group' class="btn btn-danger delete_group"><span class="glyphicon glyphicon-trash"></span></a></td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>


                                    <td>
                                        <div class="col-md-5"><b>Total</b></div>
                                        <div class="col-md-5"><input type="text" tabindex="-1" name="po[total_qty]" readonly="readonly" class="total_qty" style="width:50px;" id="total" value="<?php echo $val['total_qty']; ?>" /></div>
                                    </td>

                                    <td colspan="5" style="text-align:right;">Sub Total</td>

                                    <td><input type="text" name="po[subtotal_qty]" tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>" class="final_sub_total text_right" style="width:70px;" /></td>

                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="width:70px; text-align:right;"></td>
                                    <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text" name="po[tax_label]" class='tax_label text_right' style="width:100%;" value="<?php echo $val['tax_label']; ?>" /></td>
                                    <td>
                                        <input type="text" name="po[tax]" class='totaltax text_right' value="<?php
                                                                                                                if ($val['tax'] != 0) {
                                                                                                                    echo $val['tax'];
                                                                                                                }
                                                                                                                ?>" style="width:70px;" />
                                    </td>
                                    <td></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="6" style="width:70px; text-align:right;"></td>
                                    <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                                    <td></td>
                                </tr>-->
                                <?php //echo "<pre>";print_r($val);exit;  
                                ?>
                                <tr>

                                    <td colspan="4" style="text-align:right;font-weight:bold;">
                                        Taxable Price</td>
                                    <td><input type="text" tabindex="-1" name="po[taxable_price]" readonly="readonly" class="taxable_price text_right" style="width:70px;" value="<?php echo number_format($val['taxable_price'], 2); ?>" /></td>

                                    <td colspan="1" style="text-align:right;font-weight:bold;">CGST</td>
                                    <td><input type="text" tabindex="-1" name="po[cgst_price]" readonly="readonly" class="cgst_price text_right" style="width:70px;" value="<?php echo number_format($val['cgst_price'], 2); ?>" /></td>

                                    <td colspan="1" style="text-align:right;font-weight:bold;" class="igst_sgst">SGST</td>
                                    <td><input type="text" tabindex="-1" name="po[sgst_price]" readonly="readonly" class="sgst_price text_right" style="width:70px;" value="<?php echo number_format($val['sgst_price'], 2); ?>" /></td>



                                    <td colspan="1" style="text-align:right;font-weight:bold;">Net Total</td>

                                    <td><input type="text" tabindex="-1" name="po[net_total]" readonly="readonly" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>

                                    <td></td>

                                </tr>

                                <tr>

                                    <td colspan="14" style="">
                                        <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                        <input name="po[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="inner-sub-tit mstyle">TERMS AND CONDITIONS</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">1. Delivery Schedule</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input type="text" class="form-control datepicker class_req borderra0 terms" name="po[delivery_schedule]" placeholder="dd-mm-yyyy" id="delivery_schedule" onblur="validate_date('delivery_schedule')" value="<?= date('d-m-Y', strtotime($val['delivery_schedule'])); ?>">
                                        <span id="colorpoerror" class="invalid_date_error2" style="color:#F00;"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">3. Mode of Payment</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input type="text" class="form-control class_req borderra0 terms" name="po[mode_of_payment]" value="<?php echo $val['mode_of_payment']; ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <input type="hidden" name="po[supplier]" id="c_id" class='id_customer' value="<?php echo $val['vendor']; ?>" />
                    <input type="hidden" name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>" />
                    <div class="action-btn-align">

                        <button class="btn btn-primary" id="save"> Update </button>

                        <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                    </div>
                </form>
                <br />

        <?php
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/toastr.min.css" />
<script type='text/javascript' src='<?= $theme_path; ?>/js/toastr.min.js'></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/scan/jquery.scannerdetection.compatibility.js'></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/scan/jquery.scannerdetection.compatibility.min.js'></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/scan/jquery.scannerdetection.js'></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/scan/jquery.scannerdetection.min.js'></script>

<script type="text/javascript">
    var i = 1;
    $('#app_table tr').each(function() {
        $(this).closest("tr").find('.s_no').html(i);
        $(this).closest("tr").addClass('inc_class' + i + '');
        $(this).closest("tr").attr('data-inc', i);
        var name = "ime_modal(" + i + ")";
        $(this).closest("tr").find('.ime_modal_add').attr("onclick", name);
        i++;
    });


    var formHasChanged = false;
    var submitted = false;



    function validate_date(id) {
        var dateString = document.getElementById(id).value;
        var pattern = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
        var test_date = pattern.test(dateString);

        if (test_date == true) {
            if (id == "delivery_schedule")
                $('.invalid_date_error2').text('');
            else
                $('.invalid_date_error1').text('');
        } else {

            if (id == "delivery_schedule")
                $('.invalid_date_error2').text('Invalid Date Format');
            else
                $('.invalid_date_error1').text('Invalid Date Format');
        }
    }


    $('#save').on('click', function() {
        m = 0;
        $('.required').each(function() {

            var tr = $('#app_table tr').length;
            if (tr > 1) {
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

                cat_name =  $(this).closest('tr').find('.catname').val();


                if (this_val == "" || ($(this).hasClass('qty') && this_val == 0) && ($(this).closest('table').hasClass('static')== false)) {
                if (this_id == "ime_code_value") {
                    this_class = $(this).closest('div').attr('class');
                    if (cat_name == "Fresh Mobiles" || cat_name == "Used Mobiles") {
                        $(this).closest('td.ime_code_error').find('.error_msg').text('Please add imei code').css('display', 'inline-block');
                        m++;
                    } else {
                        $(this).closest('td.ime_code_error').find('.error_msg').text('');
                    }
                }
                 else {

                        $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');

                        $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');

                        m++;
                    }
                } else {

                    $(this).closest('tr td').find('.error_msg').text('');

                    $(this).closest('div .form-group').find('.error_msg').text('');

                }
            });

            $('input.required.qty').each(function(){
           
           if($(this).val() <= 0 && ($(this).closest('table').hasClass('static')== false)){
           
                $(this).closest('td.ime_code_error').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                 m++;
            } else {
                if(m <= '0')
                    $(this).closest('td.ime_code_error').find('.error_msg').text('');
            }
        });

        if ($('input[type=radio]:checked').length <= 0) {
            $("#type1").html("This field is required");
            m = 1;
        } else {
            $("#type1").html("");
        }

        var pr_id = $.trim($("#pr_no").val());
        if (pr_id == "" || pr_id == null || pr_id.trim().length == 0) {
            $("#pr_id_err").html("This field is required");
            m++;
        } else {
            $("#pr_id_err").html("");
        }
        var erp_po_id = $("#erp_po_id").val();
        if (pr_id != '') {
            $.ajax({
                url: BASE_URL + "purchase_order/check_duplicate_pr_id_edit",
                type: 'post',
                data: {
                    value1: pr_id,
                    value2: erp_po_id
                },
                success: function(result) {
                    $("#duplica_err").html(result);
                }
            });
        } else {
            $("#duplica_err").html('');
        }
        
        if (m > 0) {
            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)
            }, 500);
            return false;
        } else {
            // submitted = true;
            $('#po_edit_form').submit();
        }
    });



    function bar_code_detection(id, pro_qty) {

        var modal_id = "ime_code_modal" + id;

        /*$(document).scannerDetection({
         timeBeforeScanTest: 200, // wait for the next character for upto 200ms
         avgTimeByChar: 2, // it's not a barcode if a character takes longer than 100ms
         onComplete: function(barcode, qty){
         console.log('barcode');
         alert(barcode);
         },onError: function(string, qty) {*/

        //  console.log(string.length);

        var string = $('#' + modal_id + '').find('.ime_code_detect').val();

        var modal_name = "ime_code_modal" + id;
        var ime_code = $('#' + modal_name + '').find("input[name='ime_code[]']").val();
        var classname = "inc_class" + id;
        var ime_code_val = [];
        var results = [];
        for (i = 1; i <= pro_qty; i++) {
            var ime_id = "ime_code" + id + i;
            var ime_val = $('#' + modal_name + '').find('#' + ime_id + '').val();

            if (ime_val == string) {
                var data = "Duplicate Records in IMEI Code " + i + '';
                results.push("<p>" + data + "</p>");

            }

        }


        if (string == "") {
            toastr.clear();
            toastr.error("IMEI Code Required", 'Warning Message.!');
        } else if (!($.isNumeric(string))) {
            toastr.clear();
            toastr.error("IMEI Code Allowed Only Numbers", 'Warning Message.!');
        } else if (results.length > 0) {
            toastr.clear();
            toastr.error(results, 'Warning Message.!');
        } else if (string.length == 15) {
            toastr.clear();
            toastr.success("Barcode Detected", 'Success Message.!');

            $('#' + modal_id + '').find('.ime_code_detect').val(string);


            var check_data = [];
            for (i = 1; i <= pro_qty; i++) {
                var ime_code_id = "ime_code" + id + i;
                var id_val = $('#' + modal_id + '').find('#' + ime_code_id + '').val();

                if (id_val == "") {
                    if (check_data == "") {
                        check_data.push(string);
                        var ime_code_id = "ime_code" + id + i;
                        $('#' + modal_id + '').find('#' + ime_code_id + '').val(string);
                        j = i + 1;
                        var ime_code_id = "ime_code" + id + j;
                        //  $('#'+modal_id+'').find('#'+ime_code_id+'').focus();
                        if (i == pro_qty) {
                            toastr.warning("IMEI Code Detected..Please Update Code", 'Warning Message.!');

                        }
                    }
                }

                $('#' + modal_id + '').find('.ime_code_detect').val('');
                $('#' + modal_id + '').find('.ime_code_detect').focus();
            }
        } else {
            toastr.clear();
            toastr.error("Invalid IMEI Code..Allowed Only 15 Numeric", 'Warning Message.!');
        }


        // } // main callback function
        //});

    }






    function ime_modal(id) {

        var modal_id = "ime_code_modal" + id;
        var classname = "inc_class" + id;

        ime_qty = $('.' + classname + '').find('.qty ').val();
        product_name = $('.' + classname + '').find('.product_name ').val();

        //product_name="test";
        var ime_value = $('.' + classname + '').find('.ime_code_value').val();
        var ime_value_arr = '';
        if (ime_value)
            var ime_value_arr = ime_value.toString().split(",");
        // console.log(ime_value_arr);

        if (ime_qty > 0 && product_name != "") {
            var html = '';
            html += '<div id="ime_code_modal' + id + '" class="modal fade in" data-backdrop="false" tabindex="-1" class="ime_code_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"' +
                'align="center" style="display: none;">' +
                '<div class="modal-dialog ">' +
                '<div class="modal-content modalcontent-top">' +
                '<div class="modal-header modal-padding modalcolor "><a class="close modal-close closecolor"  onclick="ime_modal_discard(' + id + ')">×</a>' +
                '<h3 id="myModalLabel" style="color:white;margin-top:10px">' + product_name + ' - IMEI Code Update</h3>' +
                ' </div>' +
                '<div class="modal-body modal_scroll">' +
                '<form>' +
                '<div class="row">';

            html += '<div class="form-group">' + '<div class="ime_code_loop"><div class="row col-md-12">' +
                '<div class="col-md-6"><h5><strong>Bar Code Detect</strong></h5>' +
                '</div>' +
                '<div class="col-md-6">' + '<div class="input-group">' +
                '<input type="text" class=" form-control ime_code_width ime_code_detect" tabindex="1" name="ime_code_detect" value="" id="ime_code_detect" maxlength="15" autocomplete="off"><div class="input-group-addon"><a href="javascript:" tabindex="2"> <i class="fa fa-barcode" onclick="bar_code_detection(' + id + "," + ime_qty + ')"></i></a></div>' +
                '</div></div></div></div></div>';




            for (i = 1; i <= ime_qty; i++) {
                var ime_code_val = '';
                if (ime_value_arr.length > 0) {
                    var ime_code_val = ime_value_arr[i - 1];
                    if (ime_code_val != undefined)
                        var ime_code_val = ime_value_arr[i - 1];
                    else
                        var ime_code_val = '';
                }


                html += '<div class="ime_code_loop"><div class="row col-md-12">' +
                    '<div class="col-md-6">' +
                    '<h5><strong>IMEI Code ' + i + '</strong></h5>' +
                    '</div>' +
                    '<div class="col-md-6 ime_code_div">' +
                    '<input type="text" class=" form-control ime_code_width ime_code" name="ime_code[]" value="' + ime_code_val + '" id="ime_code' + id + i + '" maxlength="15" autocomplete="off">' +
                    '</div></div></div>';
            }





            html += '</div>' +
                '</form>' +
                '</div>' +
                '<div class="modal-footer action-btn-align" style="">' +
                ' <button type="button" class="edit btn btn-info1 update_ime" tabindex="3" onclick="ime_modal_update(' + id + "," + ime_qty + ')">Update</button>' +
                '<button type="button" class="btn btn-danger1 "  onclick="ime_modal_discard(' + id + ')"> Discard</button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div> ';
            $('#add_modal').html(html);

            $('#' + modal_id + '').modal('show');
            $('#' + modal_id + '').find('.ime_code_detect').focus();


            //bar_code_detection(id,ime_qty)


        } else {
            toastr.clear();
            toastr.error("Please add Quantity of Product", 'Warning Message.!');
        }


    }


    function ime_modal_update(id, qty) {

        var modal_name = "ime_code_modal" + id;
        var ime_code = $('#' + modal_name + '').find("input[name='ime_code[]']").val();
        var classname = "inc_class" + id;
        var ime_code_val = [];
        var results = [];
        for (i = 1; i <= qty; i++) {
            var ime_id = "ime_code" + id + i;
            var ime_val = $('#' + modal_name + '').find('#' + ime_id + '').val();
            var check_ime = ime_code_val.includes(ime_val);
            if (ime_val == "") {
                var data = "Empty Field in IMEI Code " + i + '';
                results.push("<p>" + data + "</p>");

            } else if (!($.isNumeric(ime_val))) {
                var data = "Invalid Records in IMEI Code " + i + '';
                results.push("<p>" + data + "</p>");

            } else if (check_ime == true) {
                var data = "Duplicate Records in IME Code " + i + '';
                results.push("<p>" + data + "</p>");

            } else {
                ime_code_val.push(ime_val);
            }

        }
        if (results.length > 0) {
            toastr.error(results, 'Warning Message.!');
        } else {

            $.ajax({
                type: 'POST',
                data: {
                    ime_code: ime_code_val
                },
                url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/check_duplicate_ime_code_edit/",
                success: function(data) {

                    toastr.clear();
                    if (data == 0) {
                        $('.' + classname + '').find('.ime_code_value').val(ime_code_val);
                        toastr.success('IMEI Code Successfully updated', 'Success Message.!');

                        $('#' + modal_name + '').modal('toggle');
                    } else {
                        var data = JSON.parse(data);
                        var results = [];
                        $.each(data, function(key, value) {
                            var dup_data = "IMEI Code " + value + '';
                            results.push("<p>" + dup_data + "</p>");
                        });
                        toastr.error(results, 'Alreday Exists IMEI Code.!');
                    }

                }
            });



        }

    }


    function ime_modal_discard(id) {
        var modal_id = "ime_code_modal" + id;
        $('#' + modal_id + '').modal('hide');

    }




    $(document).ready(function() {







        calculate_function();

        if ($('#gst_type').val() != '') {
            if ($('#gst_type').val() == 31) {
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

        // $('#firm').focus();
        //  $('#firm').trigger('change');
        $('body').on('keydown', 'input#customer_name', function(e) {
            var c_data = [<?php echo implode(',', $customers_json); ?>];
            $("#customer_name").blur(function() {
                var keyEvent = $.Event("keydown");
                keyEvent.keyCode = $.ui.keyCode.ENTER;
                $(this).trigger(keyEvent);
                // Stop event propagation if needed
                return false;
            }).autocomplete({
                source: function(request, response) {
                    // filter array to only entries you want to display limited to 10
                    /*  var outputArray = new Array();
                     for (var i = 0; i < c_data.length; i++) {
                     if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                     outputArray.push(c_data[i]);
                     }
                     }
                     response(outputArray.slice(0, 10));*/

                    $.ajax({
                        type: 'POST',
                        data: {
                            firm_id: $('#firm').val()
                        },
                        url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_supplier_by_firm/",
                        success: function(data) {



                            data = JSON.parse(data);

                            var c_data = data;

                            var outputArray = new Array();

                            for (var i = 0; i < c_data.length; i++) {



                                if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {

                                    outputArray.push(c_data[i]);

                                }

                            }

                            if (outputArray.length == 0) {
                                var nodata = 'No Product Found';
                                outputArray.push(nodata);
                            }

                            response(outputArray.slice(0, 10));

                        }

                    });



                },
                minLength: 0,
                delay: 0,
                autoFocus: true,
                select: function(event, ui) {
                    cust_id = ui.item.id;
                    $.ajax({
                        type: 'POST',
                        data: {
                            cust_id: cust_id
                        },
                        url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_customer/",
                        success: function(data) {
                            var result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#customer_id").val(result[0].id);
                                $("#gst_type").val(result[0].state_id);
                                $("#c_id").val(result[0].id);
                                $("#customer_name").val(result[0].store_name);
                                $("#customer_no").val(result[0].mobil_number);
                                $("#email_id").val(result[0].email_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
                                $("#credit_days").val(result[0].credit_days);
                                if ($('#gst_type').val() != '') {
                                    if ($('#gst_type').val() == 31) {
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
                            }
                        }
                    });
                }
            });
        });
    });


    $('#add_group').click(function() {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.percost,.salecost,.qty').addClass('required');
        $('#app_table').append(tableBody);
        if ($('#gst_type').val() != '') {
            if ($('#gst_type').val() == 31) {
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
            $(this).closest("tr").addClass('inc_class' + i + '');
            $(this).closest("tr").attr('data-inc', i);
            i++;
        });
    });

    $('#add_group').click(function() {


        var inc_id = $('#app_table tr').last().attr('data-inc');
        var classname = "inc_class" + inc_id;
        var name = "ime_modal(" + inc_id + ")";
        $('.' + classname + '').find('.ime_modal_add').attr("onclick", name);

    });


    $(document).on('click','.delete_group',function() {
        $(this).closest("tr").remove();
        calculate_function();

        var i = 1;
        $('#app_table tr').each(function() {
            $(this).closest("tr").find('.s_no').html(i);
            i++;
        });
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

    $(document).on('keyup','.qty',function() {
        var qty = $(this).val();

        if (qty % 1 === 0) {
            $(this).closest('tr').find('.ime_modal .error_msg').text(' ');
            calculate_function();
        } else {
            $(this).closest('tr').find('.ime_modal .error_msg').text('Invalid quantity');
        }





    });

    $(document).on('keyup','.percost,.salecost,.pertax,.totaltax,.gst,.igst,.discount,.transport',function() {

        calculate_function();

    });

    function calculate_function() {

        var final_qty = 0;

        var final_sub_total = 0;

        var total_gst_price = 0;

        var total_cgst_price = 0;

        var total_sgst_price = 0;

        $('.qty').each(function() {

            var qty = $(this);

            var percost = $(this).closest('tr').find('.percost');

            var pertax = $(this).closest('tr').find('.pertax');

            var gst = $(this).closest('tr').find('.gst');

            var igst = $(this).closest('tr').find('.igst');

            var subtotal = $(this).closest('tr').find('.subtotal');

            var discount = $(this).closest('tr').find('.discount');

            var transport = $(this).closest('tr').find('.transport');




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




                var price_without_gst = $(this).closest('tr').find('.price_without_gst');
                var price_with_gst = $(this).closest('tr').find('.price_with_gst');

                var gst_price = (Number(cgst_price) + Number(sgst_price)).toFixed(2);

                var wo_gst_price = (Number(tot) - Number(gst_price)).toFixed(2);


                price_without_gst.val(wo_gst_price);

                price_with_gst.val(tot.toFixed(2));

                total_gst_price = (Number(total_gst_price) + Number(gst_price));

                total_cgst_price = (Number(total_cgst_price) + Number(cgst_price));
                total_sgst_price = (Number(total_sgst_price) + Number(sgst_price));

                final_sub_total = final_sub_total + tot;

                final_qty = final_qty + Number(qty.val());

            }

        });

        $('.total_qty').val(final_qty);

        var taxable_price = (final_sub_total - Number(total_gst_price));

        $('.taxable_price').val(taxable_price.toFixed(2));

        $('.cgst_price').val(total_cgst_price.toFixed(2));

        $('.sgst_price').val(total_sgst_price.toFixed(2));

        $('.final_sub_total').val(final_sub_total.toFixed(2));

        var totaltax = $('.totaltax').val();
        if (totaltax)
            final_sub_total = final_sub_total + parseInt(totaltax);
        console.log(final_sub_total);
        $('.final_amt').val(final_sub_total.toFixed(2));

    }

    $(".datepicker").datepicker({
        setDate: new Date(),
        onClose: function() {

            this_id = $(this).attr("id");

            if (this_id != "delivery_schedule")
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
    $('body').on('keydown', '#add_quotation input.model_no', function(e) {
        var _this = $(this);
        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function(request, response) {
                var val = _this.closest('tr input.model_no').val();
                var category_id = _this.closest('tr').find('.cat_id').val();
                var product_data = [];
                cat_id = $('#firm').val();
                cust_id = $('#customer_id').val();
                if ($.trim(val).length != 0) {
                    $.ajax({
                        type: 'POST',
                        data: {
                            firm_id: cat_id,
                            category_id:category_id,
                            pro: val,
                            sale_type: 'purchase'
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
                    if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                        outputArray.push(product_data[i]);
                    }
                }
                if (outputArray.length == 0) {
                    var nodata = 'Please Purchase Product';
                    outputArray.push(nodata);
                }
                response(outputArray.slice(0, 10));
            },
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
                        c_id: cust_id
                    },
                    url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product/" + cat_id,
                    success: function(data) {
                        var result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            if (result[0].quantity != null) {
                                this_val.closest('tr').find('.stock_qty').val(result[0].quantity);
                            } else {
                                this_val.closest('tr').find('.stock_qty').val('0');
                            }

                            this_val.closest('tr').find('.unit').val(result[0].unit);
                            this_val.closest('tr').find('.hsn_code').val(result[0].hsn_sac);
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                            this_val.closest('tr').find('.catname').val(this_val.closest('tr').find('.cat_id').find('option:selected').text());
                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                            this_val.closest('tr').find('.price_without_gst').val(result[0].cost_price_without_gst);
                            this_val.closest('tr').find('.price_with_gst').val(result[0].cost_price);
                            this_val.closest('tr').find('.sales_price').val(result[0].sales_price);
                            this_val.closest('tr').find('.type').val(result[0].type);
                            this_val.closest('tr').find('.product_id').val(result[0].id);
                            this_val.closest('tr').find('.product_name').val(result[0].product_name);
                            this_val.closest('tr').find('.model_no').val(result[0].product_name);
                            this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                            this_val.closest('tr').find('.product_description').val(result[0].product_description);
                            if ($('#gst_type').val() != '') {
                                if ($('#gst_type').val() == 31) {
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
                            var name = $('#app_table tr:last').find('.model_no').val();
                            if (name != '')
                                $('#add_group').trigger('click');
                            calculate_function();
                        }
                    }
                });
            }
        });
    });


    $('body').on('keydown', 'input.model_no_extra', function(e) {
        // var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];
        cat_id = $('#firm').val();
        cust_id = $('#customer_id').val();
        var product_data = [];
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
                    var nodata = 'Please Purchase Product';
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
                    url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product/" + cat_id,
                    success: function(data) {
                        var result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            this_val.closest('tr').find('.unit').val(result[0].unit);
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                            this_val.closest('tr').find('.hsn_code').val(result[0].hsn_sac);
                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                            this_val.closest('tr').find('.price_with_gst').val(result[0].cost_price);
                            this_val.closest('tr').find('.price_without_gst').val(result[0].cost_price_without_gst);
                            this_val.closest('tr').find('.sales_price').val(result[0].sales_price);
                            this_val.closest('tr').find('.type').val(result[0].type);
                            this_val.closest('tr').find('.product_id').val(result[0].id);
                            this_val.closest('tr').find('.product_name').val(result[0].product_name);
                            this_val.closest('tr').find('.model_no').val(result[0].product_name);
                            this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                            this_val.closest('tr').find('.product_description').val(result[0].product_description);
                            if ($('#gst_type').val() != '') {
                                if ($('#gst_type').val() == 31) {
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

    $('.pro_class').on('click', function() {
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.pertax').val($(this).attr('pro_cgst'));
        $(this).closest('tr').find('.gst').val($(this).attr('pro_sgst'));
        $(this).closest('tr').find('.discount').val($(this).attr('pro_discount'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
        $(this).closest('tr').find('.sales_price').val($(this).attr('sale_cost'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.product_name').val($(this).attr('pro_name'));
        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });

    function Firm(val) {
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
                        $('.cat_id,.model_no,.model_no_extra').val('');
                        $('.model_no,.model_no_extra').removeAttr('readonly', 'readonly');

                    } else {
                        $('.cat_id,.model_no,.model_no_extra').val('');
                        $('.model_no,.model_no_extra').attr('readonly', 'readonly');
                    }
                }
            });

            //            $.ajax({
            //                type: 'POST',
            //                dataType: 'JSON',
            //                data: {firm_id: val},
            //                url: '<?php echo base_url(); ?>quotation/get_prefix_by_frim_id/',
            //                success: function (data1) {
            //                    $('#po_id').val(data1[0]['prefix']);
            //
            //                    $.ajax({
            //                        type: 'POST',
            //                        dataType: 'JSON',
            //                        data: {type: data1[0]['prefix'], code: 'PO'},
            //                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
            //                        success: function (data2) {
            //                            $('#po_id').val(data2);
            //                            //console.log(data2);
            //                            var increment_id = $('#po_id').val().split("/");
            //                            sales_id = 'PO-' + data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
            //                            $('#po_id').val(sales_id);
            //                            pr_id = 'PR-' + data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
            ////                            $('#pr_id').val(pr_id);
            //                        }
            //                    });
            //                }
            //            });


        } else {
            $('.cat_id,.model_no,.model_no_extra').val('');
            $('.model_no,.model_no_extra').attr('readonly', 'readonly');
        }
    }
    $(window).bind('scannerDetectionReceive', function(event, data) {
        target_ele = event.target.activeElement;
    });

    //    $(document).scannerDetection({
    //        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    //        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
    //        endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
    //        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
    //        onComplete: function (barcode, qty) {
    //            $(target_ele).val('');
    //            val = $('#app_table').find('.product_id').val();
    //            if (val == '') {
    //                $('#app_table').find('tr:first').remove();
    //            }
    //            cust_id = $('#customer_id').val();
    //            barcode = barcode;
    //            if (barcode != '' && cust_id != '') {
    //                $.ajax({
    //                    type: 'POST',
    //                    async: false,
    //                    data: {barcode: barcode, cust_id: cust_id},
    //                    url: '<?php echo base_url(); ?>sales/get_all_products/',
    //                    success: function (data) {
    //                        var result = JSON.parse(data);
    //                        if (result != null && result.length > 0) {
    //                            $.each(result, function (key, value) {
    //                                var prod_array = new Array();
    //                                $(".product_id").each(function () {
    //                                    prod_array.push($(this).val());
    //                                });
    //
    //                                if (jQuery.inArray(value.id, prod_array) > -1 && prod_array.length > 0)
    //                                {
    //                                    qty_val = $('#app_table .tr_' + value.id).find('.qty').val();
    //                                    var add = Number(qty_val) + Number(1);
    //                                    $('#app_table .tr_' + value.id).find('.qty').val(add);
    //                                    calculate_function();
    //                                } else {
    //
    //                                    var tableBody = $(".static").find('tr').clone();
    //                                    $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
    //                                    $('#app_table').append(tableBody);
    //                                    $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);
    //                                    if (result[0]['product_image'] == '')
    //                                        $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0]['product_image']);
    //                                    else
    //                                        $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
    //                                    $(tableBody).closest('tr').find('.product_description').val(result[0]['product_description']);
    //                                    $(tableBody).closest('tr').find('.qty').val('1');
    //                                    $(tableBody).closest('tr').addClass('tr_' + result[0]['id']);
    //                                    $(tableBody).closest('tr').find('.product_id').val(result[0]['id']);
    //                                    $(tableBody).closest('tr').find('.selling_price').val(result[0]['selling_price']);
    //                                    $(tableBody).closest('tr').find('.type').val(result[0]['type']);
    //
    //                                    $(tableBody).closest('tr').find('.discount').val(result[0]['discount']);
    //                                    $(tableBody).closest('tr').find('.brand_id').val(result[0]['brand_id']);
    //                                    $(tableBody).closest('tr').find('.unit').val(result[0]['unit']);
    //                                    $(tableBody).closest('tr').find('.cat_id').val(result[0]['category_id']);
    //                                    $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);
    //                                    $(tableBody).closest('tr').find('.model_no_extra').val(result[0]['model_no']);
    //                                    if ($('#gst_type').val() != '')
    //                                    {
    //                                        if ($('#gst_type').val() == 31)
    //                                        {
    //                                            $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);
    //                                            $(tableBody).closest('tr').find('.gst').val(result[0]['sgst']);
    //                                        } else {
    //                                            $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);
    //                                            $(tableBody).closest('tr').find('.igst').val(result[0]['igst']);
    //
    //                                        }
    //                                    }
    //                                    calculate_function();
    //                                    // Firm(result[0]['firm_id'], result[0]['category_id']);
    //                                }
    //
    //                            });
    //
    //                        } else {
    //                            sweetAlert("Error...", "This Product is not available!", "error");
    //                            return false;
    //                        }
    //
    //                    }
    //                });
    //            } else {
    //                sweetAlert("Error...", "This Product is not available!", "error");
    //                return false;
    //            }
    //
    //        }
    //    });

    $('input').on('keypress', function() {
        formHasChanged = true;
    });

    $('select').on('click', function() {
        formHasChanged = true;
    });

    $(document).on('change','.cat_id',function(){
            $(this).closest('td').find('.catname').val($(this).find('option:selected').text());
            
    });  

    $("#pr_no").blur(function() {

        var pr_id = $.trim($("#pr_no").val());
        if (pr_id == "" || pr_id == null || pr_id.trim().length == 0) {
            $("#pr_id_err").html("This field is required");
        } else {
            $("#pr_id_err").html("");
        }

        var id = $("#erp_po_id").val();
        $.ajax({
            url: BASE_URL + "purchase_order/check_duplicate_pr_id_edit",
            type: 'post',
            data: {
                value1: pr_id,
                value2: id
            },
            success: function(result) {
                $("#duplica_err").html(result);
            }
        });

    });


    //    $(window).bind('beforeunload', function () {
    //        if (formHasChanged && !submitted) {
    //            return 'Are you sure you want to leave?';
    //        }
    //
    //    });
</script>