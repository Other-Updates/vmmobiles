<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery.scannerdetection.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
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
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
    }
    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
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
    .auto-asset-search ul#service-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    ul li {
        list-style-type: none;
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
            <h4>Update Quotation</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td class="action-btn-align s_no"></td>
                <td>
                    <select id='cat_id' tabindex="-1"  class='form-align cat_id static_style class_req form-control' style="width:100%" name='categoty[]' >
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
                    <input type="hidden"   style="width:100%"  class='form-align form-control tabwid model_no_extra'/>
                </td>
                <td style="display:none;">

                </td>
                <td>
                    <input type="text" tabindex="9" name="model_no[]" id="model_no" style="width:100%" class='form-align auto_customer tabwid model_no'   />
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden" value="" id="product_cost"/>
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <select tabindex="-1" name='brand[]' class="form-align brand_id class_req form-control"  >
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
                <td class="action-btn-align">
                    <input type="text"  tabindex="-1"   name='unit[]' style="width:70px;" class="unit" />
                    <span class="error_msg"></span>
                </td>
                <td>
                    <div class="col-xs-4">
                        <input type="text"  tabindex="9"   name='quantity[]' style="width:70px;" class="qty " id="qty"/></div>
                    <div class="col-xs-2" style="margin-top:6px; margin-left: 15px;"> <span class="label label-success stock_qty" > 0 </span></div>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"  tabindex="9"   name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td class="action-btn-align">
                    <input type="text"  tabindex="-1"   style="width:70px;" class="gross" />
                </td>
                <td>
                    <input type="text"   tabindex="-1"   name='discount[]' style="width:70px;" class="discount" />
                </td>
                <td class="action-btn-align cgst_td">
                    <input type="text"  tabindex="-1"    name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td class="action-btn-align sgst_td">
                    <input type="text"   tabindex="-1"   name='gst[]' style="width:70px;" class="gst" />
                </td>
                <td class="action-btn-align igst_td">
                    <input type="text"  tabindex="-1"    name='igst[]' style="width:70px;" class="igst wid50"  />
                </td>
                <td>
                    <input type="text" tabindex="-1"   style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="btn-sm btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>


        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url'); ?>quotation/update_quotation/<?php echo $val['id']; ?>" method="post" class=" panel-body">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Firm Name</label>
                                <div class="col-sm-8">
                                    <select name="quotation[firm_id]" onchange="Firm(this.value)" tabindex="1" class="form-control form-align required" id="firm" >
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
                                <label class="col-sm-4 control-label">Customer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" tabindex="2"  name="customer[store_name]" id="customer_name"  class='auto_customer form-align required form-control' value="<?php echo $val['store_name']; ?>"  />

                                    <span class="error_msg"></span>
                                    <div id="suggesstion-box" class="auto-asset-search"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Customer Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" tabindex="3" name="customer[mobil_number]" class="form-control form-align" id="customer_no" value="<?php echo $val['mobil_number']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Quotation NO</label>
                                <div class="col-sm-8">
                                    <input type="text" tabindex="-1"  name="quotation[q_no]" class=" form-control colournamedup form-align" readonly="readonly" value="<?php echo $val['q_no']; ?>"  id="grn_no">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Customer Email ID</label>
                                <div class="col-sm-8" id='customer_td'>
                                    <input type="text" tabindex="-1" name="customer[email_id]" class="form-control form-align" id="email_id" value="<?php echo $val['email_id']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Customer Address</label>
                                <div class="col-sm-8">
                                    <textarea name="customer[address1]" tabindex="-1" class="form-control form-align"  id="address1"><?php echo $val['address1']; ?></textarea>
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Reference Name</label>
                                <div class="col-sm-8">
                                    <input type="hidden"  name="quotation[job_id]"  class="code form-control colournamedup form-align" value="<?php echo $val['job_id']; ?>" id="sales_id">
                                    <td><select id='' tabindex="4" class='nick static_style class_req form-control required'   name='quotation[ref_name]'>
        <!--                                            <option value='<?php echo $val['ref_name'] ?>'><?php echo $val['nick_name'] ?></option>
                                            <?php
                                            if (isset($nick_name) && !empty($nick_name)) {
                                                foreach ($nick_name as $vals) {
                                                    ?>
                                                                                                                                                                                                                        <option value='<?php echo $vals['nick_name'] ?>'><?php echo $vals['nick_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <option value="">Select</option>-->
                                            <?php
                                            if (isset($ref_grps) && !empty($ref_grps)) {
                                                foreach ($ref_grps as $vals) {

                                                    if ($vals['reference_type'] == 1) {
                                                        $user_name = $this->user_model->get_user_name_by_id($vals['user_id']);
                                                    } else if ($vals['reference_type'] == 2) {
                                                        $user_name = $this->customer_model->get_customer_name_by_id($vals['customer_id']);
                                                    } else {
                                                        $user_name = array();
                                                    }
                                                    ?>
                                                    <option  value="<?php echo $vals['id'] ?>"   <?php echo ($val['ref_name'] == $vals['id']) ? 'selected' : '' ?>><?php
                                                        if (count($user_name) > 0) {
                                                            echo $user_name[0]['name'];
                                                        } else {
                                                            echo $vals['others'];
                                                        }
                                                        ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="error_msg"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td">GSTIN NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id='tin' tabindex="5" name="company[tin_no]" class="form-control" value="<?php echo $val['tin']; ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="text"  tabindex="6" class="form-align datepicker form-control required" name="quotation[created_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($val['created_date'])); ?>">
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mscroll">
                        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                            <thead>
                                <tr>
                                    <td width="" class="first_td1">S.No</td>
                                    <td width="15%" class="first_td1">Category</td>
                                    <td width="15%" class="first_td1">Product Name</td>
                                    <td width="10%" class="first_td1">Brand</td>
                                    <td width="" class="first_td1">Unit</td>
                                    <td width="15%" class="first_td1">QTY</td>
                                    <td width="" class="first_td1">Unit Price</td>
                                    <td width="" class="first_td1 ">Total</td>
                                    <td width="" class="first_td1">Discount %</td>
                                    <td width="" class="first_td1 action-btn-align cgst_td">CGST %</td>
                                    <td width="" class="first_td1 action-btn-align sgst_td">SGST %</td>
                                    <td width="" class="first_td1 action-btn-align igst_td">IGST %</td>
                                    <td width="" class="first_td1">Net Value</td>
                                    <td width="" class="action-btn-align">
                                        <a id='add_group' tabindex="8" class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add</a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id='app_table'>
                                <?php
                                if (isset($quotation_details) && !empty($quotation_details)) {
                                    $i = 1;
                                    foreach ($quotation_details as $vals) {
                                        ?>
                                        <tr class="tr_<?php echo $vals['product_id']; ?> quoationdetails">
                                            <td class="action-btn-align s_no">
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <select id='cat_id' tabindex="-1"  class='static_style class_req required form-control' style="width:100%" name='categoty[]' >                                             <?php
                                                    if (isset($category) && !empty($category)) {
                                                        foreach ($category as $va) {
                                                            $select = ($va['cat_id'] == $vals['cat_id']) ? 'selected' : '';
                                                            ?>
                                                            <option value='<?php echo $va['cat_id'] ?>'<?php echo $select; ?>><?php echo $va['categoryName'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error_msg"></span>
                                            </td>
                                            <td  class="relative" style="display:none">

                                            </td>
                                            <td class="relative">
                                                <input type="hidden" style="width:100%" class='form-align tabwid model_no_extra  form-control' value="<?php echo $vals['model_no']; ?>"/>
                                                <input type="text" tabindex="7" name="model_no[]" id="model_no" style="width:100%" class='form-align auto_customer tabwid model_no required form-control'   value="<?php echo $vals['product_name']; ?>"/>
                                                <span class="error_msg"></span>
                                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />
                                                <input type="hidden" value="" id="product_cost"/>
                                                <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>" />
                                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                            </td>
                                            <td>
                                                <select tabindex="-1"  name='brand[]' class="form-align brand_id form-control"  >
                                                    <option value='<?php echo $vals['id'] ?>'> <?php echo $vals['brands'] ?> </option>
                                                    <?php
                                                    if (isset($brand) && !empty($brand)) {
                                                        foreach ($brand as $valss) {
                                                            $select = ($valss['id'] == $vals['brand']) ? 'selected' : '';
                                                            ?>
                                                            <option value='<?php echo $valss['id'] ?>'<?php echo $select; ?>> <?php echo $valss['brands'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span class="error_msg"></span>
                                            </td>
                                            <td class="action-btn-align">
                                                <input type="text"  tabindex="-1"   name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--                                            <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="text"     name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="error_msg"></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </td>-->
                                            <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                                                <td stock_qty="<?php echo $vals['stock'][0]['quantity']; ?>" >
                                                    <input type="hidden"     name='available_quantity[]' style="width:70px;" class="code form-control colournamedup tabwid form-align " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>

                                                    <div class="col-xs-4">   <input type="text"   tabindex="7"  name='quantity[]' style="width:70px;margin-top: 2px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/></div>
                                                    <div class="col-xs-2" style="margin-top:6px; margin-left: 15px;"> <span class="label label-success stock_qty" > <?php echo $vals['stock'][0]['quantity'] ?> </span></div>

                                                    <span class="error_msg"></span>
                                                </td>
                                            <?php } else { ?>
                                                <td stock_qty="0"><div class="avl_qty"></div>
                                                    <div class="col-xs-4">    <input type="text"  tabindex="7"   name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/></div>
                                                    <div class="col-xs-2" style="margin-top:6px; margin-left: 15px;"> <span class="label label-success stock_qty" > 0 </span></div>
                                                    <span class="error_msg"></span>
                                                </td>
                                            <?php } ?>
                                            <td>
                                                <input type="text"  tabindex="7"   name='per_cost[]' style="width:70px;" class="selling_price percost required " value="<?php echo $vals['per_cost'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>
                                            <td class="action-btn-align">
                                                <input type="text"  tabindex="-1"   style="width:70px;" class="gross" />
                                            </td>
                                            <td class="action-btn-align">
                                                <input type="text"  tabindex="-1"    name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount'] ?>" />
                                            </td>
                                            <td class="action-btn-align cgst_td">
                                                <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" />
                                            </td>
                                            <td class="action-btn-align sgst_td">
                                                <input type="text"  tabindex="-1"    name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst'] ?>" />
                                            </td>
                                            <td class="action-btn-align igst_td">
                                                <input type="text"   tabindex="-1"   name='igst[]' style="width:70px;" class="igst wid50"value="<?php echo $vals['igst'] ?>"  />
                                            </td>

                                            <td>
                                                <input type="text" style="width:70px;" tabindex="-1" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>"/>
                                            </td>
                                    <input type="hidden" value = "<?php echo $vals['del_id']; ?>" class="del_id"/>
                                    <td width="2%" class="action-btn-align"><a id='delete_label' tabindex="-1" value = "<?php echo $vals['del_id']; ?>" class="btn-sm btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" style="width:70px; text-align:right;"><b>Total</b></td>
                                    <td><input type="text" tabindex="-1"  name="quotation[total_qty]"  readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                                    <td colspan="4" style="text-align:right;"><b>Sub Total</b></td>
                                    <td><input type="text" name="quotation[subtotal_qty]" tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>
                                    <td colspan="7" style="text-align:right;font-weight:bold;"><input type="text" tabindex="-1"  name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                                    <td>
                                        <input type="text"  name="quotation[tax]" class='totaltax text_right' tabindex="-1"  value="<?php echo $val['tax']; ?>"  style="width:70px;" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>
                                    <td colspan="7"style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td><input type="text" tabindex="-1" name="quotation[net_total]"  readonly="readonly"  class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                                    <td></td>
                                </tr>
                                <tr>

                                    <td colspan="14" style="">
                                        <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                        <input name="quotation[remarks]" tabindex="-1" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>"   />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="inner-sub-tit mstyle">TERMS AND CONDITIONS</div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">1. Delivery Schedule</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input tabindex="-1" type="text"  class="form-control datepicker class_req borderra0 terms"  name="quotation[delivery_schedule]" value="<?php echo ($val['delivery_schedule'] != '1970-01-01') ? $val['delivery_schedule'] : '-'; ?>" placeholder="dd-mm-yyyy" >
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">3. Mode of Payment</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input type="text" tabindex="-1"  class="form-control class_req borderra0 terms"  value="<?php echo ($val['mode_of_payment'] != '') ? $val['mode_of_payment'] : '-'; ?>" name="quotation[mode_of_payment]"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">2. Notification Date</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input type="text" tabindex="-1" id='to_date' class="form-control datepicker borderra0 terms"   name="quotation[notification_date]" value="<?php echo ($val['notification_date'] != '1970-01-01') ? $val['notification_date'] : '-'; ?>" placeholder="dd-mm-yyyy" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">4. Validity</label>
                                <div class="col-sm-8">
                                    <div>
                                        <input type="text" tabindex="-1" class="form-control class_req borderra0 terms"  value="<?php echo ($val['validity'] != '') ? $val['validity'] : '-'; ?>" name="quotation[validity]"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['customer']; ?>"/>
                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>
                    <div class="action-btn-align">


                        <?php if ($val['estatus'] == 2) { ?>

                            <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-info1" tabindex="10" id="save"> Update </button>
                            <a href="<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>" tabindex="-1" class="btn complete"><span class="glyphicon"></span> Complete </a>
                            <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" tabindex="-1" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                        </div>
                    </form>
                    <br />

                    <?php
                }
            }
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    var formHasChanged = false;
    var submitted = false;
    $('#save').live('click', function () {
        m = 0;
        $('.required').each(function () {

            var tr = $('#app_table tr').length;
            if (tr > 1)
            {
                test = $(this).closest('tr td').find('input.model_no').val();
                if (test == '') {
                    $(this).closest('tr').remove();
                }
            }

        });
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr("id");

            if (this_val == "") {
                $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('tr td').find('.error_msg').text('');
                $(this).closest('div .form-group').find('.error_msg').text('');

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

        //$("#quotation").submit();

    });
    $(document).ready(function () {

        var cus_name = $('#customer_name').val();
        if (cus_name == '')
        {
            $("#app_table input").attr("disabled", true);
            $("#app_table select").attr("disabled", true);
        }

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

        $('#firm').focus();
        calculate_function();
        //$('#firm').trigger('change');
        $('body').on('keydown', 'input#customer_name', function (e) {
            var c_data = [<?php echo implode(',', $customers_json); ?>];
            $("#customer_name").blur(function () {
                var keyEvent = $.Event("keydown");
                keyEvent.keyCode = $.ui.keyCode.ENTER;
                $(this).trigger(keyEvent);
                // Stop event propagation if needed
                return false;
            }).autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < c_data.length; i++) {
                        if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(c_data[i]);
                        }
                    }
                    response(outputArray.slice(0, 10));
                },
                minLength: 0,
                autoFocus: true,
                select: function (event, ui) {
                    cust_id = ui.item.id;
                    $.ajax({
                        type: 'POST',
                        data: {cust_id: cust_id},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#gst_type").val(result[0].state_id);
                                $("#customer_id").val(result[0].id);
                                $("#c_id").val(result[0].id);
                                $("#customer_name").val(result[0].store_name);
                                $("#customer_no").val(result[0].mobil_number);
                                $("#email_id").val(result[0].email_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
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
                            }
                        }

                    });


                    var prod_array = new Array();
                    $(".product_id").each(function () {
                        prod_array.push($(this).val());
                    });
                    //if (!empty(prod_array)) {
                    $.ajax({
                        type: 'POST',
                        data: {cust_id: cust_id, prod_array: prod_array},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "sales/get_product_cost/",
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (data != null && data.length > 0) {
                                $('input#product_cost').each(function (i) {
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
                }
            });
        });
    });

    $('#add_group').bind('keypress click', function () {
        var tableBody = $(".static").find('tr').clone();
//        var tab_index = $(".static").find('tr:last td  input.model_no').attr('tabindex');
//        var inc_val = 1;
//        var tab_inc = parseInt(tab_index) + parseInt(inc_val);
        $(tableBody).closest('tr').find('select,.model_no,.percost,.qty').addClass('required');
//        $(".static").find('tr:last td  input.model_no').attr('tabindex', tab_inc);
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
        $('#app_table tr').each(function () {
            $(this).closest("tr").find('.s_no').html(i);
            i++;
        });
    });

    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);

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
    });

    $('#delete_group').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
        var i = 1;
        $('#app_table tr').each(function () {
            $(this).closest("tr").find('.s_no').html(i);
            i++;
        });
    });
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });
    $('.del').live('click', function () {

        var del_id = $(this).closest('tr').find('.del_id').val();

        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/delete_id",
            data: {del_id: del_id
            },
            success: function (datas) {
                calculate_function();

            }
        });

    });

    $(".remove_comments").live('click', function () {
        $(this).closest("tr").remove();
        var full_total = 0;
        $('.total_qty').each(function () {
            full_total = full_total + Number($(this).val());
        });
        $('.full_total').val(full_total);
        console.log(full_total);
    });



    $('.qty,.percost,.pertax,.totaltax,.gst,.igst,.discount').live('keyup', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        $('.qty').each(function () {
            var qty = $(this);
            var percost = $(this).closest('tr').find('.percost');
            var pertax = $(this).closest('tr').find('.pertax');
            var gst = $(this).closest('tr').find('.gst');
            var igst = $(this).closest('tr').find('.igst');
            var subtotal = $(this).closest('tr').find('.subtotal');
            var discount = $(this).closest('tr').find('.discount');
            if (Number(qty.val()) != 0)
            {
                tot = Number(qty.val()) * Number(percost.val());
                $(this).closest('tr').find('.gross').val(tot);
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());
                igst1 = Number(igst.val() / 100) * Number(percost.val());
                discount1 = Number(discount.val() / 100) * Number(percost.val());
                sub_total1 = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()) + (igst1 * Number(qty.val())));
                sub_total = sub_total1 - (discount1 * Number(qty.val()));
                subtotal.val(sub_total.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + sub_total;
            }
        });
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        $('.final_amt').val((final_sub_total + Number($('.totaltax').val())).toFixed(2));
    }

    $(".datepicker").datepicker({
        setDate: new Date(),
        onClose: function () {
            $("#app_table").find('tr:first td  input.model_no').focus();
        }
    });

    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
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
            success: function (result) {
                for_response();
                $('#result_div').html(result);
            }
        });
    });

