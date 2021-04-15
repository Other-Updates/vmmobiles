<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .btn-xs
    {
        border-radius: 0px;
    }
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
    .btn-info { background-color:#3db9dc;border-color: #3db9dc;color:#fff;  }
    .btn-info:hover { background-color:#25a7cb;}
    .btn-xs {
        border-radius: 0px !important;
        padding: 2px 5px 1px 5px;
    }
</style>
<div class="mainpanel">
    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Sales Return</h4>
        </div>

        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url'); ?>sales_return/update_po/<?php echo $val['id']; ?>" method="post" class=" panel-body">
                    <div class="row hide_class ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Sales Invoice ID</label>
                                <div class="col-sm-8">
                                    <input type="text"  tabindex="-1" name="po[inv_id]" class=" form-control colournamedup form-align " readonly="readonly" value="<?php echo $val['inv_id']; ?>"  id="grn_no" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Name</label>
                                <div class="col-sm-8">
                                    <input type="text"  name="customer[store_name]" id="customer_name" class='  form-control auto_customer form-align required ' value="<?php echo $val['store_name']; ?>"  readonly="readonly"/>

                                    <input type="hidden"  name="customer[id]" id="customer_id" class=' form-control  id_customer form-align tabwid' value="<?php echo $val['id']; ?>" />
                                    <input type="hidden"  name="po[firm]" id="customer_id" class=' form-control  id_customer form-align tabwid' value="<?php echo $val['firm_id']; ?>" />
                                    <!--<div id="suggesstion-box" class="auto-asset-search"></div>-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Mobile No</label>
                                <div class="col-sm-8">
                                    <input type="text"  name="customer[mobil_number]" class="form-control form-align required " id="customer_no" value="<?php echo $val['mobil_number']; ?>" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Email ID</label>
                                <div class="col-sm-8" id='customer_td'>
                                    <input type="text"  name="customer[email_id]" class=" form-control form-align required " id="email_id" value="<?php echo $val['email_id']; ?>" readonly="readonly"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Address</label>
                                <div class="col-sm-8">
                                    <textarea name="customer[address1]" class=" form-control form-align required" id="address1" readonly="readonly"><?php echo $val['address1']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">GSTIN No</label>
                                <div class="col-sm-8">
                                    <input type="text" name="company[tin_no]" class="form-control form-align" value="<?= $val['tin'] ?>" readonly="readonly" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Customer Po</label>
                                <div class="col-sm-8">
                                    <input type="text"  name="po[customer_po]" class=" form-control form-align required " id="email_id" value="<?php echo $val['customer_po']; ?>" readonly="readonly"/>
                                    <input type="hidden"  name="po[q_id]" class=" form-control form-align"  value="<?php echo $val['q_id']; ?>" readonly="readonly"/>
                                    <input type="hidden"  name="po[customer]" class=" form-control form-align"  value="<?php echo $val['customer']; ?>" readonly="readonly"/>
                                    <input type="hidden"  name="po[payment_status]" class=" form-control form-align"  value="<?php echo $val['payment_status']; ?>" readonly="readonly"/>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="mscroll">
                        <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                            <thead>
                                <tr>
                                    <td width="2%" class="first_td1">S.No</td>
                                    <td width="10%" class="first_td1">Category</td>
                                    <td width="10%" class="first_td1">Product Name</td>
                                    <td width="10%" class="first_td1">Brand</td>
                                    <td width="5%" class="first_td1">Unit</td>
                                    <!--<td width="10%" class="first_td1">Product Description</td>-->
                                    <td  width="8%" class="first_td1 action-btn-align">QTY</td>
                                    <td  width="8%" class="first_td1 action-btn-align">Unit Price</td>
                                    <!--<td  width="7%" class="first_td1">Discount %</td>-->
                                    <td  width="5%" class="first_td1">CGST %</td>
                                    <?php
                                    $gst_type = $po[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="5%" class="first_td1  proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="5%" class="first_td1 proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                    ?>
                                    <td  width="2%" class="first_td1">Net Value</td>

                                </tr>
                            </thead>

                            <tbody id='app_table'>
                                <?php
                                if (isset($po_details) && !empty($po_details)) {
                                    $cgst = 0;
                                    $sgst = 0;
                                    $i = 1;
                                    foreach ($po_details as $vals) {

                                        $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                        $gst_type = $po[0]['state_id'];
                                        if ($gst_type != '') {
                                            if ($gst_type == 31) {

                                                $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                            } else {
                                                $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                            }
                                        }
                                        $cgst += $cgst1;
                                        $sgst += $sgst1;
                                        if (isset($val['round_off']) && $val['round_off'] > 0) {
                                            if ($val['net_total'] > ($val['subtotal_qty'] + $val['transport'] + $val['labour'])) {
                                                $round_off_plus = $val['round_off'];
                                                $round_off_minus = 0;
                                            } else if ($val['net_total'] < ($val['subtotal_qty'] + $val['transport'] + $val['labour'])) {
                                                $round_off_minus = $val['round_off'];
                                                $round_off_plus = 0;
                                            } else {
                                                $round_off_plus = 0;
                                                $round_off_minus = 0;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="action-btn-align s_no">
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <input type="hidden" class='cat_id static_style form-align' name='categoty[]' readonly="" value='<?php echo $vals['cat_id'] ?>'>
                                                <input type="text" class="form-align" readonly="" value='<?php echo $vals['categoryName'] ?>'>
                                            </td>
                                            <td>
                                                <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no required' value="<?php echo $vals['product_name']; ?>" readonly="readonly"/>
                                                <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>" />

                                                <!--<div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>-->
                                            </td>
                                            <td class="action-btn-align">
                                                <input type="text"   tabindex="1"  name='unit[]' style="width:70px;" class="unit" value="<?php echo $vals['unit']; ?>" readonly="readonly"/>
                                            </td>
                                            <td>
                                                <input type="hidden"  name='brand[]' readonly="" value='<?php echo $vals['id'] ?>'>
                                                <input type="text" tabindex="-1" class=" form-align" readonly="" value='<?php echo $vals['brands'] ?>'>
                                            </td>
                    <!--                                        <td>
                                                <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description' readonly="readonly" />  <?php echo $vals['product_description']; ?></textarea>
                                            </td>-->
                                            <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                                                <td align="center">
                                                    <span data-toggle="tooltip" class="tooltips btn btn-primary btn-xs" title="">Invoice Quantity</span><br>
                                                    <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;margin-top:4px;" class="avl_qty1 qty mar_bt" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />
                                                    <br>
                                                    <span data-toggle="tooltip" class="tooltips btn btn-success btn-xs ml-top4" style="margin-bottom:4px;" title="">Stock Quantity</span><br>
                                                    <input type="text"   tabindex="-1"  name='available_quantity[]' style="width:70px;" class="form-control colournamedup tabwid form-align mar_bt" value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>

                                                    <span data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="" style="margin-top:3px;">Return Quantity</span><br>
                                                    <input type="text"   tabindex="-1"  name='return_quantity[]' style="width:70px;margin-top:4px;" class="return_qty mar_bt" />
                                                    <span class="error_msg"></span>
                                                </td>
                                            <?php } else { ?>
                                                <td class="action-btn-align"><div class="avl_qty"></div>
                                                    <span data-toggle="tooltip" class="tooltips btn btn-primary btn-xs" title="">Invoice Quantity</span><br>
                                                    <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;" class="avl_qty1 qty" value="<?php echo $vals['quantity'] ?>" readonly="readonly"/>
                                                    <span data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="">Return Quantity</span><br>
                                                    <input type="text"   tabindex="-1"  name='return_quantity[]' style="width:70px;" class="return_qty" value="0" />
                                                    <span class="error_msg"></span>
                                                </td>
                                            <?php } ?>

                                            <td class="action-btn-align">
                                                <input type="text"   tabindex="-1"  name='per_cost[]' style="width:70px;" class="percost required " value="<?php echo $vals['per_cost'] ?>" readonly="readonly"/>

                                            </td>

                                            <td class="action-btn-align">
                                                <input type="hidden"   tabindex="-1"   name='discount[]' style="width:70px;" class="discount" value="<?php echo $vals['discount'] ?>" readonly="readonly" />
                                                <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" value="<?php echo $vals['tax'] ?>" readonly="readonly" />
                                            </td>
                                            <?php
                                            $gst_type = $po[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td class="action-btn-align">
                                                        <input type="text"  name='gst[]' style="width:70px;" class="gst" value="<?php echo $vals['gst'] ?>" readonly="readonly" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td>
                                                        <input type="text" name='igst[]' style="width:70px;" class="igst" value="<?php echo $vals['igst']; ?>" readonly="readonly"/>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <td>
                                                <input type="text"   tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" value="<?php echo $vals['sub_total'] ?>" readonly="readonly"/>
                                            </td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <tbody>
                            <td colspan="5" style="width:70px; text-align:right;">Total</td>
                            <td><input type="text"   name="po[total_qty]" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px; margin-left:17px;" id="total" /></td>
                            <td colspan="3" style="text-align:right;">Sub Total</td>
                            <td><input type="text" name="po[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /><input type="hidden" class="temp_sub_total" value="" /></td>


                            </tbody>
                            <tbody>
                            <td colspan="9" style="text-align:right;">Advance Amount</td>
                            <td><input type="text" name="advance"  readonly="readonly" value="<?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?>"  class="advance text_right" style="width:70px;" /></td>

                            </tbody>
                            <tbody class="addtional">
                            <td colspan="9" style="text-align:right;">Round Off ( - )<br>

                            </td>
                            <td><input type="text" name="po[round_off]"  value="<?php echo $val['round_off']; ?>"  class="round_off text_right" style="width:70px;" readonly />

                            </td>

                            </tbody>
                            <tbody class="additional">
                            <td colspan="4" style="text-align:right;">CGST:</td>
                            <td><input type="text"  value="<?php echo $val['cgst']; ?>"  readonly class="add_cgst text_right" style="width:70px;" /></td>
                            <?php
                            $gst_type = $po[0]['state_id'];
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
                            <td><input type="text"  value="<?php echo $val['sgst']; ?>"  readonly class="add_sgst text_right" style="width:70px;" /></td>

                            </tbody>
                            <tbody class="addtional">
                            <td colspan="4" style="text-align:right;">Transport Charge</td>
                            <td><input type="text" name="po[transport]"  value="<?php echo $po[0]['transport']; ?>"  class="transport text_right" style="width:70px;" readonly=""/></td>
                            <td colspan="4" style="text-align:right;">Labour Charge</td>
                            <td><input type="text" name="po[labour]"  value="<?php echo $po[0]['labour']; ?>"  class="labour text_right" style="width:70px;" readonly="" /></td>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="width:70px; text-align:right;"></td>
                                    <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td><input type="text"  name="po[net_total]"  readonly="readonly"  class="final_amt text_right" style="width:70px;" value="" /></td>

                                </tr>
                                <tr>
                                    <td colspan="10">
                                        <span>Remarks&nbsp;</span>
                                        <input name="po[remarks]" type="text" tabindex="-1" class="form-control" value="<?php echo $val['remarks']; ?>"  style="width:90%; display: inline"/>
                                    </td>
                                </tr>
                            </tfoot>                                                                                                                                                                                                                                     <!--                            <tfoot>
                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                </tfoot>-->
                            <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>
                        </table>
                    </div>
                    <div class="action-btn-align">

                        <button class="btn btn-info " id="save"> Update </button>
                        <a href="<?php echo $this->config->item('base_url'); ?>sales_return/sales_return_bill/<?php echo $val['id']; ?>" class="tooltips btn btn-info"><span class="glyphicon glyphicon-print"></span> Print </a>
                        <a href="<?php echo $this->config->item('base_url') . 'sales_return/' ?>" class="btn btn-defaultback1"><span class="glyphicon"></span> Back </a>
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
        $('.return_qty').each(function () {

            var qty = $(this).closest('tr').find('.avl_qty1').val();
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
            return false;
        }

    });

    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();

        calculate_function();
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

    $('.qty,.percost,.pertax,.totaltax,.return_qty,.gst,.igst,.discount').live('keyup', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        var transport = Number($('.transport').val());
        var labour = Number($('.labour').val());
        var advance = Number($('.advance').val());
        var cgst = 0;
        var sgst = 0;
        $('.return_qty').each(function () {
            var rq = $(this).closest('tr').find('.return_qty');
            var qty = $(this).closest('tr').find('.qty');
            var percost = $(this).closest('tr').find('.percost');
            var pertax = $(this).closest('tr').find('.pertax');
            var subtotal = $(this).closest('tr').find('.subtotal');
            // var transport = $(this).closest('tr').find('.transport');
            // var labour = $(this).closest('tr').find('.labour');
            var round_off = $(this).closest('tr').find('.round_off');
            if ($('#gst_type').val() != '')
            {
                if ($('#gst_type').val() == 31)
                {
                    gst = $(this).closest('tr').find('.gst');

                } else {
                    gst = $(this).closest('tr').find('.igst');
                }
            }

            // var subtotal = $(this).closest('tr').find('.subtotal');
            //  var discount = $(this).closest('tr').find('.discount');
            if (Number(qty.val()) != 0)
            {
                tot = Number(qty.val()) * Number(percost.val());
                $(this).closest('tr').find('.gross').val(tot);
                taxless = Number(qty.val()) * Number(percost.val());
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                gst1 = Number(gst.val() / 100) * Number(percost.val());

                // cgst += Number(pertax.val() / 100) * taxless;
                // sgst += Number(gst.val() / 100) * taxless;

                cgst += (pertax1 * (Number(qty.val()) - Number(rq.val())))
                sgst += (gst1 * (Number(qty.val()) - Number(rq.val())))
                // discount1 = Number(discount.val() / 100) * Number(percost.val());
                var discount1 = 0;

                sub_total1 = ((Number(qty.val()) - Number(rq.val())) * Number(percost.val()));
                sub_total = sub_total1 - (discount1 * (Number(qty.val()) - Number(rq.val())));
                subtotal.val(sub_total.toFixed(2));
                final_qty = final_qty + (Number(qty.val()) - Number(rq.val()));
                final_sub_total = final_sub_total + sub_total;
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
