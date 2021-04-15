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
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
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
        width:200px;
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
        width:200px;
    }
    ul li {
        list-style-type: none;
    }
    .btn-info { background-color:#3db9dc;border-color: #3db9dc;color:#fff;  }
    .btn-info:hover { background-color:#25a7cb; }
    .round-off {border-radius:0px;}
    td a.round-off.btn { border:none !important;}
    .round-off .r-plus { position:relative; top:1px;left: 1px;}
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
?>
<div class="mainpanel">

    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Add Sales Invoice</h4>
        </div><table class="static1" style="display: none;">
            <tr>

                <td colspan="4" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" class="tax_label text_right" tabindex="1" style="width:100%;" ></td>
                <td>
                    <input type="text" name="amount[]" class="totaltax text_right"  tabindex="1" style="width:70px;" >
                    <input type="hidden" name="type[]" class="text_right"  value="invoice" style="width:70px;" >
                </td>
                <td width="2%" class="action-btn-align"><a id='delete_label' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <table class="static" style="display: none;">
            <tr>
                <td class="action-btn-align s_no"></td>
                <td>
                    <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1" style="width:100%;font-weight: 600;"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td style="display:none;">
                    <select id="cat_id" style="display:none;" class='cat_id static_style' name='categoty[]'>
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
                <td class="action-btn-align" >
                    <input type="hidden"  class='form-align  tabwid model_no_extra'  style="width:100%"/>
                    <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" />
                </td>
                <td><select  name='brand[]' class='brand_id' style="display:none;">
                        <option >Select</option>
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
                        <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/></div>
                    <div class="col-xs-4"> <span class="label label-success stock_qty" > 0 </span></div>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"  name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td class="action-btn-align">
                    <input type="text" style="width:70px;" class="gross" />
                </td>
<!--                <td>
                    <input type="text" name='discount[]' style="width:70px;" class="discount" />
                </td>-->
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
                <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <?php
        if (isset($quotation) && !empty($quotation)) {

            foreach ($quotation as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url');
                ?>sales/add_invoice" method="post" class=" panel-body">
                    <input type="hidden" name="quotation[q_id]" value="  <?php echo $val['id']; ?>  "  />
                    <input type="hidden" name="quotation[firm_id]" value="  <?php echo $val['firm_id']; ?>  " />
                    <input type="hidden" name="quotation[ref_name]" value="  <?php echo $val['ref_name']; ?>  " />
                    <input type="hidden" name="quotation[inv_id]" value="  <?php echo $val['inv_id']; ?>  " />
                    <input type="hidden" name="cus_type" value="  <?php echo $val['customer_type']; ?>  " />
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                        <tr>
                            <td colspan="2"><span  class="tdhead">TO,</span>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                            </td>
                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px" ></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td><span  class="tdhead">Invoice NO:</span> </td>
                            <td><span  class="tdhead"> <?php echo $val['inv_id']; ?> </span></td>
                            <td><span class="tdhead">Firm Name:</span></td>
                            <td><?php echo $val['firm_name']; ?><input type="hidden" id="firm_id" value="<?php echo $val['firm_id']; ?>"></td>
                        </tr>
                        <?php if ($val['customer_type'] == 3 || $val['customer_type'] == 4) { ?>
                            <tr>
                                <td class="first_td1"><span  class="tdhead">Customer:</span></td>
                                <td>

                                    <select name="quotation[contract_customer]" tabindex="1" class="form-control " id="custs" style="width:170px;" >
                                        <option value="">Select</option>
                                        <?php
                                        if (isset($customer) && !empty($customer)) {

                                            foreach ($customer as $cus) {
                                                ?>
                                                <option value="<?php echo $cus['id']; ?>"> <?php echo $cus['store_name']; ?> </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class="first_td1"> </td>
                                <td></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="first_td1"><span  class="tdhead">Bill Type:</span></td>
                            <td><input type="radio" class="receiver" value="cash"  name="quotation[bill_type]" <?php echo ($val['customer_type'] == '1' || $val['customer_type'] == '3') ? 'checked' : '' ?>/>Cash Sale
                                <input type="radio" class="receiver" value="credit" name="quotation[bill_type]" <?php echo ($val['customer_type'] == '2' || $val['customer_type'] == '4') ? 'checked' : '' ?>/>Credit Sale<br>
                                <span id="type1" class="error_msg"></span>
                            </td>
                            <td class="first_td1"><span  class="tdhead">Reference NO:</span>  </td>
                            <td><?php echo $val['q_no']; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <span  class="tdhead"> Customer Po:</span>

                            </td>
                            <td>
                                <input type="text" tabindex="1" name="quotation[customer_po]" class="form-control required" style="display: inline" id="customer_po"/>
                                <span class="error_msg"></span>
                            </td>
                            <td class="first_td"><span  class="tdhead">GSTIN NO:</span></td>
                            <td><?php echo $val['tin']; ?></td>
                        </tr>

                        <tr>
                            <td  class="first_td1"><span  class="tdhead">Delivery Status :</span>

                            </td>
                            <td>
                                <?php $delivery_status = array('pending', 'partially_delivered', 'delivered'); ?>
                                <select name="quotation[delivery_status]"  class="form-control required" id="delivery_status"  tabindex="1">
                                    <option value="">Select</option>
                                    <?php
                                    if (isset($delivery_status) && !empty($delivery_status)) {

                                        foreach ($delivery_status as $status) {
                                            ?>
                                            <option value="<?php echo $status; ?>"> <?php echo ucwords(str_replace("_", " ", $status)); ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <span  class="tdhead">Date:</span>
                            </td>
                            <td><input type="text"  class="form-control required datepicker " name="quotation[created_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y'); ?>" style="display: inline"/>
                                <span class="error_msg"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="first_td"><span  class="tdhead">Sales Man:</span></td>
                            <td>
                                <select  name='quotation[sales_man]' class="form-control class_req required" tabindex="1" >
                                    <option >Select</option>
                                    <?php
                                    if (isset($sales_man) && !empty($sales_man)) {
                                        foreach ($sales_man as $val) {
                                            ?>
                                            <option value='<?php echo $val['id'] ?>'><?php echo $val['sales_man_name'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline text-center" id="add_quotation">
                        <thead>
                            <tr>
                                <td width="2%" class="first_td1">S.No</td>
                                <td width="25%" class="first_td1">Product Name</td>
                                <!--<td width="15%" class="first_td1">Model No</td>-->
                               <!--<td width="10%" class="first_td1">Brand</td>-->
                                <td width="8%" class="first_td1">Unit</td>
                                <td width="8%" class="first_td1 action-btn-align">QTY</td>
                                <td width="8%" class="first_td1 action-btn-align">Unit Price</td>
                                <td width="7%" class="first_td1 action-btn-align">Total</td>
                                <!--<td width="7%" class="first_td1 action-btn-align proimg-wid">Discount %</td>-->
                                <td width="6%" class="first_td1 action-btn-align">CGST %</td>
                                <?php
                                $gst_type = $quotation[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {
                                        ?>
                                        <td  width="6%" class="first_td1 action-btn-align" >SGST%</td>
                                    <?php } else { ?>
                                        <td  width="6%" class="first_td1 action-btn-align" >IGST%</td>

                                        <?php
                                    }
                                }
                                ?>
                                <td width="7%" class="first_td1 action-btn-align">Net Value</td>
                                <td width="2%" class="action-btn-align">
                                    <a id='add_group' class="btn btn-success form-control padd2"><span class="glyphicon glyphicon-plus"></span></a>
                                </td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                $i = 1;
                                foreach ($quotation_details as $vals) {
                                    if ($quotation[0]['advance'] != '') {
                                        $net_total = ($val['net_total'] - $quotation[0]['advance']);
                                    }
                                    ?>
                                    <tr class="tr_<?php echo $vals['product_id']; ?>">
                                        <td class="action-btn-align s_no">
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <input type="text"  name="model_no[]" tabindex="1" id="model_no" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['product_name']; ?>" style="width:100%; font-weight: 600;"/>
                                            <span class="error_msg"></span>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />
                                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>"  />
                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                            <select id="brand_id" name='brand[]' class='brand_id' id="brand_id" tabindex="1" style="display:none;">
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
                                        <td style="display:none;">
                                            <select id='cat_id' style="display:none;" class='static_style required' name='categoty[]'>
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
                                            <input type="hidden" class='form-align tabwid model_no_extra' value="<?php echo $vals['model_no']; ?>" style="width:100%"/>
                                            <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" value="<?php echo $vals['unit']; ?>" class="unit" />
                                        </td>
                                        <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                                            <td>
                                                <input type="hidden"   tabindex="1"  name='available_quantity[]' style="width:70px; background:#e9edf0;" class="code colournamedup tabwid form-align " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                <div class="col-xs-8"> <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;margin-top: 2px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/></div>
                                                <div class="col-xs-4"> <span class="label label-success stock_qty" > <?php echo $vals['stock'][0]['quantity'] ?> </span></div>
                                                <span class="error_msg"></span>
                                            </td>
                                        <?php } else { ?>
                                            <td><div class="avl_qty"></div>
                                                <div class="col-xs-8">    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/></div>
                                                <div class="col-xs-4"> <span class="label label-success stock_qty" > 0 </span></div>
                                                <span class="error_msg"></span>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input type="text"   name='per_cost[]' style="width:70px;" class="selling_price percost required"value="<?php echo $vals['per_cost'] ?>" />
                                            <span class="error_msg"></span>
                                        </td>
                                        <td class="action-btn-align">
                                            <input type="text"  style="width:70px;" class="gross" />
                                        </td>
                <!--                                        <td>
                                            <input type="text"   name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount']; ?>" />
                                        </td>-->
                                        <td>
                                            <input type="text"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax']; ?>" />
                                        </td>
                                        <?php
                                        $gst_type = $quotation[0]['state_id'];
                                        if ($gst_type != '') {
                                            if ($gst_type == 31) {
                                                ?>
                                                <td>
                                                    <input type="text"  name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst']; ?>" />
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <input type="text" name='igst[]' style="width:70px;" class="igst" value="<?php echo $vals['igst']; ?>" />
                                                </td>
                                                <?php
                                            }
                                        }
                                        ?>


                                        <td>
                                            <input type="text"   style="width:100px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>"/>
                                        </td>
                                <input type="hidden" value = "<?php echo $vals['del_id']; ?>" class="del_id"/>
                                <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['del_id']; ?>" class="del btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="4" style="width:70px; text-align:right;">Total</td>
                                <td><input type="text"   name="quotation[total_qty]" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                                <td colspan="3" style="text-align:right;">Sub Total</td>
                                <td><input type="text" name="quotation[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:100px;" /><input type="hidden" class="temp_sub_total" value="" /></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody class="additional">
                            <tr>
                                <td colspan="8" style="text-align:right;">Advance</td>
                                <td><input type="text" name="advance"  readonly="readonly" value="<?php echo $quotation[0]['advance']; ?>"  class="advance text_right" style="width:100px;" /></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody class="addtional">
                            <tr>
                                <td colspan="8" style="text-align:right;">Round Off ( - )</td>
        <!--                                <td>
                                    <div class="switch switch-blue">
                                        <input type="radio" class="switch-input" name="view" value="week" id="week" checked>
                                        <label for="week" class="switch-label switch-label-off r-plus">+</label>
                                        <input type="radio" class="switch-input" name="view" value="month" id="month">
                                        <label for="month" class="switch-label switch-label-on r-minus">-</label>
                                        <span class="switch-selection"></span>
                                    </div>
                                </td>-->
                                <td><input type="text" name="quotation[round_off]"  value=""  class="round_off text_right" style="width:100px;" readonly />
        <!--                                    <input type="hidden" name="temp_round_off_plus" class="temp_round_off_plus"  value="0"  />
                                    <input type="hidden" name="temp_round_off_minus" class="temp_round_off_minus"  value="0"  />-->
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody class="additional">
                        <td colspan="4" style="text-align:right;">CGST:</td>
                        <td><input type="text"  value=""  readonly class="add_cgst text_right" style="width:100px;" /></td>

                        <?php
                        $gst_type = $quotation[0]['state_id'];
                        if ($gst_type != '') {
                            if ($gst_type == 31) {
                                ?>
                                <td colspan="3" style="text-align:right;">SGST:</td>
                            <?php } else { ?>
                                <td colspan="3" style="text-align:right;">IGST:</td>
                                <?php
                            }
                        }
                        ?>
                        <td><input type="text" value=""  readonly class="add_sgst text_right" style="width:100px;" /></td>
                        <td></td>
                        </tbody>
                        <tbody class="addtional">
                            <tr>
                                <td colspan="4" style="text-align:right;">Transport Charge</td>
                                <td><input type="text" name="quotation[transport]"  value=""  class="transport text_right" style="width:100px;" /></td>
                                <td colspan="3" style="text-align:right;">Labour Charge</td>
                                <td><input type="text" name="quotation[labour]"  value=""  class="labour text_right" style="width:100px;" /></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td><input type="text" id="net_total" name="quotation[net_total]"  readonly="readonly"  class="final_amt text_right" style="width:100px;" value="<?php echo $net_total; ?>" /></td>
                                <td></td>
                            </tr>
                            <tr>

                                <td colspan="11">
                                    <span >Remarks&nbsp;</span>
                                    <input name="quotation[remarks]" type="text" class="form-control" value="<?php echo $val['remarks']; ?>" style="width:90%; display: inline"/>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $quotation[0]['state_id']; ?>"/>
                    <input type="hidden"  name="quotation[customer]" id="customer_id" class='customer_id' value="<?php echo $quotation[0]['customer']; ?>"/>
                    <input type="hidden"  name="quotation[credit_days]" id="credit_days" class='credit_days' value="<?php echo $quotation[0]['credit_days']; ?>"/>
                    <input type="hidden"  name="quotation[credit_limit]" id="credit_limit" class='credit_limit' value="<?php echo $quotation[0]['credit_limit']; ?>"/>
                    <input type="hidden"  name="quotation[temp_credit_limit]" id="temp_credit_limit" class='temp_credit_limit' value="<?php echo $quotation[0]['temp_credit_limit']; ?>"/>
                    <input type="hidden"  name="quotation[approved_by]" id="approved_by" class='approved_by' value="<?php echo $quotation[0]['approved_by']; ?>"/>
                    <div class="action-btn-align">
                        <button class="btn btn-info " id="save" tabindex="1"> Create </button>
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
    var formHasChanged = false;
    var submitted = false;
    $('#save').live('click', function () {
        var net_total = $('#net_total').val();
        var credit_limit = $('#credit_limit').val();
        var temp_credit_limit = $('#temp_credit_limit').val();
        var approved_by = $('#approved_by').val();
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
                $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('tr td').find('.error_msg').text('');

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
        if (m > 0) {
            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)
            }, 500);
            return false;
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

        else if (m == 0)
        {
            submitted = true;
        }

    });
    $(document).ready(function () {
// var $elem = $('#scroll');
//  window.csb = $elem.customScrollBar();
        if ($('#gst_type').val() == '')
        {
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_new_values').find('tr td.igst_td').hide();
        }

        $('#customer_po').focus();
        $("#customer_name").keyup(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer",
                data: 'q=' + $(this).val(),
                success: function (data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background", "#FFF");
                }
            });
        });
        $('body').click(function () {
            $("#suggesstion-box").hide();
        });
        val = $('#firm_id').val();
        if (val != '') {
            $.ajax({
                type: 'POST',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',
                success: function (data) {
                    var result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        option_text = '<option value="">Select Category</option>';
                        $.each(result, function (key, value) {
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

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
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
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });
    $('.del').live('click', function () {
        var del_id = $(this).closest('tr').find('.del_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "sales/delete_pc_id",
            data: {del_id: del_id
            },
            success: function (datas) {
                calculate_function();
            }
        });
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
    $(".remove_comments").live('click', function () {
        $(this).closest("tr").remove();
        var full_total = 0;
        $('.total_qty').each(function () {
            full_total = full_total + Number($(this).val());
        });
        $('.full_total').val(full_total);
        console.log(full_total);
    });
    $('.qty,.percost,.pertax,.totaltax,.gst,.discount,.transport,.labour,.igst').live('keyup', function () {
        calculate_function();
    });
    $(".r-plus").on('click', function () {
        var round_off = $('.round_off').val();
        $('.temp_round_off_plus').val(round_off);
        $('.temp_round_off_minus').val(0);
        calculate_function();
    });
    $(".r-minus").on('click', function () {
        var round_off = $('.round_off').val();
        $('.temp_round_off_minus').val(round_off);
        $('.temp_round_off_plus').val(0);
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        //var temp_round_off_plus = Number($('.temp_round_off_plus').val());
        //var temp_round_off_minus = Number($('.temp_round_off_minus').val());
        var transport = Number($('.transport').val());
        var labour = Number($('.labour').val());
        var advance = Number($('.advance').val());
        var cgst = 0;
        var sgst = 0;
        var gst1 = 0;
        $('.qty').each(function () {
            var qty = $(this);
            var percost = $(this).closest('tr').find('.percost');
            var pertax = $(this).closest('tr').find('.pertax');
            //var discount = $(this).closest('tr').find('.discount');
            var subtotal = $(this).closest('tr').find('.subtotal');
            var transport = $(this).closest('tr').find('.transport');
            var labour = $(this).closest('tr').find('.labour');
            var round_off = $(this).closest('tr').find('.round_off');
            var gst;

            if ($('#gst_type').val() != '')
            {
                if ($('#gst_type').val() == 31)
                {
                    gst = $(this).closest('tr').find('.gst');

                } else {
                    gst = $(this).closest('tr').find('.igst');
                }
            }

            if (Number(qty.val()) != 0)
            {
                tot = Number(qty.val()) * Number(percost.val());
                $(this).closest('tr').find('.gross').val(tot);
                taxless = Number(qty.val()) * Number(percost.val());
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());
                cgst += Number(pertax.val() / 100) * taxless;
                sgst += Number(gst.val() / 100) * taxless;
                //discount1 = Number(discount.val() / 100) * Number(percost.val());
                var discount1 = 0;
                //temp_sub_total = temp_sub_total + ((Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()))) - (discount1 * Number(qty.val()));
                //temp_sub_total = temp_sub_total - (discount1 * Number(qty.val()));
                sub_total1 = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()));
                sub_total = sub_total1 - (discount1 * Number(qty.val()));
                taxless = taxless - (discount1 * Number(qty.val()));
                subtotal.val(taxless.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + taxless;
            }
        });
        $('.add_cgst').val(cgst.toFixed(2));
        $('.add_sgst').val(sgst.toFixed(2));
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        //$('.temp_sub_total').val(temp_sub_total);
        //other item total
        total_item = 0;
        $('.totaltax').each(function () {
            var totaltax = $(this);
            if (Number(totaltax.val()) != 0)
            {
                total_item = total_item + Number(totaltax.val());
            }
        });
        var final_amt = final_sub_total + total_item + transport + labour + cgst + sgst;
        final_amt = final_amt - advance;

        value = final_amt.toFixed(2);
        var round = value.split('.');

        $('.round_off').val('0.' + round[1]);
        var temp_round_off_minus = Number($('.round_off').val());

        var finals = final_amt - Number(temp_round_off_minus);
        finals = Math.abs(finals);
        $('.final_amt').val(finals.toFixed(2));
    }

    $('.cat_id,.brand_id,.pro_class').live('change', function () {
        $('.cat_id,.brand_id,.pro_class').live('click', function () {
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
                success: function (result) {
                    this_.html(result);
                }
            });
        });
    });
    $(".datepicker").datepicker({
        setDate: new Date(),
        yearRange: "-10:+100", changeMonth: true, changeYear: true,
        onClose: function () {
            $("#app_table").find('tr:first td  input.model_no').focus();
        }
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
    });</script>
<script>
    //$(document).ready(function () {
    $('body').on('keydown', '#add_quotation input.model_no', function (e) {
        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function (request, response) {
                var product_data = [];
                cat_id = $('#firm_id').val();
                cust_id = $('#customer_id').val();
                $.ajax({
                    type: 'POST',
                    data: {firm_id: cat_id},
                    async: false,
                    url: '<?php echo base_url(); ?>quotation/get_product_by_frim_id',
                    success: function (data) {
                        product_data = JSON.parse(data);
                    }
                });
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
                $.ajax({
                    type: 'POST',
                    data: {model_number_id: model_number_id, c_id: cust_id},
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
                            // this_val.closest('tr').find('.pertax').val(result[0].cgst);
                            // this_val.closest('tr').find('.gst').val(result[0].sgst);
                            //this_val.closest('tr').find('.discount').val(result[0].discount);
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
    // });
    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no_extra', function (e) {
            // var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];
            var product_data = [];
            cat_id = $('#firm_id').val();
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

                                if (result[0].quantity != null) {
                                    this_val.closest('tr').find('.stock_qty').html(result[0].quantity);
                                } else {
                                    this_val.closest('tr').find('.stock_qty').html('0');
                                }

                                this_val.closest('tr').find('.unit').val(result[0].unit);
                                this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                                //this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                // this_val.closest('tr').find('.gst').val(result[0].sgst);
                                //this_val.closest('tr').find('.discount').val(result[0].discount);
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



    $('.pro_class').live('click', function () {
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
    $('.ser_class').live('click', function () {
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
    $(document).ready(function () {

        calculate_function();
    });
    $(window).bind('scannerDetectionReceive', function (event, data) {
        target_ele = event.target.activeElement;
    });

    $(document).scannerDetection({
        timeBeforeScanTest: 200, // wait for the next character for upto 200ms
        startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
        endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
        avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
        onComplete: function (barcode, qty) {
            $(target_ele).val('');
            cust_id = $('#customer_id').val();
            barcode = barcode;
            if (barcode != '' && cust_id != '') {
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

                                    // $(tableBody).closest('tr').find('.discount').val(result[0]['discount']);
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
    });
</script>
<script>
    (function ($) {

        $.fn.bootstrapSwitch = function (options) {

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

            return this.each(function (e) {
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

                on.click(function (e) {
                    e.preventDefault();
                    c.prop("checked", !c.prop("checked")).trigger('change')
                });
                off.click(function (e) {
                    e.preventDefault();
                    c.prop("checked", !c.prop("checked")).trigger('change')
                });

                $(this).hide().on('change', function () {
                    applyChange(c.is(':checked'))
                });
            });
        };
    }(jQuery));
</script>
<script>
    $("[name='checkbox1'],[name='checkbox2'], [name='checkbox10']").bootstrapSwitch();
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
