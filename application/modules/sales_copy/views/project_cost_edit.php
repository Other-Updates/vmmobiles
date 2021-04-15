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
            <h4>Update Sales Order</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td class="action-btn-align s_no"></td>
                <td>
                    <input type="text"  name="model_no[]" id="model_no" style="width:100%;font-weight: 600;" class='form-align auto_customer tabwid model_no' tabindex="1"  />
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td style="display:none;" >
                    <select id='cat_id' tabindex="1" class='form-align cat_id static_style  form-control' style="display:none;" name='categoty[]' >
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
                <td class="action-btn-align">
                    <input type="hidden"   style="width:100%"  class='form-align form-control tabwid model_no_extra'/>
                    <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" />
                </td>
                <td>
                    <select  name='brand[]' class="form-align brand_id class_req form-control" style="display:none;">
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
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text" tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost" id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td class="action-btn-align">
                    <input type="text" tabindex="1"  style="width:70px;" class="gross" />
                </td>
                <td>
                    <input type="text" tabindex="1"  name='discount[]' style="width:70px;" class="discount" />
                </td>
                <td class="action-btn-align cgst_td">
                    <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td class="action-btn-align sgst_td">
                    <input type="text"   tabindex="1"   name='gst[]' style="width:70px;" class="gst" />
                </td>
                <td class="action-btn-align igst_td">
                    <input type="text"   tabindex="1"   name='igst[]' style="width:70px;" class="igst wid50"  />
                </td>
                <td>
                    <input type="text"  style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>


        <?php
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url'); ?>sales/update_project_cost/<?php echo $val['id']; ?>" method="post" class=" panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (count($firms) > 1) { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Firm Name</label>
                                    <div class="col-sm-8">
                                        <select name="quotation[firm_id]" onchange="Firm(this.value)"  class="form-control form-align required" id="firm" tabindex="1">
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
                                <?php
                            } else {
                                ?>
                                <select onchange="Firm(this.value)" name="quotation[firm_id]"  class="form-control form-align required" id="firm" readonly="" tabindex="1" style="display:none;">
                                    <?php
                                    if (isset($firms) && !empty($firms)) {
                                        foreach ($firms as $firm) {
                                            $select = ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '';
                                            ?>
                                            <option value="<?php echo $firm['firm_id']; ?>" <?php echo $select; ?>> <?php echo $firm['firm_name']; ?> </option>
                                            <?php
                                        }
                                    }
                                    ?> </select>
                            <?php } ?>


                            <?php if (count($firms) > 1) { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sales NO</label>
                                    <div class="col-sm-8">
                                        <input type="text"  name="quotation[q_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $val['q_no']; ?>"  id="grn_no">
                                    </div>
                                </div>
                            <?php } else {
                                ?> <input type="hidden"  name="quotation[q_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $val['q_no']; ?>" id="grn_no">
                            <?php } ?>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Name</label>
                                <div class="col-sm-8">
                                    <input type="text"  name="customer[store_name]" id="customer_name" tabindex="1" class='auto_customer form-align required form-control' value="<?php echo $val['store_name']; ?>"  />

                                    <input type="hidden"  name="pc_id" id="pc_id" class='id_customer form-align tabwid' value="<?php echo $val['id']; ?>" />
                                    <span class="error_msg"></span>
                                    <div id="suggesstion-box" class="auto-asset-search"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="customer_details_invoice"><label id="customer_details_label"><?php echo $val['store_name']; ?></br>
                                    <?php echo $val['address1']; ?></br>
                                    <?php echo $val['email_id']; ?></br>
                                    <?php echo $val['mobil_number']; ?>
                                </label></div>


                            <div class="form-group dnone">
                                <label class="col-sm-4 control-label first_td1">Customer Email ID</label>
                                <div class="col-sm-8" id='customer_td'>
                                    <input type="hidden"  name="customer[email_id]" class="form-control form-align" id="email_id" value="<?php echo $val['email_id']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                            <div class="form-group dnone">
                                <label class="col-sm-4 control-label first_td1">Customer Mobile No</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="customer[mobil_number]" class="form-control form-align" id="customer_no" value="<?php echo $val['mobil_number']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">

                            <div class="form-group dnone">
                                <label class="col-sm-4 control-label first_td1">Customer Address</label>
                                <div class="col-sm-8">
                                    <textarea name="customer[address1]"  class="form-control form-align" id="address1" style="display:none;"><?php echo $val['address1']; ?></textarea>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td1">Reference Name</label>
                                <div class="col-sm-8">
                                    <input type="hidden"  name="quotation[job_id]"  class="code form-control colournamedup form-align" value="<?php echo $val['job_id']; ?>" id="sales_id">
                                    <td><select id='ref_class' class='nick static_style class_req form-control' tabindex="1"  name='quotation[ref_name]'>
                                            <?php
                                            if (isset($nick_name) && !empty($nick_name)) {
                                                foreach ($nick_name as $vals) {
                                                    $select = ($val['ref_name'] == $vals['user_id']) ? 'selected' : '';
                                                    ?>
                                                    <option value='<?php echo $vals['user_id'] ?>' <?php echo $select; ?>><?php echo $vals['user_name'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select> <span class="error_msg"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td">GSTIN NO</label>
                                <div class="col-sm-8">
                                    <input type="text" id='tin' tabindex="1" name="company[tin_no]" class="form-control" value="<?php echo $val['tin']; ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Date</label>
                                <div class="col-sm-8">
                                    <input type="text" tabindex="1" class="form-align datepicker form-control required" name="quotation[created_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($val['created_date'])); ?>">
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mscroll">
                        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                            <thead>
                                <tr>
                                    <td width="2%" class="first_td1">S.No</td>
                                  <!--<td width="15%" class="first_td1">Category</td>-->
                                    <td width="30%" class="first_td1">Product Name</td>

                                    <td width="5%" class="first_td1">Unit</td>
                                    <!--<td width="10%" class="first_td1">Brand</td>-->
                                    <td  width="8%" class="first_td1">QTY</td>
                                    <td  width="8%" class="first_td1">Unit Price</td>
                                    <td  width="5%" class="first_td1">Total</td>
                                    <td  width="7%" class="first_td1">Discount %</td>
                                    <td  width="5%" class="first_td1">CGST %</td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                    ?>
                                    <td  width="7%" class="first_td1">Net Value</td>
                                    <td width="5%" class="action-btn-align">
                                        <a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Product</a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id='app_table'>
                                <?php
                                $cgst = 0;
                                $sgst = 0;
                                if (isset($quotation_details) && !empty($quotation_details)) {
                                    $i = 1;
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
                                        <tr class="tr_<?php echo $vals['product_id']; ?>">
                                            <td class="action-btn-align s_no">
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <input type="text"  name="model_no[]" id="model_no" style="width:100%; font-weight: 600;;" class='form-align auto_customer tabwid model_no required form-control' tabindex="1"  value="<?php echo $vals['product_name']; ?>"/>
                                                <span class="error_msg"></span>
                                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />
                <!--                                                <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>" />-->
                                                <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>"  />
                                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                            </td>
                                            <td style="display:none;">
                                                <select id='cat_id' class='static_style  form-control' style="display:none;" name='categoty[]' >
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
                                            <td class="action-btn-align">
                                                <input type="hidden" style="width:100%" class='form-align tabwid model_no_extra form-control' value="<?php echo $vals['model_no']; ?>"/>
                                                <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit']; ?>"/>
                                            </td>
                                            <td>
                                                <select  name='brand[]' class="form-align brand_id form-control"  style="display:none;">
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
                                                <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>
                                            <td>
                                                <input type="text" tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost required " value="<?php echo $vals['per_cost'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>
                                            <td class="action-btn-align">
                                                <input type="text" tabindex="1"   style="width:70px;" class="gross" />
                                            </td>
                                            <td>
                                                <input type="text" tabindex="1" name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount'] ?>" />
                                            </td>
                                            <td>
                                                <input type="text" tabindex="1" name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" />
                                            </td>
                                            <?php
                                            $gst_type = $quotation[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td>
                                                        <input type="text" tabindex="1" name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst']; ?>" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td>
                                                        <input type="text" tabindex="1" name='igst[]' style="width:70px;" class="igst" value="<?php echo $vals['igst']; ?>" />
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <td>
                                                <input type="text" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>"/>
                                            </td>
                                    <input type="hidden" value = "<?php echo $vals['del_id']; ?>" class="del_id"/>
                                    <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['del_id']; ?>" class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"><b>Total</b></td>
                                    <td><input type="text"   name="quotation[total_qty]"  readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                                    <td colspan="4" style="text-align:right;"><b>Sub Total</b></td>
                                    <td><input type="text" name="quotation[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>
                                    <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" tabindex="1"  name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                                    <td>
                                        <input type="text" tabindex="1" name="quotation[tax]" class='totaltax text_right'  value="<?php echo $val['tax']; ?>"  style="width:70px;" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:right;">CGST:</td>
                                    <td><input type="text"  value="<?php echo $cgst; ?>"  readonly class="add_cgst text_right" style="width:70px;" /></td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td colspan="4" style="text-align:right;">SGST:</td>
                                        <?php } else { ?>
                                            <td colspan="4" style="text-align:right;">IGST:</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td><input type="text"  value="<?php echo $sgst; ?>"  readonly class="add_sgst text_right" style="width:70px;" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>
                                    <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                                    <td></td>
                                </tr>
                                <tr>

                                    <td colspan="14" style="">
                                        <span class="">Remarks&nbsp;&nbsp;&nbsp;</span>
                                        <input name="quotation[remarks]" type="text" tabindex="1" class="form-control" value="<?php echo $val['remarks']; ?>"  style="width:90%; display: inline" />
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="inner-sub-tit mstyle">TERMS AND CONDITIONS</div>
                    <div>
                        <input type="hidden" class="form-control datepicker class_req borderra0 terms"  name="quotation[delivery_schedule]" value="<?php echo ($val['delivery_schedule'] != '1970-01-01') ? $val['delivery_schedule'] : '-'; ?>" >
                        <input type="text" tabindex="1" class="form-control class_req borderra0 terms"  value="<?php echo ($val['mode_of_payment'] != '') ? $val['mode_of_payment'] : '-'; ?>" name="quotation[mode_of_payment]"/>
                        <input type="hidden"  id='to_date' class="form-control datepicker borderra0 terms"   name="quotation[notification_date]" value="<?php echo ($val['notification_date'] != '1970-01-01') ? $val['notification_date'] : '-'; ?>" >
                        <input type="hidden" class="form-control class_req borderra0 terms"  value="<?php echo ($val['validity'] != '') ? $val['validity'] : '-'; ?>" name="quotation[validity]"/>
                    </div>

                    <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['customer']; ?>"/>
                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>
                    <div class="action-btn-align">
                        <?php if ($val['estatus'] == 2) { ?>

                            <a href="<?php echo $this->config->item('base_url') . 'sales/project_cost_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                            <?php
                        } else {
                            ?>
                            <button class="btn btn-info1" id="save" tabindex="1"> Update </button>
                            <a href="<?php echo $this->config->item('base_url') . 'sales/change_pc_status/' . $quotation[0]['id'] . '/2' ?>" class="btn complete"><span class="glyphicon"></span> Complete </a>
                            <a href="<?php echo $this->config->item('base_url') . 'sales/project_cost_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
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
        if ($('#gst_type').val() == '')
        {
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_new_values').find('tr td.igst_td').hide();
        }
        calculate_function();
        //$('#firm').trigger('change');
        $('#firm').focus();
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
                }
            });
        });
    });


    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
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



    $('.qty,.percost,.pertax,.totaltax,.gst,igst,.discount').live('keyup', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        var cgst = 0;
        var sgst = 0;
        $('.qty').each(function () {
            var qty = $(this);
            var percost = $(this).closest('tr').find('.percost');
            var pertax = $(this).closest('tr').find('.pertax');
            if ($('#gst_type').val() != '')
            {
                if ($('#gst_type').val() == 31)
                {
                    var gst = $(this).closest('tr').find('.gst');

                } else {
                    gst = $(this).closest('tr').find('.igst');
                }
            }
            var subtotal = $(this).closest('tr').find('.subtotal');
            var discount = $(this).closest('tr').find('.discount');
            if (Number(qty.val()) != 0)
            {
                tot = Number(qty.val()) * Number(percost.val());
                $(this).closest('tr').find('.gross').val(tot);
                taxless = Number(qty.val()) * Number(percost.val());
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());
                cgst += Number(pertax.val() / 100) * taxless;
                sgst += Number(gst.val() / 100) * taxless;
                discount1 = Number(discount.val() / 100) * Number(percost.val());
                sub_total1 = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()));
                sub_total = sub_total1 - (discount1 * Number(qty.val()));
                taxless = taxless - (discount1 * Number(qty.val()));
                subtotal.val(taxless.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + sub_total;
            }
        });
        $('.add_cgst').val(cgst.toFixed(2));
        $('.add_sgst').val(sgst.toFixed(2));
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        $('.final_amt').val((final_sub_total + cgst + sgst + Number($('.totaltax').val())).toFixed(2));
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

    //$(document).ready(function () {
    $('body').on('keydown', '#add_quotation input.model_no', function (e) {
        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
        var _this = $(this);
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
            autoFocus: true,
            select: function (event, ui) {
                this_val = $(this);
                product = ui.item.value;
                $(this).val(product);
                model_number_id = ui.item.id;
                cat_it = ui.item.category_id;
                $.ajax({
                    type: 'POST',
//                    data: {model_number_id: model_number_id, c_id: cust_id},
                    data: {model_number_id: model_number_id, c_id: cust_id, firm_id: $('#firm').val(), cat_it: cat_it},
                    url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/" + cat_id,
                    success: function (data) {

                        var result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            this_val.closest('tr').find('.unit').val(result[0].unit);
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);

                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            if (result[0].selling_price != '') {
                                this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
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
                            this_val.closest('tr').find('.qty').focus();
                        }
                    }
                });
            }
        });

    });
    //  });

    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no_extra', function (e) {
            // var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];
            cat_id = $('#firm').val();
            cust_id = $('#customer_id').val();
            var product_data = [];
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
                                if (result[0].selling_price != '') {
                                    this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
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
    /* $(document).scannerDetection({
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
     $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);
     $(tableBody).closest('tr').find('.gst').val(result[0]['sgst']);
     } else {
     $(tableBody).closest('tr').find('.pertax').val(result[0]['cgst']);
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




    $(window).bind('beforeunload', function () {
        if (formHasChanged && !submitted) {
            return 'Are you sure you want to leave?';
        }

    });
</script>
