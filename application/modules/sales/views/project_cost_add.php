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
    .auto-asset-search ul#product-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
        width:200px;
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
?>
<div class="mainpanel">
    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Add Sales Order</h4>
        </div><table class="static1" style="display: none;">
            <tr>
                <td colspan="4" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" tabindex="1" class="tax_label text_right" style="width:100%;" ></td>
                <td>
                    <input type="text" name="amount[]" class="totaltax text_right"  tabindex="1" style="width:70px;" >
                    <input type="hidden" name="type[]" class="text_right"  value="project_cost" style="width:70px;" >
                </td>
                <td width="2%" class="action-btn-align"><a id='delete_label' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <table class="static" style="display: none;">
            <tr>

                <td>
                    <input type="text"  name="model_no[]" style="width:100%;font-weight: 600;" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1" style="width:100%"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <select id='cat_id' class='cat_id static_style' style="display:none;" name='categoty[]' >
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
                    <input type="text"  class='form-align  tabwid model_no_extra'  style="width:100%"/>
                </td>
                <td class="action-btn-align">
                    <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" />
                </td>
                <td>
                    <select  name='brand[]' class='brand_id'  style="display:none;">
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
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>

                <td><div class="avl_qty">
                        <input type="text"  name='per_cost[]' style="width:70px;" class="cost_price percost " id="price"/>
                        <span class="error_msg"></span></div>
                </td>
                <td class="action-btn-align">
                    <input type="text"  style="width:70px;" class="gross" />
                </td>
                <td>
                    <input type="text" name='discount[]' style="width:70px;" class="discount" />
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
                <form  action="<?php echo $this->config->item('base_url'); ?>sales/" method="post" class=" panel-body">
                    <input type="hidden" name="quotation[q_id]" value="  <?php echo $val['id']; ?>  " />
                    <input type="hidden" name="quotation[firm_id]" value="  <?php echo $val['firm_id']; ?>  " />
                    <table  class="table table-striped responsive table-bordered dataTable no-footer dtr-inline">
                        <tr>
                            <td><span  class="tdhead">TO,</span>
                                <div><?php echo $val['address1']; ?></div>
                            </td>
                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/images/logo.png" alt="Chain Logo" width="125px" ></td>
                        </tr>
                        <tr>
                            <td class="first_td"><span  class="tdhead">Firm Name:</span> <?php echo $val['firm_name']; ?><input type="hidden" id="firm_id" value="<?php echo $val['firm_id']; ?>">  </td>

                            <td class="first_td1"><span  class="tdhead"> Reference Name:</span> <?php echo $val['nick_name'] ?> </td>

                        </tr>
                        <tr>
                            <td class="first_td1"> <span  class="tdhead"> Quotation NO:</span>  <?php echo $val['q_no']; ?> </td>
                            <td class="first_td1"><span  class="tdhead"> Sales Id:</span><?php echo $val['job_id']; ?>
                                <input type="hidden"  name="quotation[job_id]" class="code form-control colournamedup tabwid form-align" value="<?php echo $val['job_id']; ?> "  id="grn_no">
                            </td>

                        </tr>
                        <tr>
                            <td><span  class="tdhead">Customer Name:</span> <?php echo $val['store_name']; ?> </td>
                            <td class="first_td1"><span  class="tdhead">Customer Mobile No:</span><?php echo $val['mobil_number']; ?> </td>

                        </tr>
                        <tr>
                            <td id='customer_td'><span  class="tdhead">Customer Email ID:</span> <?php echo $val['email_id']; ?> </td>
                            <td class="first_td"><span  class="tdhead">GSTIN NO:</span><?php echo $val['tin']; ?>  </td>


                        </tr>
                        <tr>
                            <td><span  class="tdhead"> Date:</span>
                                <input type="text"  class="form-control datepicker tabwid" name="quotation[created_date]" value="<?= date('d-m-Y', strtotime($val['created_date'])); ?>" style="width:200px; display: inline"/>
                            </td>
                            <td></td>
                        </tr>
                        <?php if ($val['customer_type'] == 3 || $val['customer_type'] == 4) { ?>
                            <tr>
                                <td class="first_td1"><span  class="tdhead">Customer:</span>
                                    <select name="quotation[contract_customer]"  tabindex="1" class="form-control " id="custs" style="width:170px;" >
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
                                <td></td>

                            </tr>
                        <?php } ?>
                    </table>

                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                        <thead>
                            <tr>
                                <!--<td width="15%" class="first_td1">Category</td>-->

                                <td width="30%" class="first_td1">Product Name</td>
                                <td width="15%" class="first_td1">Model No</td>
                                <td width="5%" class="first_td1">Unit</td>
                              <!--<td width="10%" class="first_td1">Brand</td>-->
                                <td  width="8%" class="first_td1">QTY</td>
                                <td  width="8%" class="first_td1">Unit Price</td>
                                <td  width="5%" class="first_td1">Total</td>
                                <td  width="7%" class="first_td1">Discount %</td>
                                <td width="5%" class="first_td1 action-btn-align cgst_td">CGST %</td>
                                <?php
                                $gst_type = $quotation[0]['state_id'];
                                if ($gst_type != '') {
                                    if ($gst_type == 31) {
                                        ?>
                                        <td  width="2%" class="first_td1 action-btn-align" >SGST%</td>
                                    <?php } else { ?>
                                        <td  width="2%" class="first_td1 action-btn-align" >IGST%</td>

                                        <?php
                                    }
                                }
                                ?>
                                <td  width="5%" class="first_td1">Net Value</td>
                                <td width="2%" class="action-btn-align">
                                    <a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Product</a>
                                </td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>
                                    <tr class="tr_<?php echo $vals['product_id']; ?>">

                                        <td>
                                            <input type="text"  name="model_no[]" style="width:100%; font-weight: 600;" id="model_no" tabindex="1" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['product_name']; ?>"/>
                                            <span class="error_msg"></span>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />
                                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type'value="<?php echo $vals['type']; ?>"  />
                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>
                                        <td>
                                            <select id='cat_id' style="display:none;" class='cat_id static_style' name='categoty[]' >
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
                                            <input type="text" class='form-align tabwid model_no_extra' value="<?php echo $vals['model_no']; ?>" style="width:100%"/>
                                        </td>
                                        <td class="action-btn-align">
                                            <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" />
                                        </td>
                                        <td>
                                            <select id="brand_id" name='brand[]' class="brand_id" style="display:none;">
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
                                        <td><div class="avl_qty">
                                            <input type="text"   name='per_cost[]' style="width:70px;" class="cost_price percost required" value="<?php echo $vals['per_cost'] ?>" /><!--value="<?php echo $vals['po'][0]['per_cost'] ?>"-->
                                                <span class="error_msg"></span></div>
                                        </td>
                                        <td class="action-btn-align">
                                            <input type="text" style="width:70px;" class="gross" />
                                        </td>
                                        <td>
                                            <input type="text"  name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount'] ?>" />
                                        </td>
                                        <td>
                                            <input type="text" name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" />
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
                                            <input type="text"  style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>"/>
                                        </td>
                                <input type="hidden" value = "<?php echo $vals['p_id']; ?>" class="del_id"/>
                                <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['p_id']; ?>" class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                        <tbody>
                        <td colspan="4" style="width:70px; text-align:right;"><b>Total</b></td>
                        <td><input type="text"   name="quotation[total_qty]"  readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                        <td colspan="4" style="text-align:right;"><b>Sub Total</b></td>
                        <td><input type="text" name="quotation[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                        <td></td>
                        </tbody>
                        <tbody class="add_cost">
                        <td colspan="5" style="width:70px; text-align:right;"></td>
                        <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                        <td>
                            <input type="text"  name="quotation[tax]" class='totaltax text_right'  value="<?php echo $val['tax']; ?>"  style="width:70px;" />
                        </td>
                        <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add </a></td>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="width:70px; text-align:right;"></td>
                                <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td><input type="text"  name="quotation[net_total]"  readonly="readonly" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="12" style="">
                                    <span class="">Remarks&nbsp;</span>
                                    <input name="quotation[remarks]" type="text" class="form-control" value="<?php echo $val['remarks']; ?>"  style="width:90%; display: inline"/>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden"  name="quotation[customer]" id="customer_id" class='customer_id'  value="<?php echo $val['customer']; ?>"/>
                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>
                    <div class="action-btn-align">
                        <button class="btn btn-success" id="save" tabindex="1"> Create </button>
                        <a href="<?php echo $this->config->item('base_url') . 'sales/project_cost_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
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

        if (m > 0) {
            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)
            }, 500);
            return false;
        } else {
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

        $('#firm').focus();
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
//	val = $('#firm_id').val();
//	if (val != '') {
//	    $.ajax({
//		type: 'POST',
//		data: {firm_id: val},
//		url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',
//		success: function (data) {
//		    result = JSON.parse(data);
//		    if (result != null && result.length > 0) {
//			option_text = '<option value="">Select Category</option>';
//			$.each(result, function (key, value) {
//			    option_text += '<option value="' + value.cat_id + '">' + value.categoryName + '</option>';
//			});
//			$('.cat_id').html(option_text);
//			$('.cat_id').removeAttr('disabled');
////			$('.cat_id').addClass('required');
//			$('.model_no').html('');
//			$('.model_no').attr('readonly', 'readonly');
//			$('.model_no').removeClass('required');
//			$('.model_no_ser').html('');
//			$('.model_no_ser').attr('readonly', 'readonly');
//			$('.model_no_ser').removeClass('required');
//		    } else {
//			$('.cat_id,.model_no,.model_no_ser').html('');
//			$('.cat_id,.model_no,.model_no_ser').removeClass('required');
//			$('.cat_id').attr('disabled', 'disabled');
//			$('.model_no,.model_no_ser').attr('readonly', 'readonly');
//		    }
//		}
//	    });
//	} else {
//	    $('.cat_id,.model_no,.model_no_ser').html('');
//	    $('.cat_id,.model_no,.model_no_ser').removeClass('required');
//	    $('.cat_id').attr('disabled', 'disabled');
//	    $('.model_no,.model_no_ser').attr('readonly', 'readonly');
//	}
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
    $('.del').live('click', function () {
        var del_id = $(this).closest('tr').find('.del_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "sales/delete_id",
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
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());
                discount1 = Number(discount.val() / 100) * Number(percost.val());
                sub_total1 = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()));
                sub_total = sub_total1 - (discount1 * Number(qty.val()));
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

    // $(document).ready(function () {
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
                            this_val.closest('tr').find('.unit').val(result[0].unit);
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.cost_price').val(result[0].selling_price);
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
            //  var product_data = [<?php echo implode(',', $model_numbers_extra); ?>];
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
                                this_val.closest('tr').find('.unit').val(result[0].unit);
                                this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.cost_price').val(result[0].selling_price);
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

    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });
    });
    $(document).ready(function () {

        calculate_function();
    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.pertax').val($(this).attr('pro_cgst'));
        $(this).closest('tr').find('.gst').val($(this).attr('pro_sgst'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
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
        $(this).closest('tr').find('.cost_price').val($(this).attr('ser_sell'));
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
                        $('.cat_id,.model_no,.model_no_ser').val('');
                        //$('.cat_id,.model_no,.model_no_ser').addClass('required');
                        $('.model_no,.model_no_ser').removeAttr('readonly', 'readonly');
//                        $('.model_no').attr('readonly', 'readonly');
//                        $('.model_no').removeClass('required');
//                        $('.model_no_ser').html('');
//                        $('.model_no_ser').attr('readonly', 'readonly');
//                        $('.model_no_ser').removeClass('required');
                        if (cat != '') {
                            $('.cat_id').val(cat);
                        }
                    } else {
                        $('.cat_id,.model_no,.model_no_ser').val('');
                        //$('.cat_id,.model_no,.model_no_ser').removeClass('required');
                        //$('.cat_id').attr('disabled', 'disabled');
                        $('.model_no,.model_no_ser').attr('readonly', 'readonly');
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
                    $('#sales_id').val(data1[0]['prefix']);
                    $('#invoice_id').val(data1[0]['prefix']);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {type: data1[0]['prefix'], code: 'TT'},
                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
                        success: function (data2) {
                            $('#grn_no').val(data2);
                            $('#sales_id').val(data2);
                            $('#invoice_id').val(data2);
                            //console.log(data2);
                            var increment_id = $('#grn_no').val().split("/");
                            var increment_id1 = $('#sales_id').val().split("/");
                            var increment_id2 = $('#invoice_id').val().split("/");
                            final_id = data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
                            sales_id = 'SL-' + data1[0]['prefix'] + '-' + increment_id1[1] + '-' + increment_id1[2];
                            inv_id = 'INV-' + data1[0]['prefix'] + '-' + increment_id2[1] + '-' + increment_id2[2];
                            $('#sales_id').val(sales_id);
                            $('#grn_no').val(final_id);
                            $('#invoice_id').val(inv_id);
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
            $('.cat_id,.model_no,.model_no_ser').val('');
            //$('.cat_id,.model_no,.model_no_ser').removeClass('required');
            //$('.cat_id').attr('disabled', 'disabled');
            $('.model_no,.model_no_ser').attr('readonly', 'readonly');
        }

    }
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
                        var result = JSON.parse(data);
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
                                    $(tableBody).closest('tr').find('.cost_price').val(result[0]['selling_price']);
                                    $(tableBody).closest('tr').find('.type').val(result[0]['type']);

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
                                    //Firm(result[0]['firm_id'], result[0]['category_id']);
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


