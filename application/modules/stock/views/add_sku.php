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
    .auto-asset-search ul {
        padding:0px;
    }
    .auto-asset-search
    {
        position:absolute !important;
        width:100%;
    }
    .auto-asset-search ul#country-list li
    {
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
    ul li {
        list-style-type: none;
    }
    #suggesstion-box{
        z-index: 99;
    }
</style>
<?php
$model_numbers_json = array();
if (!empty($products)) {
    foreach ($products as $list) {
        $model_numbers_json[] = '{ label: "' . $list['product_name'] . '", value: "' . $list['id'] . '"}';
    }
}
?>
<div class="mainpanel">
    <!--  <div class="pageheader">
          <div class="media">
              <div class="pageicon pull-left">
                  <i class="fa fa-quote-right iconquo"></i>
              </div>
              <div class="media-body">
                  <ul class="breadcrumb">
                      <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                      <li>Home</li>
                      <li>Add</li>
                  </ul>
                  <h4>Add Quotation</h4>
              </div>
          </div>
      </div>-->
    <div id='empty_data'></div>
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Add New SKU</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td>
                    <select id='cat_id' class='cat_id static_style class_req form-control form-align' style="width:100%" name='categoty[]'>
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
                    <input type="text"  name="model_no[]" style="width:100%" id="model_no" class='form-control form-align auto_customer tabwid model_no' tabindex="1"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td >
                    <select  name='brand[]' tabindex="1" class="form-control form-align brand_id">
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
                    <select id='b_id' name='sku_type[]' tabindex="1" class="form-control form-align">
                        <option value="">Select</option>
                        <option value="1">Remove</option>
                        <option value="2">Add</option>

                    </select>
                    <span class="error_msg"></span>
                </td>

                <td>
                    <input type="text"   tabindex="1" id="stock"  name='stock[]' style="width:70px;" class="stock  form-control form-align" readonly="" />
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1" id="qty"  name='quantity[]' style="width:70px;" class="qty percost form-control form-align" />
                    <span class="error_msg"></span>
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
                                <select onchange="Firm(this.value)" name="sku[firm_id]"  class="form-control form-align" id="firm"  tabindex="1">
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
                                <select onchange="Firm(this.value)" name="sku[firm_id]"  class="form-control form-align" id="firm" readonly=""  tabindex="1">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label first_td1">SKU NO</label>
                        <div class="col-sm-8">
                            <input type="text"  tabindex="1" name="sku[sku_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $last_id[0]['value']; ?>"  id="grn_no">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">SKU Date</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" tabindex="1"  class="form-align datepicker required " name="sku[sku_date]" placeholder="dd-mm-yyyy" >
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
                            <td width="15%" class="first_td1">Category</td>
                            <td width="30%" class="first_td1">Product Name</td>
                            <td width="10%" class="first_td1">Brand</td>
                            <td width="10%" class="first_td1">Type</td>
                            <td width="8%" class="first_td1 action-btn-align">STOCK</td>
                            <td width="5%" class="first_td1 action-btn-align">QTY(Reqest/return)</td>
                            <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Row</a></td>
                        </tr>
                    </thead>
                    <tbody id='app_table'>
                        <tr>
                            <td>
                                <select id='cat_id' class='cat_id static_style class_req required form-control form-align' name='categoty[]' style="width:100%">
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
    <!--                            <td class="sub_category">
                                <select class=" static_color" name='sub_categoty[]'>
                                    <option value="">select</option>
                                </select>
                            </td>-->
                            <td class="relative">
                                <input type="text"  name="model_no[]" id="model_no" style="width:100%" class='form-align auto_customer model_no required form-control' tabindex="1" readonly="" />
                                <span class="error_msg"></span>
                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' />
                                <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                                <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>

                            </td>
                            <td >
                                <select id='brand_id' name='brand[]' tabindex="1" class="form-control form-align brand_id">
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
                                <select id='b_id' class="required form-control form-align" name='sku_type[]' tabindex="1">
                                    <option value="">Select</option>
                                    <option value="1">Remove</option>
                                    <option value="2">Add</option>
                                </select>
                                <span class="error_msg"></span>
                            </td>

                            <td>
                                <input type="text" id="stock"   tabindex="1"  name='stock[]' style="width:70px;" class="stock form-control form-align" readonly="" />
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <input type="text"   tabindex="1" id="qty"  name='quantity[]' style="width:70px;" class="qty percost required form-control form-align" />
                                <span class="error_msg"></span>
                            </td>
                            <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                                                        <!--<td></td>-->
                        </tr>
                    </tbody>
                    <tfoot>
    <!--                    <tr>
                            <td colspan="4" style="width:70px; text-align:right;"><b>Total</b></td>
                            <td><input type="text"   name="po[total_qty]"  tabindex="1" readonly="readonly" class="total_qty" style="width:70px;" id="total" /></td>

                            <td></td>
                            <td></td>
                        </tr>-->
    <!--                    <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="1" name="po[tax_label]" class='tax_label text_right'    style="width:100%;" /></td>
                            <td>
                                <input type="text"  name="po[tax]" class='totaltax text_right'  tabindex="1"  style="width:70px;" />
                            </td>
                            <td></td>
                        </tr>-->
    <!--                    <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="1" class="final_amt text_right" style="width:70px;" /></td>
                            <td></td>
                        </tr>-->
                        <tr>
                            <td colspan="10">
                                <span class="remark">Remarks</span>
                                <input name="sku[remarks]"  type="text" class="form-control"  tabindex="1"/>
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

        if (m > 0) {
            $('html, body').animate({
                scrollTop: ($('.error_msg:visible').offset().top - 60)
            }, 500);
            return false;
        }

    });


    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_customer",
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
    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.qty').addClass('required');
        $('#app_table').append(tableBody);
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

    $('.stock,.percost,.pertax,.totaltax,.gst').live('keyup', function () {
        calculate_function();
    });
    $('.stock,.percost,.pertax,.totaltax,.gst').live('change', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        $('.stock').each(function () {
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
    /*$(document).ready(function () {
     //        $('body').on('keydown', '#add_quotation input.model_no', function (e) {
     //            // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
     cat_id = $('#firm').val();
     cust_id = $('#customer_id').val();
     var product_data = [];

     $.ajax({
     type: 'POST',
     data: {firm_id: cat_id},
     url: '<?php echo base_url(); ?>quotation/get_product_by_frim_id',
     success: function (data) {

     product_data = JSON.parse(data);

     $(".model_no").blur(function () {
     var keyEvent = $.Event("keydown");
     keyEvent.keyCode = $.ui.keyCode.ENTER;
     $(this).trigger(keyEvent);
     // Stop event propagation if needed
     return false;
     }).autocomplete({
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
     delay: 0,
     autoFill: false,
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

     result = JSON.parse(data);
     if (result != null && result.length > 0) {
     this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
     this_val.closest('tr').find('.cat_id').val(result[0].category_id);
     this_val.closest('tr').find('.pertax').val(result[0].cgst);
     this_val.closest('tr').find('.gst').val(result[0].sgst);
     this_val.closest('tr').find('.discount').val(result[0].discount);
     this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
     this_val.closest('tr').find('.type').val(result[0].type);
     this_val.closest('tr').find('.product_id').val(result[0].id);
     this_val.closest('tr').find('.model_no').val(result[0].product_name);
     this_val.closest('tr').find('.product_description').val(result[0].product_description);

     var pro_id = this_val.closest('tr').find('.product_id').val();
     var cat_id = this_val.closest('tr').find('.cat_id').val();
     var current = this_val;
     $.ajax({
     type: 'POST',
     data: {pro_id: pro_id, cat_id: cat_id},
     url: '<?php echo base_url(); ?>stock/sku_management/get_stock_by_product',
     success: function (data) {

     result = JSON.parse(data);
     if (result != null && result.length > 0) {
     var stock = result[0]['stock'];
     current.closest('tr').find('.stock').val(stock);


     }
     }
     });
     calculate_function();
     $('#add_group').trigger('click');
     }
     }
     });
     }
     });
     }
     });
     });

     });*/

    $('body').on('keydown', '#add_quotation input.model_no', function (e) {
        // var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
        var _this = $(this);
        $('#add_quotation tbody tr input.model_no').autocomplete({
            source: function (request, response) {
                var val = _this.closest('tr input.model_no').val();
                cat_id = $('#firm').val();
                cust_id = $('#customer_id').val();
                var product_data = [];
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
                leng = product_data.length;
                for (var i = 0; i < leng; i++) {
                    if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                        outputArray.push(product_data[i]);
                    }
                }
                response(outputArray.slice(0, 10));
            },
            // position: {collision: "flip"},
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
                    data: {model_number_id: model_number_id, c_id: cust_id, firm_id: $('#firm').val(), cat_it: cat_it},
                    url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/",
                    success: function (data) {
                        result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            this_val.closest('tr').find('.brand_id').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                            this_val.closest('tr').find('.pertax').val(result[0].cgst);
                            this_val.closest('tr').find('.gst').val(result[0].sgst);
                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                            this_val.closest('tr').find('.type').val(result[0].type);
                            this_val.closest('tr').find('.product_id').val(result[0].id);
                            this_val.closest('tr').find('.model_no').val(result[0].product_name);
                            this_val.closest('tr').find('.product_description').val(result[0].product_description);

                            var pro_id = this_val.closest('tr').find('.product_id').val();
                            var cat_id = this_val.closest('tr').find('.cat_id').val();
                            var current = this_val;
                            $.ajax({
                                type: 'POST',
                                data: {pro_id: pro_id, cat_id: cat_id},
                                url: '<?php echo base_url(); ?>stock/sku_management/get_stock_by_product',
                                success: function (data) {

                                    result = JSON.parse(data);
                                    if (result != null && result.length > 0) {
                                        var stock = result[0]['stock'];
                                        current.closest('tr').find('.stock').val(stock);


                                    }
                                }
                            });
                            calculate_function();
                            $('#add_group').trigger('click');
                            this_val.closest('tr').find('.qty').focus();
                        }
                    }
                });
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
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        var pro_id = $(this).closest('tr').find('.product_id').val();
        var cat_id = $(this).closest('tr').find('.cat_id').val();
        var current = $(this);
        $.ajax({
            type: 'POST',
            data: {pro_id: pro_id, cat_id: cat_id},
            url: '<?php echo base_url(); ?>stock/sku_management/get_stock_by_product',
            success: function (data) {

                result = JSON.parse(data);
                if (result != null && result.length > 0) {
                    var stock = result[0]['stock'];
                    current.closest('tr').find('.stock').val(stock);


                }
            }
        });
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
                        $('.model_no,.model_no_ser').removeAttr('readonly', 'readonly');

                    } else {
                        $('.cat_id,.model_no,.model_no_ser').val('');
                        $('.model_no,.model_no_ser').attr('readonly', 'readonly');
                    }
                }
            });
        } else {
            $('.cat_id,.model_no,.model_no_ser').val('');
            $('.model_no,.model_no_ser').attr('readonly', 'readonly');
        }
    }

</script>

