<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .text_right{text-align:right;}
    .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
    #top_heading_fix h3 {top: -57px;left: 6px;}
    #TB_overlay { z-index:20000 !important; }
    #TB_window { z-index:25000 !important; }
    .dialog_black{ z-index:30000 !important; }
    #boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;}
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    .ui-datepicker td.ui-datepicker-today a {background:#999999;}
    .auto-asset-search{position:absolute !important; width:100%;}
    .auto-asset-search ul#country-list li{ padding:0px;}
    .auto-asset-search ul#country-list li:hover { background: #c3c3c3;cursor: pointer;}
    .auto-asset-search ul#product-list li:hover { background: #c3c3c3;cursor: pointer; }
    .auto-asset-search ul#country-list li {background: #dadada; margin: 0; padding: 5px;border-bottom: 1px solid #f3f3f3;}
    .auto-asset-search ul#product-list li { background: #dadada; margin: 0; padding: 5px;border-bottom: 1px solid #f3f3f3;}
    ul li {list-style-type: none;}
    #suggesstion-box{z-index: 99;}
    .auto-asset-search ul { padding:0px;}
</style>
<div class="mainpanel">
    <div id='empty_data'></div>
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Add Delivery Challan</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td>
                    <select id='cat_id' class='cat_id static_style class_req' style="width:100%" name='categoty[]' tabindex="1">
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


                <td >
                    <input type="text"  name="model_no[]" style="width:100%" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td >
                    <select  name='brand[]' tabindex="1">
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
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="cost_price percost " id="price"/>
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
        <form  method="post" class="panel-body">
            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Firm</label>
                        <div class="col-sm-8">
                            <?php if (count($firms) > 1) { ?>
                                <select onchange="Firm(this.value)" name="po[firm_id]"  class="form-control form-align" id="firm" >
                                    <option value="">Select</option>
                                    <?php
                                    if (isset($firms) && !empty($firms)) {

                                        foreach ($firms as $firm) {
                                            ?>
                                            <option value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                            <?php
                                        }
                                    }
                                    ?> </select>
                                <?php
                            } else {
                                ?>
                                <select onchange="Firm(this.value)" name="po[firm_id]"  class="form-control form-align" id="firm" readonly="">
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
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Delivery Challan No</label>
                        <div class="col-sm-8">
                            <input type="text"  tabindex="1" name="po[dc_no]" class="code form-control colournamedup  form-align" readonly="readonly" id="dc_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Customer Name <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" tabindex="1" name="customer[store_name]" id="customer_name" class='form-align auto_customer required ' />
                                <div class="input-group-addon">
                                    <i class="fa fa-bank"></i>
                                </div>
                            </div>
                            <span class="error_msg"></span>
                            <input type="hidden"  name="customer[id]" id="customer_id" class='form-control id_customer tabwid form-align' />
    <!--                              <input type="hidden"  name="po[product_id]" id="cust_id" class='id_customer' />-->
                            <div id="suggesstion-box" class="auto-asset-search "></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Customer Mobile No <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text"  tabindex="1" name="customer[mobil_number]" id="customer_no" class="form-align required" />
                                <div class="input-group-addon">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Customer Email ID <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div id='customer_td'>
                                <div class="input-group">
                                    <input type="text"  tabindex="1" name="customer[email_id]" id="email_id" class=" form-align required"/>
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Customer Address <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <textarea name="customer[address1]" tabindex="1" id="address1" class="form-control form-align required"></textarea>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">GSTIN No</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" name="company[tin_no]" tabindex="1" class="form-align" id="tin"/>
                                <div class="input-group-addon">
                                    <i class="fa fa-cog"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Date <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" tabindex="1"  class="form-align datepicker required" name="po[created_date]" placeholder="dd-mm-yyyy" >
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mscroll">
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                    <thead>
                        <tr>
                            <td width="15%" class="first_td1">Category<span style="color:#F00; font-style:oblique;">*</span></td>
                            <td width="30%" class="first_td1">Product Name</td>
                            <td width="10%" class="first_td1">Brand</td>
                            <td width="8%" class="first_td1 action-btn-align">QTY <span style="color:#F00; font-style:oblique;">*</span></td>
                            <td width="8%" class="first_td1 action-btn-align">Unit Price <span style="color:#F00; font-style:oblique;">*</span></td>
                            <td width="5%" class="first_td1 action-btn-align">CGST %</td>
                            <td width="5%" class="first_td1 action-btn-align">SGST %</td>
                            <td width="5%" class="first_td1">Net Value</td>
                            <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Row</a></td>
                        </tr>
                    </thead>
                    <tbody id='app_table'>
                        <tr>
                            <td>
                                <select id='cat_id' class='cat_id static_style class_req required' name='categoty[]' style="width:100%" tabindex="1" >
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
                            <td class="relative">
                                <input type="text"  name="model_no[]" id="model_no" style="width:100%" class='form-align auto_customer tabwid model_no required form-control' tabindex="1" readonly="" />
                                <span class="error_msg"></span>
                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' />
                                <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>

                            </td>
                            <td >
                                <select id='brand_id' name='brand[]' tabindex="1">
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
                                <span class="error_msg"></span>
                            </td>

                            <td>
                                <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" />
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="cost_price percost required" />
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                            </td>
                            <td>
                                <input type="text"   tabindex="1"   name='gst[]' style="width:70px;" class="gst" />
                            </td>
                            <td>
                                <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" />
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"><b>Total</b></td>
                            <td><input type="text"   name="po[total_qty]"  tabindex="1" readonly="readonly" class="total_qty" style="width:70px;" id="total" /></td>
                            <td colspan="3" style="text-align:right;"><b>Sub Total</b></td>
                            <td><input type="text" name="po[subtotal_qty]"  tabindex="1" readonly="readonly"  class="final_sub_total text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="1" name="po[tax_label]" class='tax_label text_right'    style="width:100%;" /></td>
                            <td>
                                <input type="text"  name="po[tax]" class='totaltax text_right'  tabindex="1"  style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="1" class="final_amt text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="10">
                                <span class="remark">Remarks</span>
                                <input name="po[remarks]"  type="text" class="form-control remark"  tabindex="1"/>
                                <input type="hidden"  name="po[customer]" id="c_id" class='id_customer' />
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="action-btn-align mb-bot20">
                <button class="btn btn-primary" id="save"><span class="glyphicon glyphicon-plus"></span> Create</button>
            </div>
            <br />
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#save').live('click', function () {
        m = 0;
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr("id");
            if (this_val == "") {
                $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('div .form-group').find('.error_msg').text('');
                $(this).closest('tr td').find('.error_msg').text('');
            }
        });

        if (m > 0)
            return false;

    });

    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function () {
            cat_id = $('#firm').val();
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "delivery_challan/get_customer/" + cat_id,
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
        $('#firm').trigger('change');
    });

    $('.cust_class').live('click', function () {
        $("#customer_id").val($(this).attr('cust_id'));
        $("#c_id").val($(this).attr('cust_id'));
        $("#customer_name").val($(this).attr('cust_name'));
        $("#customer_no").val($(this).attr('cust_no'));
        $("#email_id").val($(this).attr('cust_email'));
        $("#address1").val($(this).attr('cust_address'));
        $("#tin").val($(this).attr('cust_tin'));
    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
        $('#add_quotation tbody tr td:nth-child(2)').addClass('relative');
        $('#add_quotation tbody tr td:nth-child(2) input').addClass('form-control');
    });

    $('#delete_group').live('click', function () {
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
            var gst = $(this).closest('tr').find('.gst');
            var subtotal = $(this).closest('tr').find('.subtotal');

            if (Number(qty.val()) != 0)
            {
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());
                sub_total = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val())) + (gst1 * Number(qty.val()));
                subtotal.val(sub_total.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + sub_total;
            }
        });
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        $('.final_amt').val((final_sub_total + Number($('.totaltax').val())).toFixed(2));
    }

    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
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
//    $(".cat_id").live('change', function () {
//        var this_ = $(this);
//        this_.closest('tr').find('.model_no,.model_no_ser').val('');
//        if ($(this).val() != '') {
//            this_.closest('tr').find('.model_no,.model_no_ser').removeAttr('readonly');
//            this_.closest('tr').find('.model_no,.model_no_ser').addClass('required');
//        } else {
//            this_.closest('tr').find('.model_no,.model_no_ser').addAttr('readonly');
//            this_.closest('tr').find('.model_no,.model_no_ser').removeClass('required');
//        }
//    });
    $(".model_no").live('keyup', function () {
        var this_ = $(this);
        //cat_id = this_.closest('tr').find('.cat_id').val();
        cat_id = $('#firm').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "delivery_challan/get_product/" + cat_id,
            data: 'q=' + $(this).val(),
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
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.pertax').val($(this).attr('pro_cgst'));
        $(this).closest('tr').find('.gst').val($(this).attr('pro_sgst'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
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
                        $('.cat_id,.model_no,.model_no_ser').val('');
                        //$('.cat_id,.model_no,.model_no_ser').addClass('required');
                        $('.model_no,.model_no_ser').removeAttr('readonly', 'readonly');
//                        $('.model_no').html('');
//                        $('.model_no').attr('readonly', 'readonly');
//                        $('.model_no').removeClass('required');
//                        $('.model_no_ser').html('');
//                        $('.model_no_ser').attr('readonly', 'readonly');
//                        $('.model_no_ser').removeClass('required');
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
                    $('#dc_id').val(data1[0]['prefix']);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {type: data1[0]['prefix'], code: 'DC'},
                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
                        success: function (data2) {
                            $('#dc_id').val(data2);
                            //console.log(data2);
                            var increment_id = $('#dc_id').val().split("/");
                            sales_id = 'DC-' + data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
                            $('#dc_id').val(sales_id);
                        }
                    });
                }
            });
        } else {
            $('.cat_id,.model_no,.model_no_ser').val('');
            //$('.cat_id,.model_no,.model_no_ser').removeClass('required');
            // $('.cat_id').attr('disabled', 'disabled');
            $('.model_no,.model_no_ser').attr('readonly', 'readonly');
        }
    }

</script>

