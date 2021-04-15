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
    }
    ul li {
        list-style-type: none;
    }
    .btn-info { background-color:#3db9dc;border-color: #3db9dc;color:#fff;  }
    .btn-info:hover { background-color:#25a7cb; }
</style>
<div class="mainpanel">
  
    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Add Invoice</h4>
        </div><table class="static1" style="display: none;">
            <tr>
                <td colspan="2" style="width:70px; text-align:right;"></td>
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
                <td>
                    <select id="cat_id" class='cat_id static_style class_req' name='categoty[]' tabindex="1">
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
                </td>
                <td>
                    <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <select  name='brand[]' class='brand_id' tabindex="1">
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
                    <span class="error_msg"></span>
                </td>
                <td>
                    <textarea  name="product_description[]" id="product_description" tabindex="1" class='form-align auto_customer tabwid product_description'/></textarea>
                </td>
                <td><div class="avl_qty"></div>
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='gst[]' style="width:70px;" class="gst" />
                </td>
                <td>
                    <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <table class="static_ser" style="display: none;">
            <tr>
                <td>
                    <select id='cat_id' class='cat_id static_style class_req' name='categoty[]' tabindex="1">
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
                </td>                
                <td>
                    <input type="text"  name="model_no[]" id="model_no_ser" class='form-align auto_customer tabwid model_no_ser' tabindex="1" />
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-align type type_ser' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <select  name='brand[]' class='brand_id' tabindex="1">
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
                    <span class="error_msg"></span>
                </td>
                <td>
                    <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description'tabindex="1" />  </textarea>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='gst[]' style="width:70px;" class="gst" />
                </td>
                <td>
                    <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>

        <?php
        if (isset($quotation) && !empty($quotation)) {

            foreach ($quotation as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url'); ?>project_cost/add_invoice" method="post" class=" panel-body">
                    <input type="hidden" name="quotation[q_id]" value="  <?php echo $val['q_id']; ?>  "  />
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                        <tr>
                            <td><span  class="tdhead">TO,</span>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                            </td>
                            <td><span  class="tdhead">Invoice NO: <?php echo $last_id[0]['value']; ?></span> <input type="hidden"  tabindex="-1" name="quotation[inv_id]" class="code form-control colournamedup tabwid form-align" value="<?php echo $last_id[0]['value']; ?>"  id="grn_no"></td>
                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/Logo1.png" alt="Chain Logo" width="125px" ></td>
                            <td></td>
                        </tr>
                        <?php if($val['customer_type'] == 3 || $val['customer_type'] == 4 ){?>
                         <tr>
                            <td class="first_td1"><span  class="tdhead">Customer:</span></td>
                            <td>
                                <select name="quotation[contract_customer]"  class="form-control " id="custs" style="width:170px;" >
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
                            <td><input type="radio" class="receiver" value="cash"  name="quotation[bill_type]">Cash Bill
                                <input type="radio" class="receiver" value="credit" name="quotation[bill_type]">Credit Bill 
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
                                <input type="text" tabindex="1" name="quotation[customer_po]" class="form-control required" style="width:200px; display: inline"/>
                                <span class="error_msg"></span>
                            </td>
                            <td class="first_td"><span  class="tdhead">Tin No:</span></td>
                            <td><?= $company_details[0]['tin_no'] ?></td>
                          <!-- <td><span  class="tdhead">Company Name:</span> <?php echo $val['store_name']; ?> </td>-->
                        </tr>
                        <tr>
                             <!--<td class="first_td1"><span  class="tdhead">Customer Mobile No:</span> <?php echo $val['mobil_number']; ?></td>-->
                             <!--<td class="first_td1"  ><span  class="tdhead">Customer Email ID:</span><?php echo $val['email_id']; ?> </td>-->
                        </tr>
                        <tr>
                            <td  class="first_td1"><span  class="tdhead">Warranty :</span>

                            </td>
                            <td><input type="text"   name="quotation[warranty_from]" tabindex="1" class="form-control datepicker class_req required" placeholder="dd-mm-yyyy" style="width:200px; display: inline">
                                <input type="text"   name="quotation[warranty_to]" tabindex="1" class="form-control datepicker class_req required" placeholder="dd-mm-yyyy"  style="width:200px; display: inline">
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <span  class="tdhead"> Date:</span>
                            </td>
                            <td><input type="text" tabindex="1"  class="form-control required datepicker " name="quotation[created_date]" placeholder="dd-mm-yyyy" style="width:200px; display: inline"/>
                                <span class="error_msg"></span>
                            </td>
                        </tr>
                    </table>


                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                        <thead>
                            <tr>
                                <td width="10%" class="first_td1">Category</td>                                
                                <td width="10%" class="first_td1">Model Number</td>
                                <td width="10%" class="first_td1">Brand</td>
                                <td width="10%" class="first_td1">Product Description</td>
                                <td  width="8%" class="first_td1 action-btn-align">QTY</td>
                                <td  width="2%" class="first_td1 action-btn-align">Cost/QTY</td>
                                <td  width="5%" class="first_td1 action-btn-align proimg-wid">CGST %</td>
                                <td  width="5%" class="first_td1 action-btn-align proimg-wid">SGST %</td>
                                <td  width="7%" class="first_td1 action-btn-align">Net Value</td>
                                <td width="2%" class="action-btn-align">
                                    <a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Product</a>
                                    <a id='add_group_service' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Others</a>
                                </td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>
                                    <tr>
                                        <td>
                                            <select id='cat_id' class='cat_id static_style required' name='categoty[]' tabindex="1">
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
                                            <span class="error_msg"></span>
                                        </td>                                        
                                        <td>
                                            <input type="text"  name="model_no[]" tabindex="1" id="model_no" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['model_no']; ?>"/>
                                            <span class="error_msg"></span>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />
                                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>"  />
                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>                                        
                                        <td>
                                            <select id="brand_id" name='brand[]' class='brand_id' id="brand_id" tabindex="1">
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
                                            <span class="error_msg"></span>
                                        </td>
                                        <td>
                                            <textarea  name="product_description[]" tabindex="1"id="product_description" class='form-align auto_customer tabwid product_description'/><?php echo $vals['product_description']; ?></textarea>
                                        </td>

                                        <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                                            <td>
                                                <input type="text"   tabindex="1"  name='available_quantity[]' style="width:70px;" class="code form-control colournamedup tabwid form-align " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;margin-top: 2px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>
                                        <?php } else { ?>
                                            <td><div class="avl_qty"></div>
                                                <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" value="<?php echo $vals['quantity'] ?>"/>
                                                <span class="error_msg"></span>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="selling_price percost required"value="<?php echo $vals['per_cost'] ?>" />
                                            <span class="error_msg"></span>
                                        </td>
                                        <td>
                                            <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" />
                                        </td>
                                        <td>
                                            <input type="text"   tabindex="1"   name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst'] ?>" />
                                        </td>
                                        <td>
                                            <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>"/>
                                        </td>
                                <input type="hidden" value = "<?php echo $vals['del_id']; ?>" class="del_id"/>
                                <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['del_id']; ?>" class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                        <tbody>
                        <td colspan="4" style="width:70px; text-align:right;">Total</td>
                        <td><input type="text"   name="quotation[total_qty]"  tabindex="1" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                        <td colspan="3" style="text-align:right;">Sub Total</td>
                        <td><input type="text" name="quotation[subtotal_qty]"  tabindex="1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                        <td></td>
                        </tbody>

                        <tbody class="add_cost">
                        <td colspan="2" style="width:70px; text-align:right;"></td>
                        <td colspan="6" style="text-align:right;font-weight:bold;"><input type="text" tabindex="1" name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                        <td>
                            <input type="text"  name="quotation[tax]" class='totaltax text_right' tabindex="1" value="<?php echo $val['tax']; ?>"  style="width:70px;" />
                        </td>
                        <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add </a></td>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="2" style="width:70px; text-align:right;"></td>
                                <td colspan="6"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  tabindex="1" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                                <td></td>
                            </tr>
                            <tr>

                                <td colspan="10" style="">
                                    <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                    <input name="quotation[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" tabindex="1" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer' value="<?php echo $val['customer']; ?>"/>


                    <div class="action-btn-align">

                        <button class="btn btn-info " id="save"> Create </button>

                        <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
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
    $('#save').live('click', function () {
        m = 0;
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
        
        if ($('input[type=radio]:checked').length <= 0)
            {
                $("#type1").html("This field is required");
                m = 1;
            } else
            {
                $("#type1").html("");
            }       
        if (m > 0)
            return false;

    });

    $(document).ready(function () {
// var $elem = $('#scroll');
//  window.csb = $elem.customScrollBar();
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
    });

    $('.cust_class').live('click', function () {
        $("#customer_id").val($(this).attr('cust_id'));
        $("#c_id").val($(this).attr('cust_id'));
        $("#customer_name").val($(this).attr('cust_name'));
        $("#customer_no").val($(this).attr('cust_no'));
        $("#email_id").val($(this).attr('cust_email'));
        $("#address1").val($(this).attr('cust_address'));
    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
    });
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });
    $('.del').live('click', function () {
        var del_id = $(this).closest('tr').find('.del_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "project_cost/delete_pc_id",
            data: {del_id: del_id
            },
            success: function (datas) {
                calculate_function();
            }
        });

    });

    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
    });

    $('#add_label').click(function () {
        var tables = $(".static1").find('tr').clone();
        $('.add_cost').append(tables);

    });

    $('#delete_group').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
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

    $('.qty,.percost,.pertax,.totaltax,.gst').live('keyup', function () {
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
            var subtotal = $(this).closest('tr').find('.subtotal');
            var gst=$(this).closest('tr').find('.gst');
            if (Number(qty.val()) != 0)
            {
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1= Number(gst.val()/100) * Number(percost.val());
                sub_total=( Number(qty.val()) * Number(percost.val()) ) + ( pertax1 * Number(qty.val()) ) +( gst1 * Number(qty.val()) );
                subtotal.val(sub_total.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + sub_total;
            }
        });
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        //other item total
        total_item = 0;
        $('.totaltax').each(function () {
            var totaltax = $(this);
            if (Number(totaltax.val()) != 0)
            {
                total_item = total_item + Number(totaltax.val());
            }
        });
        var final_amt = final_sub_total + total_item;
        $('.final_amt').val(final_amt.toFixed(2));
    }

    $('.cat_id,.brand_id,.pro_class').live('change', function () {
        $('.cat_id,.brand_id,.pro_class').live('click', function () {
            var cat_id = $(this).closest('tr').find('.cat_id').val();
            var brand_id = $(this).closest('tr').find('.brand_id').val();
            var model_no = $(this).closest('tr').find('.product_id').val();
            var this_ = $(this).closest('tr').find('.avl_qty');
            $.ajax({
                url: BASE_URL + "project_cost/get_stock",
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


    $(document).ready(function () {
        jQuery('.datepicker').datepicker({yearRange: "-10:+100", changeMonth: true, changeYear: true});
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
    $(".model_no").live('keyup', function () {
        var this_ = $(this)
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product",
            data: 'q=' + $(this).val(),
            success: function (datas) {
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);

            }
        });
    });

    $("#model_no_ser").live('keyup', function () {
        var this_ = $(this)
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service",
            data: 's=' + $(this).val(),
            success: function (datas) {
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);

            }
        });
    });

    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });
    });

    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });

    $('.ser_class').live('click', function () {
        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "  " + $(this).attr('ser_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    $(document).ready(function () {

        calculate_function();
    });
</script>
