<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->
<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel">
        <div class="media mt--2">
            <h4>Update Supplier</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#update-supplier" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>
                </ul>

                <div class="tab-content tabbor">
                    <div role="tabpanel" class="tab-pane active" id="update-supplier">
                        <form  method="post"  name="form1" action="<?php echo $this->config->item('base_url') . 'masters/suppliers/update_vendor'; ?>">
                            <?php
                            if (isset($vendor) && !empty($vendor)) {
                                $i = 0;
                                foreach ($vendor as $val) {
                                    $i++;
                                    //echo $vendor[0]['state_id'];
                                    if ($vendor[0]['state_id'] == 0) {
                                        $vendor[0]['state_id'] = 31;
                                    }
                                    ?>
                                    <div class="inner-sub-tit">Supplier Details</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Shop Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="firm_id"  class="form-control form-align" id="firm" tabindex="1">
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
                                                    <span id="firmerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Supplier Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="store" class="store  form-align" id="store" maxlength="25" value="<?php echo $val['store_name']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Landline Number <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="landline" class="landline  form-align" maxlength="11" id="landline" value="<?php echo $val['landline']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-volume-control-phone"></i>
                                                        </div>
                                                    </div>
                                                    <span id="landlinerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                    <span id="upduplica1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="number" class="mobile  form-align" id="mobile" maxlength="13" value="<?php echo $val['mobil_number']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Contact Person</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="name" id="name"  class="name  form-align" maxlength="25" value="<?php echo $val['name']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">City <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="city" class=" form-align" id="city" maxlength="25" value="<?php echo $val['city']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-map-marker"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">State</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" name="id" readonly="readonly" class="id form-control" value="<?php echo $val['id']; ?>" />
                                                    <select id="state_id" name='state_id' class="state_id form-control form-align" tabindex="1">
                                                        <option value="">Select</option>
                                                        <?php
                                                        if (isset($all_state) && !empty($all_state)) {
                                                            foreach ($all_state as $bill) {
                                                                ?>
                                                                <option <?php echo ($bill['id'] == $vendor[0]['state_id']) ? 'selected' : '' ?> value="<?php echo $bill['id']; ?>"><?php echo $bill['state']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Email Address</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="mail" class="mail  form-align" id="mail" value="<?php echo $val['email_id']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                    <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address Line1 <span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <textarea  name='address1' id="address" class="form-control form-align" tabindex="1"><?php echo $val['address1']; ?></textarea>
                                                    <span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address Line2</label>
                                                <div class="col-sm-8">
                                                    <textarea  name='address2' id="" class="form-control form-align" tabindex="1"><?php echo $val['address2']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Pin Code</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="pin" class=" form-align" id="pincode" value="<?php
                                                        if ($val['pincode'] != 0) {
                                                            echo $val['pincode'];
                                                        }
                                                        ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-map-marker"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!--  <div class="form-group">
                                                <label class="col-sm-4 control-label">Credit Days <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <select id="credit_days" name='credit_days' class="credit_days form-control form-align" tabindex="1">
                                                        <option value="">Select</option>
                                            <?php
                                            for ($x = 1; $x <= 90; $x++) {
                                                $select = ($x == $vendor[0]['credit_days']) ? 'selected' : '';
                                                ?>
                                                                        <option  value="<?php echo $x; ?>" <?php echo $select; ?>><?php echo $x; ?></option>
                                                <?php
                                            }
                                            ?>
                                                    </select>
                                                    <span id="credit_dayserr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Payment Percentage</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" class=" form-align" name="payment" id="payment" value="<?php
                                            if ($val['payment_percent'] != 0) {
                                                echo $val['payment_percent'];
                                            }
                                            ?>"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-money"></i>
                                                        </div>
                                                    </div>
                                                    <span id="paymenterr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">DOB</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="dob"  class="datepicker form-align" id="dob" value="<?php echo $val['dob']; ?>" tabindex="1">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <span id="dob1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Anniversary Date</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text"  name="anniversary"  class="datepicker  form-align" id="anniversary" value="<?php echo $val['anniversary_date']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <span id="anniversary1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>-->

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">GSTIN <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="tin" class="mobile  form-align" id="tin" maxlength="15" value="<?php echo $val['tin']; ?>" tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-cog"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror12" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="inner-sub-tit mstyle">Bank Details</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bank Name <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="bank" class="bank  form-align" id="bank" maxlength="25" value="<?php echo $val['bank_name']; ?>"  tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bank"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Account No <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="acnum" class=" form-align" id="acnum" maxlength="25" value="<?php echo $val['account_num']; ?>"  tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user-circle"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">IFSC Code <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="ifsc" class=" form-align" id="ifsc" maxlength="15" value="<?php echo $val['ifsc']; ?>"  tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-fax"></i>
                                                        </div>
                                                    </div>
                                                    <span id="ifsc1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bank Branch <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="branch" class=" form-align" id="branch" maxlength="25" value="<?php echo $val['bank_branch']; ?>"  tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-bank"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Payment Terms <span style="color:#F00; font-style:oblique;"></span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="payment_terms" class="mobile  form-align" id="payment_terms" maxlength="25" value="<?= $val['payment_terms'] ?>"  tabindex="1"/>
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-fw fa-money"></i>
                                                        </div>
                                                    </div>
                                                    <span id="superror11" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="frameset_table action-btn-align">
                                        <table>
                                            <tr>
                                                <td width="570">&nbsp;</td>
                                                <td><input type="submit" value="Update" class="submit btn btn-info1 right" id="edit"  tabindex="1"/></td>
                                                <td>&nbsp;</td>
                                                <td><input type="reset" value="Clear" class="btn btn-danger1 right" id="reset"  tabindex="1"/></td>
                                                <td>&nbsp;</td>
                                                <td><a href="<?php echo $this->config->item('base_url') . 'masters/suppliers/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                    </div>
                </div>
                </form>
            </div>



        </div>
    </div>
</div>






<script type="text/javascript">
    var i=0;
    $('#reset').on('click', function () {
        $('.val').text("");
    });



    $('#state_id').on('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').text("Select State");
        } else
        {
            $('#superror').text("");
        }
    });
    /* $("#name").on('blur', function ()
     {
     var name = $("#name").val();
     var filter = /^[a-zA-Z.\s]{3,30}$/;
     if (name == "" || name == null || name.trim().length == 0)
     {
     $("#superror1").html("Required Field");
     } else if (!filter.test(name))
     {
     $("#superror1").html("Alphabets and Min 3 to Max 30 ");
     } else
     {
     $("#superror1").html("");
     }
     });*/
    $("#store").on('blur', function ()
    {
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").text("Required Field");
        } else
        {
            $("#superror2").text("");
        }
    });
    $('#address').on('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').text("Enter Address");
        } else
        {
            $('#superror3').text("");
        }
    });
    $("#mobile").on('blur', function ()
    {
        var number = $("#mobile").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "")
        {
            $("#superror4").text("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#superror4").text("Enter valid Mobile Number");
        } else
        {
            $("#superror4").text("");
        }
    });
    $("#landline").on('blur', function ()
    {
        var number = $("#landline").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            //$("#landlinerr").text("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#landlinerr").text("Enter valid Landline Number");
        } else
        {
            $("#landlinerr").text("");
        }
    });
    $("#pincode").on('blur', function ()
    {
        var pin_code = $("#pin_code").val();
        var pat1 = /^\d{6}$/;

        if (pin_code == "" || pin_code == null || pin_code.trim().length == 0)
        {
            //  $("#pin_code_err").text("Required Field");
        } else
        {
            if (!pat1.test(pin_code))
            {
                $("#pin_code_err").text("Pin code should be 6 digits ");
                pin_code.focus();
            } else {
                $("#pin_code_err").text("");
            }

        }
    });
    $("#mail").on('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").text("");
        } else if (!efilter.test(mail))
        {
            $("#superror5").text("Enter Valid Email");
        } else
        {
            $("#superror5").text("");
        }
    });

    $("#credit_days").on('blur', function ()
    {
        var credit_days = $("#credit_days").val();
        if (credit_days == "")
        {
            // $("#credit_dayserr").text("Required Field");
        } else
        {
            $("#credit_dayserr").text("");
        }
    });
    $('#bank').on('blur', function ()
    {
        var bank = $('#bank').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            // $('#superror6').text("Enter Details");
        } else
        {
            $('#superror6').text("");
        }
    });
    $('#city').on('blur', function ()
    {
        var city = $('#city').val();
        var regex = new RegExp("^[a-zA-Z\\s]+$");
        var char_test = regex.test(city);

        if (city == "" || city == null || city.trim().length == 0)
        {
            $('#superror7').html("Required Field");
        }else{
            if (city != "") {
                if (char_test == false) {
                    $("#superror7").html("Invalid City Name");

                    i = 1;
                } else {
                    $("#superror7").html("");
                }

            } else
            {
                $('#superror7').html("");
            }
        }
       
    });
    /* $("#pincode").on('blur', function ()
     {
     var pincode = $("#pincode").val();
     if (pincode == "")
     {
     $("#superror8").html("Required Field");
     } else if (pincode.length != 6)
     {
     $("#superror8").html("Maximum 6 Numbers");
     } else
     {
     $("#superror8").html("");
     }
     });*/
    $("#branch").on('blur', function ()
    {
        var branch = $("#branch").val();
        if (branch == "" || branch == null || branch.trim().length == 0)
        {
            //   $("#superror9").text("Required Field");
        } else
        {
            $("#superror9").text("");
        }
    });
    $("#acnum").on('blur', function ()
    {
        var acnum = $("#acnum").val();
//        var acfilter = /^[0-9]+$/;
        if (acnum == "")
        {
            // $("#superror10").text("Required Field");
//        } else if (!acfilter.test(acnum))
//        {
//            $("#superror10").text("Numeric Only");
        } else
        {
            $("#superror10").text("");
        }
    });
    $("#acnum").keydown(function (e) {

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {

            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
            $("#superror10").text("Numeric only");
        } else
        {
            $("#superror10").text("");
        }
    });
    $("#payment_terms").on('blur', function ()
    {
        var payment_terms = $("#payment_terms").val();

        if (payment_terms == "")
        {
            // $("#superror11").text("Required Field");
        } else
        {
            $("#superror11").text("");
        }
    });
    $("#ifsc").on('blur', function ()
    {
        var ifsc = $("#ifsc").val();

        if (ifsc == "")
        {
            // $("#ifsc1").text("Required Field");
        } else
        {
            $("#ifsc1").text("");
        }
    });
    $('#tin').on('blur', function ()
    {
        var tin = $('#tin').val();
        var acfilter = /^[A-Za-z0-9]+$/;
        if (tin == "" || tin == null || tin.trim().length == 0)
        {
            // $('#superror12').text("Required Field");
            // i = 1;
        } else if (!acfilter.test(tin))
        {
            $("#superror12").text("Numeric or Alphanumeric");
            i = 1;
        } else
        {
            $('#superror12').text("");
        }
    });
