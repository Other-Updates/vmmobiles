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
    .auto-asset-search ul#country-list li:hover {background: #c3c3c3;cursor: pointer;}
    .auto-asset-search ul#product-list li:hover {background: #c3c3c3;cursor: pointer;}
    .auto-asset-search ul#country-list li {background: #dadada;margin: 0; padding: 5px;border-bottom: 1px solid #f3f3f3;}
    .auto-asset-search ul#product-list li {background: #dadada;margin: 0;padding: 5px;border-bottom: 1px solid #f3f3f3;}
    ul li {list-style-type: none;}
    #suggesstion-box{z-index: 99;}
	.auto-asset-search{position:absolute !important;width:100%;}
	.auto-asset-search ul { width:100%; padding:0px;}
</style>
<div class="mainpanel">
    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Update Budget</h4>
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

        <?php
        if (isset($po) && !empty($po)) {
            foreach ($po as $val) {
                ?>
                <form  action="<?php echo $this->config->item('base_url'); ?>budget/update_budget/<?php echo $val['id']; ?>" method="post" class=" panel-body">
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
                                                        $selected = ($val['firm_id'] == $firm['firm_id']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $firm['firm_id']; ?>" <?php echo $selected; ?>> <?php echo $firm['firm_name']; ?> </option>
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
                                                        $selected = ($val['firm_id'] == $firm['firm_id']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $firm['firm_id']; ?>" <?php echo $selected; ?>> <?php echo $firm['firm_name']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?> </select>
                                        <?php } ?>
                                        <span class="error_msg"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Voucher No</label>
                                <div class="col-sm-8">
                                    <input type="text"  tabindex="1" name="po[vc_no]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $val['vc_no']; ?>" id="vc_id">
                                </div>
                            </div>
                        
                        </div>
                    	<div class="col-md-4">
                        
                        	<div class="form-group">
                                <label class="col-sm-4 control-label">From Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" tabindex="1"  class="form-align datepicker required" name="po[from_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($val['from_date'])); ?>">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">To Date</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <input type="text" tabindex="1"  class="form-align datepicker1 required" name="po[to_date]" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($val['to_date'])); ?>">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <span class="error_msg"></span>
                                </div>
                            </div>
                        
                        </div>
                    	<div class="col-md-4">
                        
                        	<div class="form-group">
                                <label class="col-sm-4 control-label">Budget Name</label>
                                <div class="col-sm-8">
                                    <div id='customer_td'>
                                        <div class="">
                                            <input type="text"  tabindex="1" name="po[budget_name]" id="email_id" class="form-align required form-control" value="<?php echo $val['budget_name']; ?>"/>
                                        </div>
                                        <span class="error_msg"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Remarks</label>
                                <div class="col-sm-8">
                                    <textarea name="po[remarks]" tabindex="1" id="address1" class="form-control form-align required"><?php echo $val['remarks']; ?></textarea>
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
                                <td width="10%" class="first_td1 action-btn-align">Amount</td>
                                <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Row</a></td>
                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            if (isset($po_details) && !empty($po_details)) {
                                $j = 1;
                                foreach ($po_details as $vals) {
                                    ?>
                                    <tr>
                                        <td class="sno"><?php echo $j; ?></td>
                                        <td>
                                            <input type="text" tabindex="1" name="customer[]" id="customer_name" class='form-control form-align customer_name'  style="width:100%;" value="<?php echo $vals['customer']; ?>"/>
                                            <span class="error_msg"></span>
                                            <input type="hidden"  name="customer_id[]" id="customer_id" class='customer_id'  value="<?php echo $vals['customer_id']; ?>"/>
                                            <div  class="auto-asset-search suggesstion-box "></div>
                                        </td>
                                        <td>
                                            <input type="text"  name="amount[]" id="amount" style="width:100%" class='form-align amount text_right tabwid' tabindex="1" value="<?php echo $vals['amount']; ?>"/>
                                            <span class="error_msg"></span>
                                        </td>
                                        <td class="action-btn-align">
                                            <input type="hidden" value = "<?php echo $vals['id']; ?>" class="del_id"/>
                                            <a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $j++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"style="text-align:right;font-weight:bold;">Net Total</td>
                                <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="1" class="total text_right tabwid form-align" style="width:100%;" value="<?php echo $val['net_total']; ?>"/></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
					</div>
                    <div class="action-btn-align">
                        <button class="btn btn-info1" id="save"> Update </button>
                        <a href="<?php echo $this->config->item('base_url') . 'budget/budget_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                    </div>
                </form>
                <br />
                <?php
            }
        }
        ?>
    </div>
</div>

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

        if (m > 0)
            return false;

    });

    $(document).ready(function () {
        val = $('#firm').val();
        if (val != '') {
            $('.customer_name').html('');
            $('.customer_name').removeAttr('readonly');
        } else {
            $('.customer_name').html('');
            $('.customer_name').attr('readonly', 'readonly');
        }
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
                    this_.closest('tr').find(".suggesstion-box").show();
                    this_.closest('tr').find(".suggesstion-box").html(data);
                    this_.closest('tr').find(".search-box").css("background", "#FFF");
                }
            });
        });
        $('body').click(function () {
            $(".suggesstion-box").hide();
        });
        //  $('#firm').trigger('change');
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

    $(document).on('click', '.del', function () {

        var del_id = $(this).closest('tr').find('.del_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "budget/delete_id",
            data: {id: del_id},
            success: function (datas) {
                calculate_function();
            }
        });

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
        $('.total').val(total);

    }
    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
        jQuery('.datepicker1').datepicker();
    });

</script>
<script>

    function Firm(val) {
        if (val != '') {
            $('.customer_name').html('');
            $('.customer_name').removeAttr('readonly');

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
                }
            });
        } else {
            $('.customer_name').html('');
            $('.customer_name').attr('readonly', 'readonly');
        }
    }

</script>