<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
</style>

<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel mb-50">
        <div class="media mt--2">
            <h4>Add Cash Out Flow</h4>
        </div>
        <div class="panel-body">
            <form action="<?php echo $this->config->item('base_url'); ?>cash_out_flow/" enctype="multipart/form-data" name="form" method="post">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">


                        <div class="form-group">
                            <label class="col-sm-4 control-label">Sender Firm <span style="color:#F00; font-style:oblique;">*</span></label>
                            <div class="col-sm-8">
                                <?php if (count($firms) > 1) { ?>
                                    <select onchange="Firm_Sender(this.value)" name="sender_firm_id"  class="form-control form-align required" id="sender_firm_id"  tabindex="1">
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
                                    <select onchange="Firm_Sender(this.value)" name="sender_firm_id"  class="form-control form-align required" id="sender_firm_id" readonly=""  tabindex="1">
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
                            <label class="col-sm-4 control-label">Sender Staff Name <span style="color:#F00; font-style:oblique;">*</span></label>

                            <div class="col-sm-8">
                                <input type="text"  tabindex="1" id="sender_name" class='form-align required form-control' />
                                <span class="error_msg"></span>
                                <div id="suggesstion-box" class="auto-asset-search "></div>
                                <input type="hidden" name="sender_name" id="sender_name_id" value=""  />
                            </div>

                        </div>
                        <!--                        <div class="form-group" id="sender_others_text" style="display:none">
                                                    <label class="col-sm-4 control-label">Sender Others <span style="color:#F00; font-style:oblique;">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text"  tabindex="1"  name="sender_other_name" id="sender_other_name" class='form-align  form-control' />
                                                        <span class="error_msg"></span>
                                                    </div>
                                                </div>-->

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Receiver Firm <span style="color:#F00; font-style:oblique;">*</span></label>
                            <div class="col-sm-8">
                                <select name="firm_id"  onchange="Firm(this.value)" class="form-control form-align required" id="firm"  tabindex="1">
                                    <option value=""> Select </option>
                                    <?php
                                    if (isset($all_firm) && !empty($all_firm)) {
                                        foreach ($all_firm as $firm) {
                                            ?>
                                            <option value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                            <?php
                                        }
                                    }
                                    ?> </select>
                                <span class="error_msg"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Receiver Staff Name <span style="color:#F00; font-style:oblique;">*</span></label>
                            <div class="col-sm-8">
                                <input type="text"  tabindex="1"   id="user_name" class='form-align required form-control' />
                                <span class="error_msg"></span>
                                <input type="hidden" name="user_name" id="user_name_id" value=""  />
                                <div id="suggesstion-box" class="auto-asset-search "></div>
                            </div>
                        </div>
                        <!--                        <div class="form-group" id="others_text" style="display:none">
                                                    <label class="col-sm-4 control-label">Receiver Others <span style="color:#F00; font-style:oblique;">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text"  tabindex="1"  name="other_name" id="other_name" class='form-align  form-control' />
                                                        <span class="error_msg"></span>
                                                    </div>
                                                </div>-->

                        <div class="form-group">
                            <label class="col-sm-4 control-label first_td1">Mobile Number</label>
                            <div class="col-sm-8">
                                <input type="text"  tabindex="1" name="mobile_number" id="mobile_number" class="form-control form-align"  />
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label first_td1">Pay Type</label>
                            <div class="col-sm-8">
                                <input type="radio" class="receiver" value="cash"  name="amount_type" />Cheque
                                <input type="radio" class="receiver" value="credit" name="amount_type" />Cash<br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label first_td">Amount <span style="color:#F00; font-style:oblique;">*</span></label>
                            <div class="col-sm-8" id='customer_td'>
                                <input type="text"  tabindex="1" onkeypress="return isNumber(event, this)"  name="cash_out" id="cash_out" class="form-control required  form-align"/>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label first_td1">Remarks <span style="color:#F00; font-style:oblique;">*</span></label>
                            <div class="col-sm-8">
                                <textarea name="remarks" id="remarks" tabindex="1" class="form-control required form-align" style="resize:none;"></textarea>
                                <span class="error_msg"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="frameset_table action-btn-align">
                    <table>
                        <td width="570">&nbsp;</td>
                        <td><input type="submit" name="submit" class="btn btn-success" value="Create" id="save" /></td>
                        <td>&nbsp;</td>
                        <td><a href="<?php echo $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_list' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sender_firm_id').focus();
        $('#sender_firm_id').trigger('change');

        var cus_name = $('#firm').val();
        if (cus_name == '')
        {
            $("#user_name").attr("disabled", true);
        } else {
            $("#user_name").attr("disabled", false);
        }
        var sender_firm_id = $('#sender_firm_id').val();
        if (sender_firm_id == '')
        {
            $("#sender_name").attr("disabled", true);
        } else {
            $("#sender_name").attr("disabled", false);
        }

        $('#save').live('click', function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr("id");
                this_class = $(this).attr("class");
                if (this_val == "") {
                    $(this).closest('tr td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                    $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('tr td').find('.error_msg').text('');
                    $(this).closest('div .form-group').find('.error_msg').text('');
                }
            });
            if (m > 0) {
                return false;
            }
        });
    });
    function Firm(val) {
        if (val != '') {
            $("#user_name").attr("disabled", false);
            $("#sender_firm_id option").removeAttr('disabled');
            //$("firm option").removeAttr('disabled');
            $("#sender_firm_id option").each(function () {
                if (this.value == val) {
                    this.disabled = true;
                }
            });

            $.ajax({
                type: 'POST',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>cash_out_flow/get_sales_man_by_firm/',
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        $('#user_name').val('');
                    } else {
                        $('#user_name').html('');
                    }
                }
            });
            /*   var c_data = [];
             $.ajax({
             type: 'POST',
             data: {firm_id: val},
             url: '<?php echo base_url(); ?>cash_out_flow/get_all_users_by_firm/' + val,
             success: function (data) {
             // var c_data = data.split(',');
             var c_data = JSON.parse(data);
             $('body').on('keydown', 'input#user_name', function (e) {
             //var c_data = [<?php echo implode(',', data); ?>];
             //console.log(c_data);
             $("#user_name").autocomplete({
             source: c_data,
             minLength: 0,
             autoFill: false,
             select: function (event, ui) {
             this_val = $(this);
             product = ui.item.label;
             $(this).val(product);
             model_number_id = ui.item.value;
             name = $('#user_name').val();
             if (name == 'Others') {
             $('#others_text').show();
             $('#others_text').find('input#other_name').addClass('required');
             } else {
             $.ajax({
             type: 'POST',
             data: {name: name},
             url: "<?php echo $this->config->item('base_url'); ?>" + "cash_out_flow/get_mobile_number/",
             success: function (datas) {
             result = JSON.parse(datas);
             if (result != null && result.length > 0) {
             $('#mobile_number').val(result[0].mobil_number);
             } else {
             $('#mobile_number').val('');
             }
             }
             });
             }
             }
             });
             });
             }
             });*/
        }
    }

    function Firm_Sender(val) {

        if (val != '') {
            $("#sender_name").attr("disabled", false);

            //$("sender_firm_id option").removeAttr('disabled');
            $("#firm option").removeAttr('disabled');

            $("#firm option").each(function () {
                if (this.value == val) {
                    this.disabled = true;
                }
            });

            $.ajax({
                type: 'POST',
                data: {firm_id: val},
                url: '<?php echo base_url(); ?>cash_out_flow/get_sales_man_by_firm/',
                success: function (data) {
                    result = JSON.parse(data);
                    if (result != null && result.length > 0) {
                        $('#sender_name').val('');
                    } else {
                        $('#sender_name').html('');
                    }
                }
            });

            /*  var c_data = [];
             $.ajax({
             type: 'POST',
             data: {firm_id: val},
             url: '<?php echo base_url(); ?>cash_out_flow/get_all_users_by_firm/' + val,
             success: function (data) {
             // var c_data = data.split(',');
             var c_data = JSON.parse(data);
             $('body').on('keydown', 'input#sender_name', function (e) {
             //var c_data = [<?php echo implode(',', data); ?>];
             console.log(c_data);
             $("#sender_name").autocomplete({
             source: c_data,
             minLength: 0,
             autoFill: false,
             select: function (event, ui) {
             this_val = $(this);
             product = ui.item.label;
             $(this).val(product);
             model_number_id = ui.item.value;
             name = $('#sender_name').val();
             if (name == 'Others') {
             $('#sender_others_text').show();
             $('#sender_others_text').find('input#sender_other_name').addClass('required');
             } else {
             //                                    $.ajax({
             //                                        type: 'POST',
             //                                        data: {name: name},
             //                                        url: "<?php echo $this->config->item('base_url'); ?>" + "cash_out_flow/get_mobile_number/",
             //                                        success: function (datas) {
             //                                            result = JSON.parse(datas);
             //                                            if (result != null && result.length > 0) {
             //                                                $('#mobile_number').val(result[0].mobil_number);
             //                                            } else {
             //                                                $('#mobile_number').val('');
             //                                            }
             //                                        }
             //                                    });
             }
             }
             });
             });
             }
             });*/
        }
    }
    function isNumber(evt, this_ele) {
        this_val = $(this_ele).val();
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.which == 13) {//Enter key pressed
            $(".thVal").blur();
            return false;
        }
        if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {
            return false;
        } else {
            return true;
        }

    }
    //get_sales_man details by vic
    $('body').on('keydown', 'input#sender_name', function (e) {
        var elem = $(this);
        var sender_firm_id = $('#sender_firm_id').val();
        $("#sender_name").blur(function () {
            var keyEvent = $.Event("keydown");
            keyEvent.keyCode = $.ui.keyCode.ENTER;
            $(this).trigger(keyEvent);
            // Stop event propagation if needed
            return false;
        }).autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('base_url'); ?>" + "cash_out_flow/get_sales_man_by_firm/",
                    dataType: 'json',
                    data: {sender_firm_id: sender_firm_id},
                    success: function (data) {
                        if (data != null) {
                            var c_data = data;
                            var outputArray = new Array();
                            for (var i = 0; i < c_data.length; i++) {
                                outputArray.push(c_data[i]);
                                //if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                                //outputArray.push(c_data[i]);
                                // }
                            }
                            response(outputArray.slice(0, 10));
                        }
                    }
                });
            },
            minLength: 0,
            autoFocus: true,
            select: function (event, ui) {
                var sales_man_id = ui.item.id;
                elem.closest('div').find('#sender_name_id').val('').val(sales_man_id);
                // elem.closest('div').find('#user_name_id').val('').val(sales_man_id);
            }
        });
    });

    $('body').on('keydown', 'input#user_name', function (e) {
        var elem = $(this);
        var firm = $('#firm').val();
        $("#user_name").blur(function () {
            var keyEvent = $.Event("keydown");
            keyEvent.keyCode = $.ui.keyCode.ENTER;
            $(this).trigger(keyEvent);
            // Stop event propagation if needed
            return false;
        }).autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('base_url'); ?>" + "cash_out_flow/get_sales_man_by_firm/",
                    dataType: 'json',
                    data: {sender_firm_id: firm},
                    success: function (data) {
                        if (data != null) {
                            var c_data = data;
                            var outputArray = new Array();
                            for (var i = 0; i < c_data.length; i++) {
                                outputArray.push(c_data[i]);
                                //if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                                //outputArray.push(c_data[i]);
                                // }
                            }
                            response(outputArray.slice(0, 10));
                        }
                    }
                });
            },
            minLength: 0,
            autoFocus: true,
            select: function (event, ui) {
                var sales_man_id = ui.item.id;
                // elem.closest('div').find('#sender_name_id').val('').val(sales_man_id);
                elem.closest('div').find('#user_name_id').val('').val(sales_man_id);
            }
        });
    });


</script>