</script>
<script type="text/javascript">
    $('#edit').on('click', function ()
    {
        
        var i = 0;
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').text("Select State");
            i = 1;
        } else
        {
            $('#superror').text("");
        }
        /*  var name = $("#name").val();
         var filter = /^[a-zA-Z.\s]{3,30}$/;
         if (name == "" || name == null || name.trim().length == 0)
         {
         $("#superror1").html("Required Field");
         i = 1;
         } else if (!filter.test(name))
         {
         $("#superror1").html("Alphabets and Min 3 to Max 30 ");
         i = 1;
         } else
         {
         $("#superror1").html("");
         }*/
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").text("Required Field");
            i = 1;
        } else
        {
            $("#superror2").text("");
        }

        var city = $("#city").val();
        var regex = new RegExp("^[a-zA-Z\\s]+$");
        var char_test = regex.test(city);
        if (city == "" || city == null || city.trim().length == 0)
        {
            $("#superror7").text("Required Field");
            i = 1;
        }
        else{
            if (city != "") {
            if (char_test == false) {
                $("#superror7").html("Invalid City Name");

                i = 1;
            } else {
                $("#superror7").html("");
            }

        } else
        {
            $("#superror7").text("");
        }
        }

        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').text("Enter Address");
            i = 1;
        } else
        {
            $('#superror3').text("");
        }
        var pin_code = $('#pincode').val();
        var pat1 = /^\d{6}$/;
        if (pin_code == "")
        {
            // $('#superror8').text("Required Field");
            // i = 1;
        } else
        {
            if (!pat1.test(pin_code))
            {
                $("#superror8").text("Pin code should be 6 digits ");
                i = 1;
            } else {
                $("#superror8").text("");
            }
        }
        var number = $("#mobile").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "")
        {
            $("#superror4").text("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#superror4").text("Enter Valid Mobile Number");
            i = 1;
        } else
        {
            $("#superror4").text("");
        }

        var numbers = $("#landline").val();
        var nfilters = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (numbers == "")
        {
            // $("#landlinerr").text("Required Field");
            // i = 1;
        } else if (!nfilters.test(numbers))
        {
            $("#landlinerr").text("Enter Valid Landline Number");
            i = 1;
        } else
        {
            $("#landlinerr").text("");
        }
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").text("");
        } else if (!efilter.test(mail))
        {
            $("#superror5").text("Enter Valid Email");
            i = 1;
        } else
        {
            $("#superror5").text("");
        }
        var bank = $('#bank').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            // $('#superror6').text("Enter Details");
            //  i = 1;
        } else
        {
            $('#superror6').text("");
        }
        var credit_days = $("#credit_days").val();
        if (credit_days == "")
        {
            //$("#credit_dayserr").text("Required Field");
            // i = 1;
        } else
        {
            $("#credit_dayserr").text("");
        }
        var branch = $("#branch").val();
        if (branch == "" || branch == null || branch.trim().length == 0)
        {
            //$("#superror9").text("Required Field");
            // i = 1;
        } else
        {
            $("#superror9").text("");
        }
        var acnum = $("#acnum").val();
        var acfilter = /^[0-9]+$/;
        if (acnum == "")
        {
            // $("#superror10").text("Required Field");
            //  i = 1;
//        } else if (!acfilter.test(acnum))
//        {
//            $("#superror10").text("Numeric Only");
//            i = 1;
        } else
        {
            $("#superror10").text("");
        }
        var payment_terms = $("#payment_terms").val();

        if (payment_terms == "")
        {
            // $("#superror11").text("Required Field");
            //  i = 1;
        } else
        {
            $("#superror11").text("");
        }
        var ifsc = $("#ifsc").val();

        if (ifsc == "")
        {
            // $("#ifsc1").text("Required Field");
            //  i = 1;
        } else
        {
            $("#ifsc1").text("");
        }
        var tin = $('#tin').val();
        var acfilter = /^[A-Za-z0-9]+$/;
        if (tin == "" || tin == null || tin.trim().length == 0)
        {
            // $('#superror12').text("Required Field");
            //  i = 1;
        } else if (!acfilter.test(tin))
        {
            $("#superror12").text("Numeric or Alphanumeric");
            i = 1;
        } else
        {
            $('#superror12').text("");
        }

        var mess = $('#upduplica').html();
        if ((mess.trim()).length > 0)
        {
            i = 1;
        }

        var mess1 = $('#upduplica1').html();
        if ((mess1.trim()).length > 0)
        {
            i = 1;
        }
        if (i == 1)
        {
            return false;
        } else
        {
            return true;
            $('form').submit();
        }

    });
</script>
<script type="text/javascript">
    $(".mail").on('blur', function ()
    {

        mails = $("#mail").val();

        id = $('.id').val();
        if (mails != '')
        {
            $.ajax(
                    {
                        url: BASE_URL + "masters/suppliers/update_duplicate_mail",
                        type: 'POST',
                        data: {value1: mails, value2: id},
                        success: function (result)
                        {
                            $("#upduplica").html(result);
                        }
                    });
        }
    });

    $(".landline").on('blur', function ()
    {

        landline = $("#landline").val();

        id = $('.id').val();
        if (landline != '')
        {
            $.ajax(
                    {
                        url: BASE_URL + "masters/suppliers/update_duplicate_land",
                        type: 'POST',
                        data: {value1: landline, value2: id},
                        success: function (result)
                        {
                            $("#upduplica1").html(result);
                        }
                    });
        }
    });
</script>