</script>
<script>

    $('body').on('keydown', '#add_quotation input.model_no', function (e) {
        var _this = $(this);
        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function (request, response) {
                var val = _this.closest('tr input.model_no').val();
                var product_data = [];
                cat_id = $('#firm').val();
                cust_id = $('#customer_id').val();
                if ($.trim(val).length != 0) {
                    $.ajax({
                        type: 'POST',
                        data: {firm_id: cat_id, pro: val},
                        async: false,
                        url: '<?php echo base_url(); ?>quotation/get_product_by_frim_id',
                        success: function (data) {
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
                response(outputArray.slice(0, 10));
            },
            minLength: 0,
            delay: 0,
            autoFocus: true,
            select: function (event, ui) {
                this_val = $(this);
                product = ui.item.value;
                $(this).val(product);
                model_number_id = ui.item.id;
                $.ajax({
                    type: 'POST',
                    data: {model_number_id: model_number_id, c_id: cust_id, firm_id: $('#firm').val()},
                    url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/" + cat_id,
                    success: function (data) {
                        var result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            if (result[0].quantity != null) {
                                this_val.closest('tr').find('.stock_qty').html(result[0].quantity);
                            } else {
                                this_val.closest('tr').find('.stock_qty').html('0');
                            }
                            this_val.closest('tr').find('.unit').val(result[0].unit);
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);

                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
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
                            this_val.closest('tr').find('.qty').focus();
//                            var tab_model = this_val.closest('tr').find('.model_no').attr('tabindex');
//                            this_val.closest('tr').find('.qty').attr('tabindex', tab_model);
//                            this_val.closest('tr').find('.percost').attr('tabindex', tab_model);
//                            var tab_save = parseInt(tab_model) + parseInt(1);
//                            $("#save").attr('tabindex', tab_save);
                        }
                    }
                });
            }
        });
    });


    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no_extra', function (e) {
            //var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];
            var product_data = [];
            cat_id = $('#firm').val();
            cust_id = $('#customer_id').val();
            $.ajax({
                type: 'POST',
                data: {firm_id: cat_id},
                async: false,
                url: '<?php echo base_url(); ?>quotation/get_model_no_by_frim_id',
                success: function (data) {
                    product_data = JSON.parse(data);
                }
            });

            $(".model_no_extra").autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < product_data.length; i++) {
                        if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(product_data[i]);
                        }
                    }
                    response(outputArray.slice(0, 10));
                },
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {
                    this_val = $(this);
                    product = ui.item.value;
                    $(this).val(product);
                    model_number_id = ui.item.id;
                    $.ajax({
                        type: 'POST',
                        data: {model_number_id: model_number_id, c_id: cust_id},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/" + cat_id,
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                this_val.closest('tr').find('.unit').val(result[0].unit);
                                this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);

                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
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


    $("#model_no_ser").live('keyup', function () {
        var this_ = $(this);
        //cat_id = this_.closest('tr').find('.cat_id').val();
        cat_id = $('#firm').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service/" + cat_id,
            data: 's=' + $(this).val(),
            success: function (datas) {
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

    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });

    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand_id').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.pertax').val($(this).attr('pro_cgst'));
        $(this).closest('tr').find('.gst').val($(this).attr('pro_sgst'));
        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    $('.ser_class').live('click', function () {
        $(this).closest('tr').find('.cat_id').val($(this).attr('ser_cat'));
        $(this).closest('tr').find('.pertax').val($(this).attr('ser_cgst'));
        $(this).closest('tr').find('.gst').val($(this).attr('ser_sgst'));
        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_name'));
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "  " + $(this).attr('ser_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    function Firm(val) {
        if (val != '') {
            $.ajax({
                type: 'POST',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select Category</option>';
                        $.each(result, function (key, value) {
                            option_text += '<option value="' + value.cat_id + '">' + value.categoryName + '</option>';
                        });
                        $('.cat_id').html(option_text);
                        $('.cat_id,.model_no,.model_no_extra').val('');
                        $('.model_no,.model_no_extra').removeAttr('readonly', 'readonly');

                    } else {
                        $('.cat_id,.model_no,.model_no_extra').html('');
                        $('.model_no,.model_no_extra').attr('readonly', 'readonly');
                    }
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>quotation/get_prefix_by_frim_id/',
                success: function (data1) {
                    $('#grn_no').val(data1[0]['prefix']);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {type: data1[0]['prefix']},
                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
                        success: function (data2) {
                            $('#grn_no').val(data2);
                            //console.log(data2);
                            var increment_id = $('#grn_no').val().split("/");
                            final_id = data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
                            $('#grn_no').val(final_id);
                            sales_id = 'INV-' + data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
                            $('#sales_id').val(sales_id);
                        }
                    });
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>quotation/get_reference_group_by_frim_id/',
                success: function (data1) {
                    $('#ref_class').html('');
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select</option>';
                        $.each(data1, function (key, value) {
                            option_text += '<option value="' + value.user_id + '">' + value.user_name + '</option>';
                        });
                        $('#ref_class').html(option_text);
                    } else {
                        $('#ref_class').html('');
                    }
                }
            });
        } else {
            $('form')[0].reset();
            $('.cat_id,.model_no,.model_no_extra').html('');
            $('.model_no,.model_no_extra').attr('readonly', 'readonly');
        }
    }

    $(window).bind('scannerDetectionReceive', function (event, data) {
        target_ele = event.target.activeElement;
    });
    /*$(document).scannerDetection({
     timeBeforeScanTest: 200, // wait for the next character for upto 200ms
     startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
     endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
     avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
     onComplete: function (barcode, qty) {
     $(target_ele).val('');
     cust_id = $('#customer_id').val();
     barcode = barcode;
     if (barcode != '') {
     $.ajax({
     type: 'POST',
     async: false,
     data: {barcode: barcode, cust_id: cust_id},
     url: '<?php echo base_url(); ?>sales/get_all_products/',
     success: function (data) {
     result = JSON.parse(data);
     if (result != null && result.length > 0) {
     $.each(result, function (key, value) {
     var prod_array = new Array();
     $(".product_id").each(function () {
     prod_array.push($(this).val());
     });

     if (jQuery.inArray(value.id, prod_array) > -1 && prod_array.length > 0)
     {
     qty_val = $('#app_table .tr_' + value.id).find('.qty').val();
     var add = Number(qty_val) + Number(1);
     $('#app_table .tr_' + value.id).find('.qty').val(add);
     calculate_function();
     } else {

     var tableBody = $(".static").find('tr').clone();
     $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
     $('#app_table').append(tableBody);
     $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);
     if (result[0]['product_image'] == '')
     $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0]['product_image']);
     else
     $(tableBody).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
     $(tableBody).closest('tr').find('.product_description').val(result[0]['product_description']);
     $(tableBody).closest('tr').find('.qty').val('1');
     $(tableBody).closest('tr').addClass('tr_' + result[0]['id']);

     $(tableBody).closest('tr').find('.product_id').val(result[0]['id']);
     $(tableBody).closest('tr').find('.selling_price').val(result[0]['selling_price']);
     $(tableBody).closest('tr').find('.type').val(result[0]['type']);

     $(tableBody).closest('tr').find('.discount').val(result[0]['discount']);
     $(tableBody).closest('tr').find('.brand_id').val(result[0]['brand_id']);
     $(tableBody).closest('tr').find('.unit').val(result[0]['unit']);
     $(tableBody).closest('tr').find('.cat_id').val(result[0]['category_id']);
     $(tableBody).closest('tr').find('.model_no').val(result[0]['product_name']);
     $(tableBody).closest('tr').find('.model_no_extra').val(result[0]['model_no']);
     if ($('#gst_type').val() != '')
     {
     if ($('#gst_type').val() == 31)
     {
     $(tableBody).closest('tr').find('.pertax').val(result[0].cgst);
     $(tableBody).closest('tr').find('.gst').val(result[0].sgst);
     } else {
     $(tableBody).closest('tr').find('.pertax').val(result[0].cgst);
     $(tableBody).closest('tr').find('.igst').val(result[0].igst);

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
     } else {
     sweetAlert("Error...", "This Product is not available!", "error");
     return false;
     }

     }
     });*/
    $('input').on('keypress', function () {
        formHasChanged = true;
    });
    $('select').on('click', function () {
        formHasChanged = true;
    });

//    $('.complete').on('click', function () {
//
//        $('.quoationdetails').each(function () {
//            m = 0;
//            var stock_qty = $(this).find(".stock_qty").html();
//            var this_val = $(this).find(".qty").val();
//
//            if (Number(this_val) > Number(stock_qty))
//            {
//                m = 1;
//            } else {
//                $(this).closest('tr').find('.error_msg').text("");
//            }
//        });
//
//        var s = 0;
//        $('#add_quotation #app_table tr').each(function () {
//            var qty = $(this).find('.qty').val();
//            var stock_qty = parseInt($(this).find('.stock_qty').text());
//
//            if (stock_qty < qty)
//            {
//
//                m == 1;
//                s++;
//            } else
//            {
//                //$(this).closest('td').find('.error_msg').text('');
//                // $(this).closest('td div .form-group').find('.error_msg').text('');
//            }
//
//        });
//
//        if (s > 0) {
//
//            console.log("s: " + s);
//            alert("Qty Should be less than stock Qty");
//            return false;
//        }
//        if (m == 1)
//        {
//            return false;
//        } else
//        {
//            return true;
//        }
//
//    });

    $(window).bind('beforeunload', function () {
        if (formHasChanged && !submitted) {
            return 'Are you sure you want to leave?';
        }

    });
    $(document).keydown(function (e) {
        var keycode = e.keyCode;
        if (keycode == 113) {
            $('#add_group').trigger('click');
        }
    });
</script>
