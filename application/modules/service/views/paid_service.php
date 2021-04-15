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
    .auto-asset-search
    {
        position:absolute !important;
    }
    .auto-asset-search ul#country-list li
    {
        margin-left:-40px !important;
        width:170px;
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
    .cust-wid { width:89%; }
</style>
<div class="mainpanel">         
    <div id='empty_data'></div>
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Add Project Cost</h4>
        </div>
        <table class="static1" style="display: none;">
            <tr>
                <td colspan="2" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" tabindex="1" name="item_name[]" class="tax_label text_right" style="width:100%;" ></td>
                <td>
                    <input type="text" tabindex="1"  name="amount[]" class="totaltax text_right"  style="width:100%;" >
                    <input type="hidden" name="type[]" class="text_right"  value="invoice" style="width:70px;" >
                </td>
                <td width="2%" class="action-btn-align"><a id='delete_label' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <table class="static" style="display: none;">
            <tr>
                <td>
                    <select id='' class='cat_id static_style class_req' tabindex="1"  name='categoty[]'>
                        <option>Select</option>
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
                    <select name='brand[]' tabindex="1" >
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
                <td >
                    <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' tabindex="1"  />
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-align type' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td> 
                <td>
                    <textarea  name="product_description[]" tabindex="1"  id="product_description" class='form-align auto_customer tabwid product_description' />  </textarea>                             
                </td> 

                <td>
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="sell_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
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
                    <select id='' class='cat_id static_style class_req' tabindex="1"  name='categoty[]'>
                        <option>Select</option>
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
                    <select name='brand[]' tabindex="1" >
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
                <td >
                    <input type="text"  name="model_no[]" id="model_no_ser" class='form-align auto_customer tabwid model_no_ser' tabindex="1" />
                    <span class="error_msg"></span>
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-align type_ser' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td> 
                <td>
                    <textarea  name="product_description[]" id="product_description" tabindex="1"  class='form-align auto_customer tabwid product_description' />  </textarea>                             
                </td> 
                <td>
                    <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="sell_price percost " id="price"/>
                    <span class="error_msg"></span>
                </td>
                <td>
                    <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td>
                    <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <form  action="<?php echo $this->config->item('base_url'); ?>service/paid_service_add" method="post" class="panel-body">
            <table  class="table table-striped  responsive dataTable no-footer dtr-inline">
                <tr>
                    <td class="first_td1">Reference Name</td>
                    <td>
                        <select id='ref_class'  tabindex="1"  class='nick static_style class_req required' name='quotation[ref_name]' style="width:170px;">
                            <option>Select</option>
                            <?php
                            if (isset($nick_name) && !empty($nick_name)) {
                                foreach ($nick_name as $val) {
                                    ?>
                                    <option  value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?>-<?php echo $val['nick_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <span class="error_msg"></span>
                    </td>
                    <td class="first_td1">Quotation NO</td>
                    <td> <input type="text"  tabindex="1" name="quotation[q_no]" class="code form-control colournamedup tabwid form-align" readonly="readonly" value="<?php echo $gno; ?>"  id="grn_no"></td>
                    <td>Company Name</td>
                    <td>
                        <input type="hidden"  name="quotation[type]" value="indirect" />
                        <input type="hidden"  name="quotation[job_id]"value="<?php echo $last_id[0]['value']; ?>"  />
                        <input type="text"  name="customer[name]" id="customer_name" tabindex="1"  class='form-align auto_customer tabwid' />
                        <span class="error_msg"></span>
                        <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer tabwid form-align required' />
<!--                              <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                        <div id="suggesstion-box" class="auto-asset-search "></div>
                    </td>
                </tr>
                <tr>
                    <td class="first_td1">Customer Mobile No</td>
                    <td>
                        <input type="text"  name="customer[mobil_number]" tabindex="1"  id="customer_no" class="form-align tabwid required" />
                        <span class="error_msg"></span>
                    </td>
                    <td class="first_td1"  >Customer Email ID</td>
                    <td id='customer_td'>
                        <input type="text"  name="customer[email_id]" tabindex="1" id="email_id" class="form-align tabwid required"/>
                        <span class="error_msg"></span>
                    </td> 
                    <td class="first_td">Tin No</td>
                    <td><input type="text" name="company[tin_no]"  value="<?= $company_details[0]['tin_no'] ?>" style="width:170px;" readonly="readonly" />
                    </td>             
                </tr>
                <tr>
                    <td class="first_td1">Customer Address</td>
                    <td colspan="3">
                        <textarea name="customer[address1]" id="address1" tabindex="1"  class="form-align cust-wid required"></textarea>
                        <span class="error_msg"></span>
                    </td>  
                     <td>Date</td>
                    <td> 
                        <input type="text" tabindex="1"  class="form-align datepicker tabwid required" name="quotation[created_date]" placeholder="dd-mm-yyyy" >
                          <span class="error_msg"></span>
                    </td>
                </tr>               
            </table>

            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                <thead>
                    <tr>
                        <td width="10%" class="first_td1">Category</td>
                        <td width="10%" class="first_td1">Brand</td>   
                        <td width="10%" class="first_td1">Model Number</td>  
                        <td width="10%" class="first_td1">Product Description</td>
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="5%" class="first_td1">Cost/QTY</td>
                        <td  width="5%" class="first_td1">VAT %</td>
                        <td  width="5%" class="first_td1">Net Value</td>
                        <td width="5%" class="action-btn-align">
                            <a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Product</a>
                            <a id='add_group_service' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Service</a>
                        </td>
                    </tr>
                </thead>
                <tbody id='app_table'>
                    <tr>
                        <td>
                            <select id='' tabindex="1"  class='cat_id static_style class_req required' name='categoty[]'>
                                <option>Select</option>
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
                            <select name='brand[]'  tabindex="1" class="required">
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
                        <td>
                            <input type="text"  name="model_no[]"  tabindex="1" id="model_no_ser" class='form-align auto_customer tabwid model_no_ser' />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-align type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]"  tabindex="1" id="product_description" class='form-align auto_customer tabwid product_description' />  </textarea>                             
                        </td> 
                        <td>
                            <input type="text"   tabindex="1"  name='quantity[]' style="width:70px;" class="qty required" />
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="1"  name='per_cost[]' style="width:70px;" class="sell_price percost required" />
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="1"   name='tax[]' style="width:70px;" class="pertax" />
                        </td>
                        <td>
                            <input type="text"   tabindex="1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" />
                        </td>
                        <td></td>
<!--                            <td class="action-btn-align"><a id='delete_group' class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span></a></td>-->
                    </tr>
                </tbody>
                <tbody>
                <td colspan="4" style="width:70px; text-align:right;">Total</td>
                <td><input type="text"   name="quotation[total_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty" style="width:70px;" id="total" /></td>
                <td colspan="2" style="text-align:right;">Sub Total</td>
                <td><input type="text" name="quotation[subtotal_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total text_right" style="width:70px;" /></td>
                <td></td>
                </tbody>
                <tbody class="add_cost">
                <td colspan="2" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                <td>
                    <input type="text"  name="quotation[tax]" class='totaltax text_right'  value="<?php echo $val['tax']; ?>"  style="width:70px;" />
                </td>
                <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add </a></td>
                </tbody>
                <tfoot>                       
                    <tr>
                        <td colspan="2" style="width:70px; text-align:right;"></td>
                        <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                        <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt text_right" style="width:70px;" value="<?php echo $val['net_total']; ?>" /></td>
                        <td></td>
                    </tr>
                    <tr>

                        <td colspan="9" style="">
                            <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span> 
                            <input name="quotation[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table class="table table-striped" style="width:100%;border:1 solid #CCC;">
                <tr>
                    <td  style="width:100%;">
                        <table style="width:100%;">
                            <tr>
                                <td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Delivery Schedule</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:98%;">
                                        <input type="text" class="form-control datepicker class_req borderra0 terms" name="quotation[delivery_schedule]" placeholder="dd-mm-yyyy" >
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                    </div>
                                </td>
                                <td>3.</td>
                                <td>Mode of Payment</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:98%;">
                                        <input type="text"  class="form-control class_req borderra0 terms" name="quotation[mode_of_payment]"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Notification Date</td>
                                <td></td>
                                <td> 
                                    <div class="input-group" style="width:98%;">
                                        <input type="text"  id='to_date' class="form-control datepicker borderra0 terms" name="quotation[notification_date]" placeholder="dd-mm-yyyy" >                                  
                                    </div>
                                </td>
                                <td>4.</td>
                                <td>Validity</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:98%;">
                                        <input type="text"  class="form-control class_req borderra0 terms" name="quotation[validity ]"/>
                                    </div>
                                </td>
                            </tr>
                             <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer' />

                        </table>
                    </td>
                    <td style="width:49%;">

                    </td>
                </tr>
            </table>
            <div class="action-btn-align mb-bot20">
                <button class="btn btn-primary" id="save"><span class="glyphicon glyphicon-plus"></span> Create</button>
                <a href="<?php echo $this->config->item('base_url') . 'service/service_list' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
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
                $(this).closest('tr').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('tr').find('.error_msg').text('');
            }
        });

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
    $('#add_label').click(function () {
        var tables = $(".static1").find('tr').clone();
        $(tables).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('.add_cost').append(tables);
        calculate_function();

    });
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });

    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
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

    $('.qty,.percost,.pertax,.totaltax').live('keyup', function () {
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

            if (Number(qty.val()) != 0)
            {
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                sub_total = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val()));
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
            url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_product",
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
            url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_service",
            data: 's=' + $(this).val(),
            success: function (datas) {
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);

            }
        });
    });
    $("#ref_class").live('change', function () {
        var nick = $("#ref_class option:selected").text().split("-");
        var increment_id = $('#grn_no').val().split("/");
        final_id = increment_id[0] + '/' + nick[1] + '/' + increment_id[2] + '/' + increment_id[3];
        $('#grn_no').val(final_id);
    });
    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });

    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.sell_price').val($(this).attr('pro_cost'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    $('.ser_class').live('click', function () {
        $(this).closest('tr').find('.sell_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "  " + $(this).attr('ser_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });

</script>
