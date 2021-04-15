<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>

<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>

<style type="text/css">

    .btn-xs { border-radius: 0px !important;padding: 2px 5px 1px 5px; }

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

    ul li {

        list-style-type: none;

    }

    .ml-top4 { margin-top:4px; }

    .form-control1 {

        cursor: not-allowed;

        background-color: #e9edf0;

        opacity: 1;

    }

</style>

<div class="mainpanel">

    <div id='empty_data'></div>

    <div class="contentpanel mb-25">

        <div class="media">

            <h4>Return Purchase Order</h4>

        </div>



        <?php

        if (isset($po) && !empty($po)) {

            foreach ($po as $val) {

                ?>

                <form  action="<?php echo $this->config->item('base_url'); ?>purchase_return/update_po/<?php echo $val['id']; ?>" method="post" class=" panel-body">



                    <div class="row">

                        <div class="col-md-4">



                            <div class="form-group">

                                <label class="col-sm-4 control-label">Shop Name</label>

                                <div class="col-sm-8">

                                    <select name="po[firm_id]"  class="form-control form-align" id="firm" disabled="">

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

                                <label class="col-sm-4 control-label first_td1">PO NO</label>

                                <div class="col-sm-8">

                                    <input type="text"  tabindex="-1" name="po[po_no]" class=" form-control colournamedup form-align " readonly="readonly" value="<?php echo $val['po_no']; ?>"  id="grn_no" >

                                    <input type="hidden"  name="po[pr_no]" readonly="readonly" value="<?php echo $val['pr_no']; ?>" >

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-sm-4 control-label">Supplier Name</label>

                                <div class="col-sm-8">

                                    <input type="text"  name="supplier[store_name]" id="customer_name" class='  form-control auto_customer form-align required ' value="<?php echo $val['store_name']; ?>"  readonly="readonly"/>



                                    <input type="hidden"  name="supplier[id]" id="customer_id" class=' form-control  id_customer form-align tabwid' value="<?php echo $val['id']; ?>" />

                                    <div id="suggesstion-box" class="auto-asset-search"></div>

                                </div>

                            </div>



                        </div>

                        <div class="col-md-4">



                            <div class="form-group">

                                <label class="col-sm-4 control-label first_td1">Supplier Mobile No</label>

                                <div class="col-sm-8">

                                    <input type="text"  name="supplier[mobil_number]" class="form-control form-align" id="customer_no" value="<?php echo $val['mobil_number']; ?>" readonly="readonly"/>

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-sm-4 control-label first_td1">Supplier Email ID</label>

                                <div class="col-sm-8" id='customer_td'>

                                    <input type="text"  name="supplier[email_id]" class=" form-control form-align " id="email_id" value="<?php echo $val['email_id']; ?>" readonly="readonly"/>

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-sm-4 control-label first_td1">GSTIN No</label>

                                <div class="col-sm-8">

                                    <input type="text" name="company[tin_no]" id="tin" class="form-control form-align" value="<?php echo $val['tin']; ?>" readonly="readonly" />

                                </div>

                            </div>



                        </div>

                        <div class="col-md-4">



                            <div class="form-group">

                                <label class="col-sm-4 control-label first_td1">Supplier Address</label>

                                <div class="col-sm-8">

                                    <textarea name="supplier[address1]" class=" form-control form-align" id="address1" readonly="readonly"><?php echo $val['address1']; ?></textarea>

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-sm-4 control-label">Purchase Return Date</label>

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

                                    <td width="10%" class="first_td1">Category</td>

                                    <td width="10%" class="first_td1">Product</td>

                                    <td width="10%" class="first_td1">Model</td>

                                    <td width="8%" class="first_td1">Unit</td>

                                    <td width="8%" class="first_td1">QTY</td>

                                    <td width="8%" class="first_td1">Delivery QTY</td>

                                    <td width="8%" class="first_td1">Unit Price</td>

                                    <td width="7%" class="first_td1">Discount %</td>

                                    <td width="5%" class="first_td1">CGST %</td>

                                    <?php

                                    $gst_type = $po[0]['state_id'];

                                    if ($gst_type != '') {

                                        if ($gst_type == 31) {

                                            ?>

                                            <td  width="5%" class="first_td1 action-btn-align" >SGST %</td>

                                        <?php } else { ?>

                                            <td  width="5%" class="first_td1 action-btn-align" >IGST %</td>



                                            <?php

                                        }

                                    }

                                    ?>

                                    <td width="5%" class="first_td1">Transport</td>

                                    <td width="5%" class="first_td1">Net Value</td>

                                </tr>

                            </thead>

                            <tbody id='app_table'>

                                <?php

                                if (isset($po_details) && !empty($po_details)) {                                   
// echo "<pre>";

                                   // print_r($po_details);

                                   //exit;

                                    $delivery_qty_total = $over_all_net_total = 0;
                                   

                                    foreach ($po_details as $vals) {

                                        //echo $vals['erp_pr_id'];



                                        $deliver_qty = $vals['delivery_qty'];

                                        $per_cost = $vals['per_cost'];

                                        $gst = $vals['tax'];

                                        $cgst = $vals['gst'];

                                        $net_total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst / 100) + (($deliver_qty * $per_cost) * $cgst / 100) - $vals['discount'] + $vals['transport'];



                                        $over_all_net_total += $net_total;

                                        $delivery_qty_total +=$vals['delivery_qty'];

                                        ?>

                                    <input type="hidden"  name='id[]'  value='<?php echo $vals['erp_pr_id'] ?>'>

                                    <tr>

                                        <td>

                                            <input type="hidden" class='cat_id static_style form-align' name='categoty[]' readonly="" value='<?php echo $vals['cat_id'] ?>'>

                                            <input type="text" class="form-align" readonly="" value='<?php echo $vals['categoryName'] ?>'>

                                        </td>

                                        <td>

                                            <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['product_name']; ?>" readonly="readonly"/>

                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />



                                            <!--<div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>-->

                                        </td>

                                        <td>

                                            <input type="hidden"  name='brand[]' readonly="" value='<?php echo $vals['id'] ?>'>

                                            <input type="text"  class=" form-align" readonly="" value='<?php echo!empty($vals['brands']) ? $vals['brands'] : '-'; ?>'>

                                        </td>

                                        <td>

                                            <input type="text"  name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit'] ?>" readonly="readonly"/>

                                        </td>



                                        <?php //if (isset($vals['stock']) && !empty($vals['stock'])) {           ?>

                                        <td align="center">

                                            <span data-toggle="tooltip" class="tooltips btn btn-primary btn-xs" title="">Purchase Order Quantity</span> &nbsp;

                                            <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;margin-top:4px;margin-bottom:4px; margin-right:6px;" class="qty" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />

                                            <br>

                <!--                                                <span data-toggle="tooltip" class="tooltips btn btn-success btn-xs ml-top4" style="margin-bottom:4px;margin-top:4px;" title="">Stock Quantity</span> &nbsp;

                                            <input type="text"   tabindex="-1"  name='available_quantity[]' style="width:70px;margin-top:4px !important;" class="avl_qty qty " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/> <br>-->





                                        </td>

                                        <?php /* }  else { ?>

                                          <td><div class="avl_qty"></div>

                                          <input type="text"   tabindex="-1"  name='return_quantity[]' style="width:70px;" class="qty" value="<?php echo $vals['quantity'] ?>" readonly="readonly"/>



                                          </td>

                                          <?php // } */ ?>

                                        <td>

                                            <span data-toggle="tooltip" class="tooltips btn btn-success btn-xs" style="margin-bottom:4px;margin-top:4px;" title="">Delivered Quantity</span> &nbsp;

                                            <input type="text"   tabindex="-1"  name='delivery_quantity[]' style="width:70px;" class="delivery_qty" value="<?php echo $vals['delivery_qty'] ?>" readonly="readonly"/>

                                            <br>

                                            <?php if ($vals['po'][0]['delivery_qty'] == 0) { ?>

                                                <span data-toggle="tooltip" class="tooltips btn btn-success btn-xs" style="margin-bottom:4px;margin-top:4px;" title="">Return Quantity</span> &nbsp;



                                                <input type="text"   tabindex="-1"  name='return_quantity[<?php echo $vals['erp_pr_id'] ?>][]' style="width:70px;margin-top:4px !important;" class="return_qty" readonly="readonly"/>

                                                <span class="error_msg"></span>

                                            <?php } else { ?>

                                                <span data-toggle="tooltip" class="tooltips btn btn-success btn-xs" style="margin-bottom:4px;margin-top:4px;" title="">Return Quantity</span> &nbsp;

                                                <input type="text"   tabindex="-1"  name='return_quantity[<?php echo $vals['erp_pr_id'] ?>][]' style="width:70px;margin-top:4px !important;" class="return_qty" />

                                                <span class="error_msg"></span>

                                            <?php } ?>

                                        </td>

                                        <td>

                                            <input type="text"   tabindex="-1"  name='per_cost[]' style="width:70px;" class="percost required " value="<?php echo $vals['per_cost'] ?>" readonly="readonly"/>



                                        </td>

                                        <td>

                                            <input type="text"   tabindex="-1"   name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount'] ?>" readonly="readonly" />

                                        </td>



                                        <td>

                                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" readonly="readonly" />

                                        </td>

                                        <?php

                                        $gst_type = $po[0]['state_id'];

                                        if ($gst_type != '') {

                                            if ($gst_type == 31) {

                                                ?>

                                                <td>

                                                    <input type="text"   tabindex="-1"   name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst'] ?>" readonly="readonly" />

                                                </td>

                                            <?php } else { ?>

                                                <td>

                                                    <input type="text"   tabindex="-1"   name='igst[]' style="width:70px;" class="igst" value="<?php echo $vals['igst'] ?>" readonly="readonly" />

                                                </td>



                                                <?php

                                            }

                                        }

                                        ?>

                                        <td>

                                            <input type="text"   tabindex="-1"   name='transport[]' style="width:70px;" class="transport" value="<?php echo $vals['transport'] ?>" readonly="readonly" />

                                        </td>



                                        <td>

                                            <input type="text"   tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" readonly="readonly" value="<?php echo $net_total; ?>"/>

                                        </td>



                                    </tr>

                                    <?php

                                }

                            }

                            ?>

                            </tbody>



                            <tfoot>

                                <tr>

                                    <td colspan="5" style="width:70px; text-align:right;"><b>Total</b></td>

                                    <td align="center"><input type="text"   name="po[total_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $delivery_qty_total; ?>" class="total_qty" style="width:70px; margin-left:-33px;" id="total" readonly="readonly"/></td>

                                    <td colspan="5" style="text-align:right;"><b>Sub Total</b></td>

                                    <td><input type="text" name="po[subtotal_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $over_all_net_total; ?>"  class="final_sub_total text_right" style="width:70px;" readonly="readonly"/></td>



                                </tr>

                                <tr>

                                    <td colspan="5" style="width:70px; text-align:right;"></td>

                                    <td colspan="6" style="text-align:right;font-weight:bold;"><input type="text"  name="po[tax_label]" class='tax_label text_right'    style="width:70px;" value="<?php echo $val['tax_label']; ?>" readonly="readonly"/></td>

                                    <td>

                                        <input type="text"  name="po[tax]" class='totaltax text_right'  value="<?php echo $val['tax']; ?>"  style="width:70px;" readonly="readonly"/>

                                    </td>



                                </tr>

                                <tr>

                                    <td colspan="5" style="width:70px; text-align:right;"></td>

                                    <td colspan="6"style="text-align:right;font-weight:bold;">Net Total</td>

                                    <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt text_right" style="width:70px;" value="<?php echo $over_all_net_total; ?>" readonly="readonly"/></td>



                                </tr>

                                <tr>



                                    <td colspan="13" style="">

                                        <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>

                                        <input name="po[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" readonly="readonly"/>

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

                                        <input type="text" class="form-control datepicker class_req borderra0 terms" name="po[delivery_schedule]" value="<?php echo $val['delivery_schedule']; ?>" placeholder="dd-mm-yyyy" readonly="readonly">

                                        <span id="colorpoerror" style="color:#F00;" ></span>

                                    </div>

                                </div>

                            </div>



                            <div class="form-group">

                                <label class="col-sm-4 control-label">2. Mode of Payment</label>

                                <div class="col-sm-8">

                                    <div>

                                        <input type="text" class="form-control class_req borderra0 terms" value="<?php echo $val['mode_of_payment']; ?>" name="po[mode_of_payment]" readonly="readonly"/>

                                    </div>

                                </div>

                            </div>



                        </div>

                        <div class="col-md-6">

                        </div>

                    </div>

                    <input type="hidden"  name="po[supplier]" id="customer_id" class='id_customer' value="<?php echo $val['id']; ?>"/>

                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>

                    <div class="action-btn-align">



                        <button class="btn btn-info1 " id="save"> Update </button>

                        <a href="<?php echo $this->config->item('base_url') . 'purchase_return/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                    </div>

                </form>



                <?php

            }

        }

        ?>

    </div><!-- contentpanel -->

