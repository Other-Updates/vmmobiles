<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>


<!--
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<link rel="stylesheet" href="<?php echo $theme_path; ?>/css/bootstrap-select.css" />

<script src="<?php echo $theme_path; ?>/js/bootstrap-select.min.js"></script>



<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css" />



<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery.scannerdetection.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">

<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>

<script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>



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

    .auto-asset-search ul {
        position: absolute !important;
        z-index: 4;
        height: 150px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .auto-asset-search ul#service-list li.no_data {
        overflow-y: none;
    }

    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }

    .auto-asset-search ul#product-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }

    .auto-asset-search ul#service-list li:hover {
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
    }

    ul li {
        list-style-type: none;
    }

    .auto-asset-search ul#service-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }

    .tabwid3 {
        width: 92.5% !important;
    }

    .tabwid4 {
        width: 89.5% !important;
    }

    .ui-helper-hidden-accessible {
        display: block;
    }

    .auto-asset-search ul {
        width: 100%;
        padding: 0px;
    }

    .auto-asset-search ul#country-list li {
        width: 100%;
    }

    .modalcontent-top {

        margin: 64px 0 auto 0;

    }
</style>



<style>
    .bg-red {
        background-color: #dd4b39 !important;
    }



    .bg-green {
        background-color: #09a20e !important;
    }



    .bg-yellow {
        background-color: orange !important;
    }



    .ui-datepicker td.ui-datepicker-today a {
        background: #999999;
    }



    .fs-wrap {
        width: 100%;
        margin: 5px 0;
    }



    .fs-label-wrap .fs-label {
        padding: 9px 22px 8px 8px;
    }



    .fs-dropdown {
        width: 16%;
    }



    .btn-group>.btn,
    .btn-group-vertical>.btn {
        border-width: 0px !important;
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



    <div class="auto-widget">

        <!--    <p>Your Skills: <input type="text" id="skill_input"/></p>-->

    </div>

    <div class="contentpanel mb-45">



        <div class="media">

            <h4>Add Invoice &nbsp;

                <?php if (count($firms) == 1) { ?>

                    <div class="cuto-firm">

                        Shop : <small> <?php echo $firms[0]['firm_name']; ?> </small>

                    </div>

                <?php } ?></h4>



        </div>

        <table class="static" style="display: none;">

            <tr>

                <td class="action-btn-align s_no"></td>

                <td>

                    <input type="text" name="model_no[]" id="model_no" style="width:100%;font-weight: 600; " class='form-align auto_customer tabwid model_no ' readonly="" />

                    <span class="error_msg"></span>

                    <input type="hidden" name="product_id[]" id="product_id" class=' tabwid form-align product_id' />

                    <input type="hidden" value="" id="product_cost" />

                    <input type="hidden" name="type[]" id="type" class=' tabwid form-align type' />

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

                    <select id='cat_id' class='cat_id static_style  form-control form-align' style="display:none;" name='categoty[]'>

                        <option value="">Select</option>



                    </select>

                </td>

                <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="" />

                <!-- <td class="action-btn-align">

                    <input type="hidden"  style="width:100%"  class='form-align tabwid model_no_extra' readonly="readonly"/>

                    <input type="text"  tabindex="-1" name='unit[]' style="width:70px;" class="unit" />

                </td>-->

                <td class="qty_text">

                    <select name='brand[]' tabindex="-1" class="form-control form-align brand_id" style="display: none;">

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



                    <div class="col-xs-8">

                        <input type="text" tabindex="-1" name='quantity[]' style="width:70px;" class="qty quantity" value="" id="qty" data-stock="0" readonly />

                    </div>





                    <div class="col-xs-4"> <span class="label label-success stock_qty"> 0 </span></div>

                    <span class="error_msg"></span>

                </td>

                <td>

                    <input type="text" tabindex="-1" name='per_cost[]' style="width:70px;" class="selling_price percost " id="price" />
                    <input type="hidden" name="sp_with_gst[]" class="sp_with_gst">
                    <input type="hidden" name="sp_without_gst[]" class="sp_without_gst">

                    <span class="error_msg"></span>

                </td>

                <!--<td class="action-btn-align">

                <input type="text" tabindex="-1" style="width:70px;" class="gross" />

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

                    <input type="text" tabindex="-1" style="width:100px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />

                </td>

                <td class="action-btn-align"><a id='delete_group' class="btn btn-danger delete_group"><span class="glyphicon glyphicon-trash"></span></a></td>

            </tr>

        </table>

<div id="test1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

            <div class="modal-dialog">

                <div class="modal-content modalcontent-top">

                    <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>

                        <h3 id="myModalLabel" style="color:white;margin-top:10px">Insert Customer</h3>

                    </div>

                    <div class="modal-body">

                        <form id="customer_model_form">

                            <table class="table" width="60%">

                                <tr>

                                    <td><input type="hidden" name="id" class="id form-control id_update" id="id" value="" readonly="readonly" /></td>

                                </tr>

                                <tr>

                                    <td><strong>Customer Name</strong></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" class="brand form-control form-group mandatory customername borderra0 form-align " data-num="1" name="customer_name" value="" id="customername" maxlength="40" />





                                            <div class="input-group-addon">

                                                <i class="fa fa-user"></i>

                                            </div>

                                        </div>

                                        <span id="cnameerror" class="val field1 " style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>



                                <tr>

                                    <td><strong>Email Address</strong></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" class="brand form-control  form-group   borderra0 form-align emailid" data-num="2" name="email" value="" id="email_address" maxlength="40" />





                                            <div class="input-group-addon">

                                                <i class="fa fa-envelope"></i>

                                            </div>

                                        </div>

                                        <span id="mailerr" class="field2 val" style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>



                                <tr>

                                    <td><strong>Customer Type</strong></td>

                                    <td>

                                        <div class="input-group form-group" style="width:100%;">





                                            <select name="cus_type" id="cus_type" class="form-control  mandatory form-align " data-num="3">

                                                <option value="">Select Customer Type</option>





                                                <option value="1">Regular</option>

                                                <option value="1">Non-Regular</option>



                                            </select>





                                        </div>

                                        <span id="custypeerr" class="field3 val" style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>





                                <tr>

                                    <td><strong>Mobile Number</strong></td>

                                    <td>

                                        <div class="input-group form-group">

                                            <input type="text" class="brand form-control  mandatory   borderra0 form-align " data-num="4" name="mobile_num" value="" id="mobile_num" maxlength="40" />





                                            <div class="input-group-addon">

                                                <i class="fa fa-phone"></i>

                                            </div>

                                        </div>

                                        <span id="mobile_num_err" class="field4 val" style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>





                                <tr>

                                    <td><strong>Address</strong></td>

                                    <td>

                                        <div class="input-group form-group" style="width: 100%;">

                                            <input type="text" class="address form-control  mandatory  borderra0 form-align " data-num="5" name="address" value="" id="address" maxlength="40" />





                                            <!--<div class="input-group-addon">

                                                <i class="fa fa-fa"></i>

                                            </div>-->

                                        </div>

                                        <span id="address_err" class="field5 val" style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>

                                <tr>

                                    <td><strong>GSTIN</strong></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" class="customer_gstin form-control  form-group borderra0 form-align emailid" data-num="6" name="customer_gstin" value="" id="customer_gstin" maxlength="40" />





                                            <div class="input-group-addon">

                                                <i class="fa fa-cog"></i>

                                            </div>

                                        </div>

                                        <span id="gstinerr" class="field6 val" style="color:#F00; font-style:italic;"></span>



                                    </td>

                                </tr>

                            </table>

                        </form>

                    </div>

                    <div class="modal-footer action-btn-align">

                        <button type="button" class="edit btn btn-info1" id="update_customer">Update</button>

                        <button type="reset" class="btn btn-danger1 " id="model_discard" data-dismiss="modal"> Discard</button>

                    </div>

                </div>

            </div>

        </div>



        





        <form method="post" class="panel-body" id="quotation">

            <div class="row" id="add_sales">

                <div class="col-md-4">

                    <?php if (count($firms) > 0) { ?>

                        <div class="form-group">

                            <label class="col-sm-4 control-label">Shop Name</label>

                            <div class="col-sm-8">

                                <select onchange="Firm(this.value, 0)" name="quotation[firm_id]" class="form-control form-align required" id="firm" tabindex="1">

                                    <option value="">Select</option>

                                    <?php
                                    if (isset($firms) && !empty($firms)) {



                                        foreach ($firms as $key => $firm) {

                                            if ($key == 0) {

                                                $select = "selected=selected";
                                            } else {

                                                $select = '';
                                            }
                                    ?>

                                            <option <?php echo $select; ?> value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>

                                    <?php
                                        }
                                    }
                                    ?>
                                </select>

                                <span class="error_msg"></span>

                            </div>

                        </div>

                    <?php
                    } else {
                    ?>

                        <select onchange="Firm(this.value)" name="quotation[firm_id]" class="form-control form-align required" id="firm" readonly="" style="display:none;">

                            <?php
                            if (isset($firms) && !empty($firms)) {



                                foreach ($firms as $firm) {
                            ?>

                                    <option value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>

                            <?php
                                }
                            }
                            ?> </select>

                    <?php } ?>

                    <div class="form-group dnone">

                        <label class="col-sm-4 control-label">Customer Mobile </label>

                        <div class="col-sm-8">

                            <input type="hidden" tabindex="-1" name="customer[mobil_number]" id="customer_no" class="form-control form-align" />

                            <span class="error_msg"></span>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-4 control-label">Customer Name </label>

                        <div class="col-sm-8">

                            <input type="text" tabindex="2" name="customer[store_name]" id="customer_name" class='form-control form-align auto_customer'/>

                            <span class="error_msg"></span>

                            <input type="hidden" name="customer[id]" id="customer_id" class='id_customer  form-align' />

                            <!--<input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->

                            <div id="suggesstion-box" class="auto-asset-search "></div>





                        </div>





                    </div>

                    <input type="hidden" name="quotation[delivery_status]" value="delivered" id="delivery_status" tabindex="3">


                    <div class="form-group">

                        <label class="col-sm-4 control-label">Sales Man</label>

                        <div class="col-sm-8">

                            <select name='quotation[sales_man]' tabindex="4" class="form-control class_req" id="sales_man">

                                <option>Select</option>

                                <?php
                                if (isset($sales_man) && !empty($sales_man)) {

                                    foreach ($sales_man as $val) {
                                ?>

                                        <option value='<?php echo $val['id'] ?>' <?php
                                                                                    if ($val['id'] == 1) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $val['sales_man_name'] ?></option>

                                <?php
                                    }
                                }
                                ?>

                            </select>

                            <span class="error_msg"></span>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <?php if (count($firms) > 1) { ?>

                        <div class="form-group">

                            <label class="col-sm-4 control-label">Invoice Number</label>

                            <div class="col-sm-8">

                                <input type="text" tabindex="-1" name="quotation[q_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="" id="grn_no">

                            </div>

                        </div>

                    <?php } else {
                    ?>

                        <input type="hidden" tabindex="-1" name="quotation[q_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="" id="grn_no">

                    <?php } ?>

                    <div class="customer_details_invoice"><label id="customer_details_label"></label></div>

                    <div class="form-group dnone">

                        <label class="col-sm-4 control-label">Customer Email ID</label>

                        <div class="col-sm-8">

                            <div id='customer_td'>

                                <input type="hidden" tabindex="-1" name="customer[email_id]" id="email_id" class="form-control form-align " />

                                <span class="error_msg"></span>

                            </div>

                        </div>

                    </div>

                    <div class="form-group dnone">

                        <label class="col-sm-4 control-label">Customer Address</label>

                        <div class="col-sm-8">

                            <textarea name="customer[address1]" tabindex="-1" id="address1" class="form-control form-align" style="display: none; "></textarea>

                            <span class="error_msg"></span>

                        </div>

                    </div>



                </div>

                <div class="col-md-4">

                    <input type="hidden" name="sales_id" class="code form-control colournamedup  form-align" value="" id="sales_id">
                    <input type="hidden" name="invoice_id" class="code form-control colournamedup  form-align" value="" id="invoice_id">

                    <div class="form-group">

                        <label class="col-sm-4 control-label">GSTIN NO </label>

                        <div class="col-sm-8">

                            <input type="text" name="customer[tin]" id="tin" tabindex="5" class="form-control form-align " />
                            <span id="gstin_err" class="error_msg"></span>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-4 control-label first_td1">Bill Type <span style="color:#F00; font-style:oblique;">*</span></label>

                        <div class="col-sm-8">

                            <!--                            <input type="radio" class="receiver" id="bill1" value="cash" name="cashbill"/>Cash sale

                            <input type="radio" class="receiver" id="bill2" value="credit" name="quotation[bill_type]"/>Credit sale-->

                            <input type="radio" tabindex="6" class="receiver" id="bill1" value="cash" name="quotation[bill_type]" checked /> &nbsp;Cash Sale

                            <input type="radio" tabindex="6" class="receiver" id="bill2" value="credit" style="margin-left:25px;" name="quotation[bill_type]" /> &nbsp;Credit Sale<br>

                            <span id="type1" class="error_msg"></span>

                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-4 control-label">Date <span style="color:#F00; font-style:oblique;">*</span></label>

                        <div class="col-sm-8">

                            <input type="text" tabindex="7" class="form-control form-align datepicker required" name="quotation[created_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>">

                            <span class="error_msg"></span>

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-4 control-label">IMEI Detection <span style="color:#F00; font-style:oblique;"></span></label>

                        <div class="col-sm-8">

                            <div class="input-group">



                                <input type="text" tabindex="8" name="bar_code_detection" maxlength="15" class="bar_code_detection  form-align" id="bar_code_detection" autocomplete="off">



                                <div class="input-group-addon">



                                    <a href="javascript:"> <i class="fa fa-barcode" onclick="ime_code_scan()"></i></a>



                                </div>



                            </div>







                        </div>



                    </div>

                </div>

            </div>

            <input type="hidden" name="customer[credit_limit]" id="credit_limit" value="">

            <input type="hidden" name="customer[credit_days]" id="credit_days" value="">

            <input type="hidden" name="customer[temp_credit_limit]" id="temp_credit_limit" value="">

            <input type="hidden" name="cus_type" id="cus_type" value="">

            <div class="mscroll">

                <table class="table  table-bordered responsive dataTable no-footer dtr-inline text-center" id="add_quotation">

                    <thead>

                        <tr>

                            <td width="3%" class="first_td1">S.No</td>

                            <!--<td width="15%" class="first_td1">Category</td>-->

                            <td width="20%" class="first_td1">Product Name</td>

                            <td width="15%" class="first_td1">IMEI Code</td>

                            <!--<td width="25%" class="first_td1">Model No</td>-->

                            <!--<td width="10%" class="first_td1">Brand</td>-->

                            <!--<td width="5%" class="first_td1">Unit</td>-->

                            <td width="10%" class="first_td1 action-btn-align">QTY <span style="color:#F00; font-style:oblique;">*</span></td>

                            <td width="8%" class="first_td1 action-btn-align">Sales Price <span style="color:#F00; font-style:oblique;">*</span></td>

                            <!-- <td  width="6%" class="first_td1 action-btn-align">Total</td>-->

                            <td width="6%" class="first_td1 action-btn-align">HSN Code</td>

                            <!--<td  width="7%" class="first_td1 action-btn-align">Discount %</td>-->

                            <td width="5%" class="first_td1 action-btn-align cgst_td">CGST %</td>

                            <td width="5%" class="first_td1 action-btn-align sgst_td">SGST %</td>

                            <td width="5%" class="first_td1 action-btn-align igst_td">IGST %</td>

                            <td width="8%" class="first_td1">Net Value</td>

                            <td width="5%" class="action-btn-align">

                                <a id='add_group' class="btn btn-success form-control padd2"><span class="glyphicon glyphicon-plus"></span></a>

                            </td>

                        </tr>

                    </thead>

                    <tbody id='app_table'>

                        <tr>

                            <td class="action-btn-align s_no">

                                <?php echo 1; ?>

                            </td>


                            <td style="display:none">


                            </td>

                            <td style="display:none">


                            </td>


                            <td>

                                <input type="text" name="model_no[]" id="model_no" tabindex="10" style="width:100%; font-weight: 600;" class='form-align auto_customer tabwid model_no required' readonly="" />

                                <!--<input type="text" name="model_no[]" id="model_no" tabindex="1" style="width:100%; font-weight: 600;" class='form-align auto_customer tabwid model_no required'  readonly="" />-->

                                <span class="error_msg"></span>

                                <input type="hidden" name="product_id[]" id="product_id" class='product_id tabwid form-align' />

                                <input type="hidden" value="" id="product_cost" />

                                <input type="hidden" name="type[]" id="type" class=' tabwid form-align type' />

                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>

                            </td>



                            <td>



                                <div class="ime_code_select">

                                    <div tabindex="11">





                                        <select id="ime_code_id" class="form-control multi_select ime_code_id " required multiple="multiple" autocomplete="off" name="ime_code_id[]">



                                            <option>Select</option>





                                        </select>



                                    </div>



                                </div>

                                <input type="hidden" name='ime_code_val[]' style="width:70px;" class="ime_code_val required" id="ime_code_vals" />

                                <span class="error_msg ime_code_error"></span>

                            </td>





                            <td style="display: none;">

                                <select id='cat_id' class='cat_id static_style  form-control form-align' style="display: none;" name='categoty[]'>

                                    <option value="">Select</option>

                                </select>

                            </td>



                            <input type="hidden" tabindex="-1" name='unit[]' style="width:70px;" class="unit" value="" />

                            <!--<td class="action-btn-align">

                                <input type="hidden"  style="width:100%"  class='form-align tabwid model_no_extra' readonly="" />

                                <input type="text" tabindex="-1" name='unit[]' style="width:70px;" class="unit" />

                            </td>-->

                            <td class="action-btn-align">

                                <select name='brand[]' tabindex="-1" class="form-control form-align brand_id" style="display: none;">

                                    <option value="">Select</option>

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

                                <div class="col-xs-8">

                                    <input type="text" tabindex="12" name='quantity[]' style="width:70px;" class="qty required quantity" data-stock="0"/>

                                </div>





                                <div class="col-xs-4">

                                    <span class="label label-success stock_qty"> 0 </span></div>

                                <span class="error_msg"></span>

                            </td>

                            <td class="action-btn-align">

                                <input type="text" tabindex="13" name='per_cost[]' style="width:70px;" class="selling_price percost required" />
                                <input type="hidden" name="sp_with_gst[]" class="sp_with_gst">
                                <input type="hidden" name="sp_without_gst[]" class="sp_without_gst">

                                <span class="error_msg"></span>

                            </td>


                            <td class="action-btn-align">



                                <input type="text" tabindex="14" style="width:75px;" class="hsn_code" readonly="readonly" autocomplete="off" />



                            </td>

                            <td class="action-btn-align cgst_td">

                                <input type="text" name='tax[]' tabindex="15" style="width:70px;" class="pertax" readonly="readonly" />

                            </td>

                            <td class="action-btn-align sgst_td">

                                <input type="text" name='gst[]' tabindex="16" style="width:70px;" class="gst" readonly="readonly" />

                            </td>

                            <td class="action-btn-align igst_td">

                                <input type="text" name='igst[]' tabindex="17" style="width:70px;" class="igst wid50" readonly="readonly" />

                            </td>

                            <td>

                                <input type="text" style="width:100px;" tabindex="18" name='sub_total[]' readonly="readonly" class="subtotal text_right" />

                            </td>

                            <td class="action-btn-align"><a id='delete_group' tabindex="-1" class="btn btn-danger delete_group"><span class="glyphicon glyphicon-trash"></span></a></td>

                        </tr>

                    </tbody>



                    <tbody class="addtional">

                        <tr>

                            <td colspan="3" style="width:100%; text-align:right;"><b>Total</b></td>

                            <td class="action-btn-align"><input type="text" tabindex="20" name="quotation[total_qty]" readonly="readonly" class="total_qty" style="width:70%;" id="total" /></td>

                            <td colspan="4" style="text-align:right;"><b>Sub Total</b></td>

                            <td class="action-btn-align"><input type="text" name="quotation[subtotal_qty]" tabindex="21" readonly="readonly" class="final_sub_total text_right" style="width:100px;" /></td>

                            <td></td>

                        </tr>

                        <input type="hidden" name="advance" tabindex="-1" id="advance" readonly="readonly" class="advance text_right" style="width:100px;" />



                        <tr>

                            <td colspan="5" style="width:70px; text-align:right;"></td>

                            <td colspan="3" style="text-align:right;font-weight:bold;"><input type="text" tabindex="22" name="quotation[tax_label]" class='tax_label text_right' style="width:100%;" /></td>

                            <td>

                                <input type="text" name="quotation[tax]" class='totaltax text_right' tabindex="23" style="width:100px;" />

                            </td>

                            <td></td>

                        </tr>
                        <input type="hidden" name="quotation[round_off]" tabindex="-1" value="" class="round_off text_right" style="width:100px;" readonly="" />


                    </tbody>

                    <input type="hidden" name="quotation[transport]" value="0" class="transport text_right" tabindex="-1" style="width:70px;" />

                    <tbody class="additional" id="add_new_values">

                        <tr>

                            <input type="hidden" name="quotation[labour]" value="" class="labour text_right" tabindex="-1" style="width:70px;" /></td>

                            <td colspan="2" style="text-align:right;">Taxable Charge</td>

                            <td><input type="text" name="quotation[taxable_price]" value="" readonly class="taxable_price text_right" tabindex="24" style="width:70px;" /></td>

                            <td style="text-align:right;"> CGST </td>

                            <td><input type="text" tabindex="25" value="" name="quotation[cgst_price]" readonly class="add_cgst text_right cgst_price" style="width:100px;" /></td>

                            <td style="text-align:right;" class="sgst_td"> SGST </td>

                            <td style="text-align:right;" class="igst_td"> IGST </td>

                            <td><input type="text" tabindex="26" value="" name="quotation[sgst_price]" readonly class="add_sgst text_right sgst_price" style="width:70px;" /></td>



                            <td colspan="1" style="text-align:right;font-weight:bold;">Net Total</td>



                            <td><input type="text" tabindex="27" name="quotation[net_total]" id="net_total" readonly="readonly" class="final_amt text_right" style="width:100px;" /></td>

                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="9">

                                <label class="">Remarks</label>

                                <input name="quotation[remarks]" tabindex="28" type="text" class="form-control" style="width:90%; display: inline" />

                            </td>

                        </tr>

                    </tbody>


                </table>

            </div>

            <div class="inner-sub-tit mstyle">TERMS AND CONDITIONS</div>

            <div>

                <input type="hidden" class="form-control datepicker class_req borderra0 terms" name="quotation[delivery_schedule]" placeholder="dd-mm-yyyy">

                <input type="hidden" id='to_date' class="form-control datepicker borderra0 terms" name="quotation[notification_date]" placeholder="dd-mm-yyyy">

                <input type="text" tabindex="29" class="form-control class_req borderra0 terms" name="quotation[mode_of_payment]" />

                <input type="hidden" class="form-control class_req borderra0 terms" name="quotation[validity]" />

            </div>

            <input type="hidden" name="quotation[customer]" id="c_id" class='id_customer' />

            <input type="hidden" name="gst_type" id="gst_type" class="gst_type" value="31" />

            <input type="hidden" class='hide_prod' />



            <div class="action-btn-align mb-bot20">

                <button class="btn btn-primary" name="print" value="no" id="save" tabindex="-1"><span class="glyphicon glyphicon-plus"></span>Create</button>

                <button class="btn btn-primary" name="print" value="yes" id="save"><span class="glyphicon glyphicon-plus"></span> Save and <span class="glyphicon glyphicon-print"></span> print</button>

            </div>

            <br />

            <div>

                <input type="hidden" name="" value="0" id="button_clik" />

            </div>

        </form>

    </div>

</div>

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/toastr.min.css" />
<script type='text/javascript' src='<?= $theme_path; ?>/js/toastr.min.js'></script>

<script type="text/javascript">
    $('#customer_gstin').on('blur', function() {
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
        var gstin_val = $.trim($('#customer_gstin').val());
        if (gstinformat.test(gstin_val)) {

            $('#gstinerr').text('').css('display', 'inline-block');
            $('#gstinerr').text('');
        } else if (gstin_val == '') {
            $('#gstinerr').text('');
        } else {
            $('#gstinerr').text('Enter valid GSTIN').css('display', 'inline-block');
        }
    });




    $('.multi_select').fSelect();



    $('#add_customer_manually').on('click', function(e) {



        //$('#test1').show();

        clear_data();

        $('#test1').modal('toggle');

    });

    $('#model_discard').on('click', function(e) {





        // $('#test1').hide();

        clear_data();

        $('#test1').modal('toggle');

    });



    $('document').ready(function() {

        $('#firm').focus();

        var cus_name = $('#customer_name').val();

        if (cus_name == '')

        {

            $("#app_table input").attr("disabled", false);

        }

    });







    function clear_data() {

        $('#customername').val('');

        $('#email_address').val('');

        $('#cus_type').val('');

        $('#mobile_num').val('');

        $('#address').val('');

        $('#customer_gstin').val('');



    }



    $('#update_customer').on('click', function(e) {

        var m = 0;



        var firm_id = $('#firm').val();

        if (firm_id) {

            $('.mandatory').each(function(i) {

                this_val = $.trim($(this).val());

                this_id = $(this).attr('id');

                num = $(this).attr('data-num');

                this_id_first = "";



                if (this_val.length == 0) {



                    $('.field' + num + '').text('Required Field').css('display', 'inline-block');

                    m++;



                } else {



                    $('.field' + num + '').find('span.val').text('').css('display', 'none');

                }


                if (num == 6 && $.trim(this_val).length > 1) {

                    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

                    if (gstinformat.test($.trim(this_val))) {

                        $('#gstinerr').text('').css('display', 'inline-block');
                        $('#gstinerr').text('');
                    } else {
                        $('#gstinerr').text('Enter valid GSTIN').css('display', 'inline-block');
                        m++;
                    }


                }


                if (num == 2 && this_val.length > 1) {

                    var mail = this_val;


                    var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;



                    if (mail != "" && !efilter.test(mail)) {

                        $('.field2').text('Enter Valid Email').css('display', 'inline-block');

                        m++;

                    } else {


                        $.ajax({
                            url: BASE_URL + "masters/customers/check_duplicate_email",
                            type: 'get',
                            data: {
                                email: mail,
                                firm_id: firm_id
                            },
                            success: function(result)

                            {

                                //  alert(result);

                                if (result != 0) {

                                    $('.field2').text(result).css('display', 'inline-block');

                                    m++;

                                } else {

                                    $('.field2').empty();

                                }



                            }



                        });







                    }

                }



                if (num == 4 && this_val.length > 1) {



                    $.ajax({
                        url: BASE_URL + "masters/customers/check_duplicate_mobile_number",
                        type: 'get',
                        data: {
                            number: this_val,
                            firm_id: firm_id
                        },
                        success: function(result)

                        {

                            //alert(result!=0);

                            if (result != 0) {

                                $('.field4').text(result).css('display', 'inline-block');

                                m++;

                            } else {

                                $('.field4').empty();

                            }



                        }



                    });

                }


            });



            if (m > 0) {

                return false;

            } else {



                var cus_name = $('#customername').val();

                var cus_email = $('#email_address').val();

                var cus_type = $('#cus_type').val();

                var cus_num = $('#mobile_num').val();

                var cus_address = $('#address').val();


                var customer_gstin = $('#customer_gstin').val();





                $.ajax({
                    url: BASE_URL + "masters/customers/add_customers",
                    type: 'post',
                    data: {
                        firm_id: firm_id,
                        cus_name: cus_name,
                        cus_email: cus_email,
                        cus_type: cus_type,
                        cus_num: cus_num,
                        cus_address: cus_address,
                        customer_gstin: customer_gstin
                    },
                    success: function(result)

                    {

                        //alert(result!=0);

                        $.ajax({
                            type: 'POST',
                            data: {
                                cust_id: result,
                                firm_id: firm_id
                            },
                            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
                            success: function(data) {

                                var result = JSON.parse(data);

                                if (result != null && result.length > 0) {

                                    $("#gst_type").val(result[0].state_id);

                                    $("#customer_id").val(result[0].id);

                                    $("#c_id").val(result[0].id);

                                    $("#cus_type").val(result[0].customer_type);

                                    $("#customer_name").val(result[0].store_name);

                                    $("#customer_no").val(result[0].mobil_number);

                                    $("#email_id").val(result[0].email_id);

                                    $("#address1").val(result[0].address1);

                                    $("#tin").val(result[0].tin);

                                    $("#credit_limit").val(result[0].credit_limit);

                                    $("#credit_days").val(result[0].credit_days);

                                    $("#temp_credit_limit").val(result[0].temp_credit_limit);

                                    $("#approved_by").val(result[0].approved_by);

                                    $("#advance").val(result[0].advance);

                                    $("#customer_details_label").html('<span class="label label-success" style="float:right">' + result[0].balance + ' </span>' + result[0].store_name + '<br>' + result[0].address1 + '<br> Email : ' + result[0].email_id + '<br> Mobile : ' + result[0].mobil_number);





                                    if (result[0].customer_type == 1 || result[0].customer_type == 3)
                                        $("#bill1").attr('checked', false);

                                    else if (result[0].customer_type == 2 || result[0].customer_type == 4)
                                        $("#bill2").attr('checked', false);

                                    else
                                        $(".receiver").prop("checked", false);



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

                                        $('#add_quotation').find('tr td.igst_td').hide();

                                    }



                                    clear_data();

                                    $('#test1').modal('toggle');

                                } else {

                                    alert("111");

                                }

                            }

                        });



                    }



                });

                return true;

            }



        }







    });
