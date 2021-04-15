<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
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
    .firm1, .from_date1,.to_date1,.budget_name1{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
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
    .auto-asset-search ul { width:100%; padding:0px;}
</style>
<div class="mainpanel">
    <div id='empty_data'></div>
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Add Budget</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td class="sno"></td>
                <td>
                    <input type="text" tabindex="1" name="customer[]" id="customer_name" class='form-control form-align customer_name' readonly  style="width:100%;"/>
                    <span class="error_msg"></span>
                    <input type="hidden"  name="customer_id[]" id="customer_id" class='customer_id'  />
                    <div class="auto-asset-search suggesstion-box "></div>
                </td>
                <td>
                    <input type="text"  name="amount[]" id="amount" style="width:100%" class='form-align amount text_right tabwid' tabindex="1" />
                    <span class="error_msg"></span>
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <form  method="post" class="panel-body">
            <div class="row">
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Firm <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <?php if (count($firms) > 1) { ?>
                                <select onchange="Firm(this.value)" name="po[firm_id]"  class="form-control form-align required" id="firm" tabindex="1" >
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
                                <select onchange="Firm(this.value)" name="po[firm_id]"  class="form-control form-align required" id="firm" readonly="" tabindex="1">
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
                            <span class="firm1"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label first_td1">Voucher No <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text"  tabindex="1" name="po[vc_no]" class="code form-control colournamedup  form-align" readonly="readonly" id="vc_id" tabindex="1" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label first_td1">Estimated Budget Cost </label>
                        <div class="col-sm-8">
                            <input type="text"  tabindex="1" name="po[estimated_bud_cost]" class="code form-control colournamedup  form-align" id="app_bud" tabindex="1">
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label">From Date <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" tabindex="1"  class="form-align datepicker required" id="from_date" name="po[from_date]" placeholder="dd-mm-yyyy" >
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <span class="from_date1"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">To Date <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" tabindex="1"  class="form-align datepicker required" id="to_date" name="po[to_date]" placeholder="dd-mm-yyyy" >
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <span class="to_date1"></span>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label class="col-sm-4 control-label first_td1">Budget Name <span style="color:#F00; font-style:oblique;">*</span></label>
                        <div class="col-sm-8" id='customer_td'>
                            <div class="">
                                <input type="text"  tabindex="1" name="po[budget_name]" id="budget_name" class="form-control form-align required"/>
                            </div>
                            <span class="budget_name1"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label first_td1">Remarks</label>
                        <div class="col-sm-8">
                            <textarea name="po[remarks]" tabindex="1" id="address1" class="form-control form-align"></textarea>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mscroll">
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_budget">
                    <thead>
                        <tr>
                            <td width="5%" class="first_td1">S.No</td>
                            <td width="30%" class="first_td1">Customer Name</td>
                            <td width="30%" class="first_td1">Payable Amount</td>
                            <td width="10%" class="first_td1 action-btn-align">Collection Amount</td>
                            <td></td>
                            <!-- <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Row</a></td> -->
                        </tr>
                    </thead>
                    <tbody id='app_table'>
                        <tr>
                            <td class="sno">1</td>
                            <td>
                                <input type="text" tabindex="1" name="customer[]" id="customer_name" class='form-control form-align customer_name' readonly  style="width:100%;"/>
                                <span class="error_msg"></span>
                                <input type="hidden"  name="customer_id[]" id="customer_id" class='customer_id'  />
                                <div  class="auto-asset-search suggesstion-box "></div>
                            </td>
                            <td>
                                <input type="text"  name="pay_amount[]" id="pay_amount" style="width:100%" class='form-control form-align' readonly tabindex="1"/>
                                <span class="error_msg"></span>
                            </td>
                            <td>
                                <input type="text"  name="amount[]" id="amount" style="width:100%" class='form-align amount text_right tabwid' tabindex="1"/>
                                <span class="error_msg"></span>
                            </td>
                            <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><input type="text"  name="po[net_total]" id="net_total" readonly="readonly"  tabindex="1" class="total text_right tabwid form-align" style="width:100%;" /></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="action-btn-align mb-bot20">
                <button class="btn btn-primary" name="print" value="no" id="save"><span class="glyphicon glyphicon-plus"></span> Create</button>
                <button class="btn btn-primary" name="print" value="yes" id="save" tabindex="1"><span class="glyphicon glyphicon-plus"></span> Save and <span class="glyphicon glyphicon-print"></span> print</button>
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
                m++;
                if (this_id == 'firm')
                {
                    $('.firm1').text('This field is required').css('display', 'inline-block');

                } else if (this_id == 'from_date')
                {
                    $('.from_date1').text('This field is required').css('display', 'inline-block');

                } else if (this_id == 'to_date')
                {
                    $('.to_date1').text('This field is required').css('display', 'inline-block');

                } else if (this_id == 'budget_name')
                {
                    $('.budget_name1').text('This field is required').css('display', 'inline-block');

                }
            } else {
                $('.firm1').text('');
                $('.from_date1').text('');
                $('.to_date1').text('');
                $('.budget_name1').text('');
            }
        });
        if (m > 0)
            return false;
    });
    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $('#firm').focus();
        $(".customer_name").live('keyup', function () {
            var this_ = $(this);
            cat_id = $('#firm').val();
            var prod_array = new Array();
            $(".customer_id").each(function () {
                prod_array.push($(this).val());
            });
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "budget/get_customer/" + cat_id,
                data: {q: $(this).val(), cust: prod_array},
                success: function (data) {
                    this_.closest('tr').find(".suggesstion-box").html(data);
                    this_.closest('tr').find(".search-box").css("background", "#FFF");
                    this_.closest('tr').find(".suggesstion-box").show();
                }
            });
        });
        $('body').click(function () {
            $(".suggesstion-box").hide();
        });
        $('#firm').trigger('change');
    });
    $('.cust_class').live('click', function () {
        $(this).closest('tr').find('.customer_name').val($(this).attr('cust_name'));
        $(this).closest('tr').find('.customer_id').val($(this).attr('cust_id'));
    });
    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        var len = $('#add_budget tbody tr').length + 1;
        $(tableBody).closest('tr').find('.sno').text(len);
        $('#app_table').append(tableBody);
        $('#add_budget tbody tr td:nth-child(2)').addClass('relative');
    });
    $(document).on('click', '.del', function () {
        $(this).closest("tr").remove();
        var i = 1;
        $('#add_budget tbody tr').each(function () {
            $(this).find('.sno').text(i);
            i++;
        });
        calculate_function();
    });
    $('.amount').live('keyup', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var total = 0;
        $('.amount').each(function () {
            var amount = $(this);
            total += Number(amount.val());
        });
        $('.total').val(total.toFixed(2));
    }

    $(document).ready(function () {
        jQuery('#from_date, #to_date').click(function ()
        {
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var firm = $('#firm').val();
            budget_list(from, to, firm);
        });
        jQuery('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
        }).on("input change", function () {
            //console.log("Date changed: ", e.target.value);
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var firm = $('#firm').val();
            budget_list(from, to, firm);
        });
        //jQuery('.datepicker1').datepicker();
    });
    function budget_list(from, to, firm)
    {
        if (from != '' || to != '')
        {
            $.ajax({
                type: 'POST',
                data: {from: from, to: to, firm: firm},
                url: '<?php echo base_url(); ?>purchase_receipt/total_purchase_amount',
                success: function (response) {
                    //alert(response);
                    $('#app_bud').val(response);
                }
            });
            $.ajax({
                type: 'POST',
                data: {from: from, to: to, firm: firm},
                url: '<?php echo base_url(); ?>sales_receipt/sales_list',
                success: function (result) {
                    result_json = JSON.parse(result);
                    // $.each(result_json, function (key, val) {
                    $('#app_table').html('');
                    var total = 0;
                    console.log(result_json);
                    var j = 0;
                    for (var i = 0; i < result_json.length; i++)
                    {
                        //console.log(result_json[i].c_name);

                        total = total + result_json[i].pending;
                        if (result_json[i].pending > 0)
                        {
                            j = j + 1;
                            var $tr = $('<tr>').append(
                                    $('<td>').text(j),
                                    $('<td>').html('<input type="text" tabindex="1" name="customer[]" id="customer_name" class="form-control form-align customer_name" readonly  style="width:100%;" value="' + result_json[i].c_name + '"/><input type="hidden"  name="customer_id[]" id="customer_id" class="customer_id"  value="' + result_json[i].c_id + '"/>'),
                                    $('<td>').html('<input type="text"  name="pay_amount[]" id="pay_amount" style="width:100%" class="form-control form-align" readonly tabindex="1" value="' + result_json[i].pending.toFixed(2) + '"/>'),
                                    $('<td>').html('<input type="text"  name="amount[]" id="amount" style="width:100%" class="form-align amount text_right tabwid" tabindex="1" value="' + result_json[i].pending.toFixed(2) + '"/>'),
                                    $('<td>').html('<td class="action-btn-align"><a id="delete_group" class="del"><span class="glyphicon glyphicon-trash"></span></a></td>'),
                                    ).appendTo('#app_table');
                        }
                        //console.log($tr.wrap('<p>').html());
                    }
                    $('#net_total').val(total.toFixed(2));
                    //});
                }
            });
        } else {
            //$('#app_table').html('');
            $('#app_bud').val('');
        }
    }</script>
<script>

    function Firm(val) {
        if (val != '') {
            $('.customer_name').html('');
            $('.customer_name').removeAttr('readonly');
            var from = $('#from_date').val();
            var to = $('#to_date').val();
            var firm = $('#firm').val();
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>quotation/get_prefix_by_frim_id/',
                success: function (data1) {
                    $('#vc_id').val(data1[0]['prefix']);
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {type: data1[0]['prefix'], code: 'VC'},
                        url: '<?php echo base_url(); ?>quotation/get_increment_id/',
                        success: function (data2) {
                            $('#vc_id').val(data2);
                            //console.log(data2);
                            var increment_id = $('#vc_id').val().split("/");
                            sales_id = 'VC-' + data1[0]['prefix'] + '-' + increment_id[1] + '' + increment_id[2];
                            $('#vc_id').val(sales_id);
                        }
                    });

                    budget_list(from, to, firm);
                }
            });
        } else {
            $('.customer_name').html('');
            $('.customer_name').attr('readonly', 'readonly');
        }
    }
</script>
<script>
    $(document).ready(function () {
        $('#add_budget tbody tr td:nth-child(2)').addClass('relative');
    })
</script>