</div><!-- mainpanel -->



<script type="text/javascript">





    $('#save').live('click', function () {



        $('.return_qty').each(function () {

            m = 0;

            var qty = $(this).closest('tr').find('.delivery_qty').val();



            this_val = $.trim($(this).val());



            //  if (parseInt(this_val) > parseInt($.trim(qty))) {

            if (Number(this_val) > Number(qty))

            {

                $(this).closest('tr').find('span.error_msg').text('This field more than the Delivered quantity').css('display', 'inline-block');

                m = 1;

            } else {

                $(this).closest('tr').find('.error_msg').text("");

            }

        });

        if (m == 1)

        {

            return false;

        } else

        {

            return true;

        }



    });

    $(document).on('blur', '.return_qty', function () {

        var qty = $(this).closest('tr').find('.delivery_qty').val();



        this_val = $.trim($(this).val());



        if (parseInt(this_val) > parseInt($.trim(qty))) {

            $(this).closest('tr').find('span.error_msg').text('This field more than the Delivered quantity').css('display', 'inline-block');

        } else {

            $(this).closest('tr').find('.error_msg').text("");

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

    });



    $('.cust_class').live('click', function () {

        $("#customer_id").val($(this).attr('cust_id'));

        $("#cust_id").val($(this).attr('cust_id'));

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





    $('.qty,.percost,.pertax,.totaltax,.return_qty').live('keyup', function () {

        calculate_function();

    });

    function calculate_function()

    {

        var final_qty = 0;

        var final_sub_total = 0;

        $('.return_qty').each(function () {

            var rq = $(this).closest('tr').find('.return_qty');

            // var qty = $(this).closest('tr').find('.qty');

            var qty = $(this).closest('tr').find('.delivery_qty');

            var percost = $(this).closest('tr').find('.percost');

            var pertax = $(this).closest('tr').find('.pertax');



            if ($('#gst_type').val() != '')

            {

                if ($('#gst_type').val() == 31)

                {

                    gst = $(this).closest('tr').find('.gst');



                } else {

                    gst = $(this).closest('tr').find('.igst');

                }

            }



            var subtotal = $(this).closest('tr').find('.subtotal');

            var discount = $(this).closest('tr').find('.discount');

            var transport = $(this).closest('tr').find('.transport');



            if ((Number(qty.val()) - Number(rq.val())) != 0)

            {



                pertax1 = Number(pertax.val() / 100) * Number(percost.val());

                gst1 = Number(gst.val() / 100) * Number(percost.val());

                discount1 = Number(discount.val() / 100) * Number(percost.val());

                sub_total1 = ((Number(qty.val()) - Number(rq.val())) * Number(percost.val())) + (pertax1 * (Number(qty.val()) - Number(rq.val()))) + (gst1 * (Number(qty.val()) - Number(rq.val())));

                sub_total = (sub_total1 + Number(transport.val())) - (discount1 * (Number(qty.val()) - Number(rq.val())));

                subtotal.val(sub_total.toFixed(2));

                final_qty = final_qty + (Number(qty.val()) - Number(rq.val()));

                final_sub_total = final_sub_total + sub_total;

            } else {

                sub_total = 0

                subtotal.val(sub_total.toFixed(2));

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

    $(".model_no").live('keyup', function () {

        var this_ = $(this)

        $.ajax({

            type: "GET",

            url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product",

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

        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));

        $(this).closest('tr').find('.model_no').val($(this).attr('pro_name'));

        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));

        $(this).closest('tr').find(".suggesstion-box1").hide();

    });



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

</script>