</script>

<script type="text/javascript">
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

        submitted = true;

        var net_total = $('#net_total').val();

        var credit_limit = $('#credit_limit').val();

        var temp_credit_limit = $('#temp_credit_limit').val();

        var approved_by = $('#approved_by').val();

        var m = 0;

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



        $('.quantity').each(function() {







            var qty = $(this).closest('tr').find('.stock_qty').text();



            this_val = $.trim($(this).val());





            if (Number(this_val) > Number(qty))



            {



                $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');



                m++;



            } else {



                $(this).closest('td').find('.error_msg').text("");



            }



        });





        if (m > 0)

        {

            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)

            }, 500);

            return false;

        }





        if (m == 0)

        {



            var button_clik = $('#button_clik').val();

            if (button_clik == 0)

            {

                var button_clik = 1;

                $('#button_clik').val(button_clik);

                return true;

            } else {

                return false;

            }



        }



        //        else if ((Number(net_total) > Number(credit_limit)) && (Number(temp_credit_limit) == ''))

        //        {

        //            $.ajax({

        //                type: "POST",

        //                url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/send_notification/",

        //                data: 'exceed_total=' + $("#net_total").val() + '&credit_limit=' + $("#credit_limit").val() + ' &cust_id=' + $('#customer_id').val(),

        //                success: function (response) {

        //                    if (response == 'sent')

        //                    {

        //                        sweetAlert("Error...", "Credit Limit Exceeded Please Contact your Admin!", "error");

        //

        //                    }

        //                }

        //            });

        //

        //            $('html, body').animate({

        //                scrollTop: ($('.error_msg:visible').offset().top - 60)

        //            }, 500);

        //            return false;

        //        }

    });



    $(document).ready(function() {



        if ($('#gst_type').val() == '')

        {

            $('#add_quotation').find('tr td.igst_td').hide();

            $('#add_new_values').find('tr td.igst_td').hide();

        }



        $('#firm').trigger('change');



        $('body').on('keydown', 'input#customer_name', function(e) {

            var firm_id = $('#firm').val();

            var c_data = [<?php echo implode(',', $customers_json); ?>];

            // console.log(c_data);



            $("#customer_name").blur(function() {

                var keyEvent = $.Event("keydown");

                keyEvent.keyCode = $.ui.keyCode.ENTER;

                $(this).trigger(keyEvent);

                // Stop event propagation if needed

                return false;

            }).autocomplete({
                source: function(request, response) {

                    // filter array to only entries you want to display limited to 10

                    /* var outputArray = new Array();

                     // var nodata = new Array({"id":"0","value":"No Data"});

                     for (var i = 0; i < c_data.length; i++) {

                     if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {

                     //console.log(c_data[i]);

                     outputArray.push(c_data[i]);

                     }

                     }



                     if (outputArray.length == 0) {

                     var nodata = 'Add new Customer';

                     outputArray.push(nodata);

                     }



                     response(outputArray.slice(0, 10));*/



                    $.ajax({
                        type: 'POST',
                        data: {
                            firm_id: $('#firm').val()
                        },
                        url: "<?php echo $this->config->item('base_url'); ?>" + "sales/get_customer_by_firm/",
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

                                var nodata = 'Add new Customer';

                                outputArray.push(nodata);

                            }

                          


                            response(outputArray.slice(0, 10));



                        }



                    });



                },
                minLength: 0,
                autoFocus: true,
                select: function(event, ui) {



                    if (ui.item.value == "Add new Customer") {

                        clear_data();

                        $('#test1').modal('toggle');

                        return false;



                    } else {

                        $("#app_table input,select").attr("disabled", false);

                        cust_id = ui.item.id;

                        $.ajax({
                            type: 'POST',
                            data: {
                                cust_id: cust_id,
                                firm_id: firm_id
                            },
                            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
                            success: function(data) {

                                var result = JSON.parse(data);

                                if (result != null && result.length > 0) {

                                    $("#gst_type").val(result[0].state_id);

                                    $("#customer_id").val(result[0].id);

                                    $("#c_id").val(result[0].id);

                                    $("#cus_type").val(result[0].customer_type);

                                    $("#customer_name").val(result[0].store_name);

                                    $("#customer_no").val(result[0].mobil_number);

                                    $("#email_id").val(result[0].email_id);

                                    $("#address1").val(result[0].address1);

                                    $("#tin").val(result[0].tin);

                                    $("#credit_limit").val(result[0].credit_limit);

                                    $("#credit_days").val(result[0].credit_days);

                                    $("#temp_credit_limit").val(result[0].temp_credit_limit);

                                    $("#approved_by").val(result[0].approved_by);

                                    $("#advance").val(result[0].advance);

                                    $("#customer_details_label").html('<span class="label label-success" style="float:right">' + result[0].balance + ' </span>' + result[0].store_name + '<br>' + result[0].address1 + '<br> Email : ' + result[0].email_id + '<br> Mobile : ' + result[0].mobil_number);

                                    //                                if (result[0].customer_type == 1 || result[0].customer_type == 3)

                                    //                                    $("#bill1").attr('checked', 'checked');

                                    //                                else if (result[0].customer_type == 2 || result[0].customer_type == 4)

                                    //                                    $("#bill2").attr('checked', 'checked');

                                    //                                else

                                    //                                    $(".receiver").prop("checked", false);



                                    if (result[0].customer_type == 1 || result[0].customer_type == 3)
                                        $("#bill1").attr('checked', false);

                                    else if (result[0].customer_type == 2 || result[0].customer_type == 4)
                                        $("#bill2").attr('checked', false);

                                    else
                                        $(".receiver").prop("checked", false);





                                    $("#bill1").attr('checked', 'checked');



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

                                        $('#add_quotation').find('tr td.igst_td').hide();

                                    }

                                } else {

                                    alert("111");

                                }

                            }

                        });

                    }





                    var prod_array = new Array();

                    $(".product_id").each(function() {



                        prod_array.push($(this).val());

                    });

                    //if (!empty(prod_array)) {

                    $.ajax({
                        type: 'POST',
                        data: {
                            cust_id: cust_id,
                            prod_array: prod_array
                        },
                        url: "<?php echo $this->config->item('base_url'); ?>" + "sales/get_product_cost/",
                        success: function(data) {

                            var result = JSON.parse(data);



                            if (data != null && result.length > 0) {

                                $('input#product_cost').each(function(i) {

                                    if (i != 0) {

                                        var product_id = '';

                                        product_id = $(this).closest('tr').find('input#product_id').val();

                                        var qty = '';

                                        qty = $(this).closest('tr').find('input.qty').val();

                                        if (qty == '') {

                                            $(this).closest('tr').find('input.selling_price').val(result[product_id].selling_price);

                                            $(this).closest('tr').find('input.subtotal').val('');

                                            $(this).closest('tr').find('input.gross').val('');

                                        } else {

                                            $(this).closest('tr').find('input.selling_price').val(result[product_id].selling_price);

                                            $(this).closest('tr').find('.qty').trigger('keyup');

                                            //                                            var price = result[product_id].selling_price * qty;

                                            //                                            $(this).closest('tr').find('input.selling_price').val(price);

                                        }

                                    }

                                });

                            }

                        }

                    });

                    //}

                }

            });

        });

    });

    $('#add_group').click(function() {



        var tableBody = $(".static").find('tr').clone();

        $(tableBody).closest('tr').find('.model_no,.percost,.qty').addClass('required');

        var cus_name = $('#customer_name').val();

        if (cus_name == '')

        {

            $(tableBody).closest('tr').find('select,input').attr("disabled", false);

        }

        $('#app_table').append(tableBody);



        $('#add_quotation tbody tr td:nth-child(2)').addClass('relative');

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

            $('#add_quotation').find('tr td.igst_td').hide();

        }



        var i = 1;

        $('#app_table tr').each(function() {

            $(this).closest("tr").find('.s_no').html(i);

            $("#app_table").find('tr:last td input.model_no').focus();

            $(this).closest("tr").find('.s_no').html(i);







            i++;

        });

        $('table#add_quotation').find("tbody#app_table").find('tr:last td:nth-child(2) input').focus();

    });

    $('#add_group_service').click(function() {

        var tableBody = $(".static_ser").find('tr').clone();

        $(tableBody).closest('tr').find('.model_no,.percost,.qty').addClass('required');

        $('#app_table').append(tableBody);

        $('#add_quotation tbody tr td:nth-child(2)').addClass('relative');

    });

    $(document).on('click','.delete_group', function() {

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







    $(".datepicker").datepicker({
        setDate: new Date(),
        onClose: function() {



            $("#app_table").find('tr:first td  input.model_no').focus();



        }



    });



    $(document).ready(function() {



        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false



        });



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
    function checkAvailable(term) {



        var product_data = [<?php echo implode(',', $model_numbers_json); ?>];



        var length = term.length,
            chck = false,
            term = term.toLowerCase();



        for (var i = 0, z = product_data.length; i < z; i++)
            if (product_data[i].substring(0, length).toLowerCase() === term)
                return true;



        return false;



    }
</script>



<script>
    // $(document).ready(function () {



    $('body').on('keydown', '#add_quotation input.model_no', function(e) {



        var _this = $(this);







        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];



        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function(request, response) {







                var val = _this.closest('tr input.model_no').val();



                cat_id = $('#firm').val();



                cust_id = $('#customer_id').val();



                var product_data = [];



                if ($.trim(val).length != 0) {



                    $.ajax({
                        type: 'POST',
                        data: {
                            firm_id: cat_id,
                            pro: val
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



                leng = product_data.length;



                for (var i = 0; i < leng; i++) {



                    //if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {



                    outputArray.push(product_data[i]);



                    // }



                }
                if (outputArray.length == 0) {
                    var nodata = 'Plesae Purchase Product';
                    outputArray.push(nodata);
                }


                response(outputArray.slice(0, 10));



            },
            //  position: {collision: "flip"},



            minLength: 0,
            autoFocus: true,
            select: function(event, ui) {



                this_val = $(this);







                product = ui.item.value;



                $(this).val(product);



                model_number_id = ui.item.id;



                cat_it = ui.item.category_id;



                $.ajax({
                    type: 'POST',
                    data: {
                        model_number_id: model_number_id,
                        c_id: cust_id,
                        firm_id: $('#firm').val(),
                        cat_it: cat_it
                    },
                    url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/",
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



                                //alert(datas);

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



                            }



                            calculate_function();

                            this_val.closest('tr').find('.igst').val(result[0].igst);



                            class_name = this_val.closest('tr').attr('class');

                            product_id = this_val.closest('tr').find('.product_id').val();





                            // set_ime_code_from_pro_id(product_id,1,class_name);



                            var name = $('#app_table tr:last').find('.model_no').val();



                            if (name != '')
                                $('#add_group').trigger('click');



                            //                            this_val.closest('tr').find('.qty').val(1);



                            //                            this_val.closest('tr').find('.qty').trigger('keyup');









                            this_val.closest('tr').find('.qty').focus();



                            this_val.closest('tr').find('.qty').attr('tabindex', '');



                            this_val.closest('tr').find('.percost').attr('tabindex', '');



                        }



                    }



                });



            }



        });







    });



    // });











    $(document).ready(function() {



        $('body').on('keydown', 'input.model_no_extra', function(e) {



            //  var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];



            var product_data = [];



            cat_id = $('#firm').val();



            cust_id = $('#customer_id').val();



            $.ajax({
                type: 'POST',
                data: {
                    firm_id: cat_id
                },
                url: '<?php echo base_url(); ?>quotation/get_model_no_by_frim_id',
                async: false,
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

                                    this_val.closest('tr').find('.qty').attr('data-stock', result[0].quantity);



                                } else {



                                    this_val.closest('tr').find('.stock_qty').html('0');

                                    this_val.closest('tr').find('.qty').attr('data-stock', 0);



                                }



                                this_val.closest('tr').find('.unit').val(result[0].unit);



                                this_val.closest('tr').find('.brand_id').val(result[0].brand_id);



                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);



                                //this_val.closest('tr').find('.discount').val(result[0].discount);



                                this_val.closest('tr').addClass('tr_' + result[0]['id']);





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



    $("#model_no_ser").on('keyup', function() {



        var this_ = $(this);



        // cat_id = this_.closest('tr').find('.cat_id').val();



        cat_id = $('#firm').val();



        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service/" + cat_id,
            data: 's=' + $(this).val(),
            success: function(datas) {



                if (datas) {



                    this_.closest('tr').find(".suggesstion-box1").show();



                    this_.closest('tr').find(".suggesstion-box1").html(datas);



                } else {



                    this_.closest('tr').find(".suggesstion-box1").hide();



                    $(this).val('NO DATA FOUND');



                }



            }



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



    function Firm(val, cat) {



        if (val != '') {



            $('#customer_name').val('');



            $('#customer_details_label').val('');

            $('#tin').val('');



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



                        $('.model_no').removeAttr('readonly', 'readonly');



                        if (cat != '') {



                            $('.cat_id').val(cat);



                        }



                    } else {



                        $('.cat_id,.model_no,.model_no_extra').val('');



                        $('.model_no').attr('readonly', 'readonly');



                    }



                }



            });



            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                    firm_id: val
                },
                url: '<?php echo base_url(); ?>quotation/get_prefix_by_frim_id/',
                success: function(data1) {



                    $('#grn_no').val(data1[0]['prefix']);



                    $('#sales_id').val(data1[0]['prefix']);



                    $('#invoice_id').val(data1[0]['prefix']);



                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            type: data1[0]['prefix'],
                            code: 'TT'
                        },
                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
                        success: function(data2) {



                            $('#grn_no').val(data2);



                            $('#sales_id').val(data2);



                            $('#invoice_id').val(data2);



                            //  console.log($('#sales_id').val());
                            //   console.log($('#grn_no').val());


                            var increment_id = $('#grn_no').val().split("/");



                            var increment_id1 = $('#sales_id').val().split("/");



                            var increment_id2 = $('#invoice_id').val().split("/");



                            final_id = data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];



                            sales_id = 'SL-' + data1[0]['prefix'] + '-' + increment_id1[1] + '-' + increment_id1[2];



                            inv_id = 'INV-' + data1[0]['prefix'] + '-' + increment_id2[1] + '-' + increment_id2[2];



                            $('#sales_id').val(sales_id);



                            $('#grn_no').val(final_id);



                            $('#grn_no_2').text(final_id);



                            $('#invoice_id').val(inv_id);



                        }



                    });



                }



            });



            $.ajax({
                type: 'POST',
                async: false,
                //   dataType: 'JSON',



                data: {
                    firm_id: val
                },
                url: '<?php echo base_url(); ?>quotation/get_reference_group_by_frim_id/',
                success: function(data1) {



                    // $('#ref_class').html('');



                    var result = JSON.parse(data1);



                    if (result != null && result.length > 0) {



                        option_text = '<option value="">Select</option>';



                        $.each(result, function(key, value) {



                            option_text += '<option value="' + value.user_id + '">' + value.user_name + '</option>';



                        });



                        $('#ref_class').html(option_text);



                    } else {



                        $('#ref_class').html('');



                    }



                }



            });



            $.ajax({
                type: 'POST',
                async: false,
                // dataType: 'JSON',



                data: {
                    firm_id: val
                },
                url: '<?php echo base_url(); ?>quotation/get_sales_man_by_frim_id/',
                success: function(data1) {



                    // $('#sales_man').html('');



                    var result = JSON.parse(data1);



                    if (result != null && result.length > 0) {



                        option_text = '<option value="">Select</option>';



                        $.each(result, function(key, value) {



                            option_text += '<option selected="true" value="' + value.id + '">' + value.sales_man_name + '</option>';



                        });



                        $('#sales_man').html(option_text);



                    } else {



                        $('#sales_man').html('');



                    }



                }



            });



        } else {



            $('.cat_id,.model_no,.model_no_extra').val('');



            $('.model_no').attr('readonly', 'readonly');



        }







    }





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





        if (Number(pro_qty) > Number(stock_qty))

        {



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

            toastr.error("IME code field is required", 'Warning Message.!');

            return false;

        } else if ((!($.isNumeric(bar_code))) && bar_code.length < 15) {

            toastr.clear();

            toastr.error("Invalid IME Code", 'Warning Message.!');

            return false;

        } else if (barcode != '' && cust_id != '') {



            var ime = 0;

            $('#app_table .ime_code_id').each(function() {



                hidden_ime = $(this).val();



                if (hidden_ime != "null") {

                    if (jQuery.inArray(barcode, hidden_ime) != '-1') {

                        toastr.clear();

                        toastr.error("IME Code Alreday Added", 'Warning Message.!');

                        ime++;

                        $(this).closest("td").find('.ime_code_error').text("IME Cdoe Alreday Added");



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
                        cust_id: cust_id
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



                                if (jQuery.inArray(value.id, prod_array) > -1 && prod_array.length > 0)

                                {



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



                                    // $(tableBody).closest('tr').find('.selling_price').val(result[0]['sales_price_without_gst']);
                                    $(tableBody).closest('tr').find('.sp_with_gst').val(result[0]['sales_price']);
                                    $(tableBody).closest('tr').find('.selling_price').val(result[0]['sales_price']);
                                    $(tableBody).closest('tr').find('.sp_without_gst').val(result[0].sales_price_without_gst);


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

                                            $(tableBody).closest('tr').find('.gst').hide();

                                            $(tableBody).closest('tr').find('.igst').val(result[0]['igst']);



                                        }



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







    $(window).bind('scannerDetectionReceive', function(event, data) {



        target_ele = event.target.activeElement;



    });





    $('input').on('keypress', function() {



        formHasChanged = true;



    });



    $('select').on('click', function() {



        formHasChanged = true;



    });


    $(document).keydown(function(e) {



        var keycode = e.keyCode;



        if (keycode == 113) {



            $('#add_group').trigger('click');



        }



    });
</script>