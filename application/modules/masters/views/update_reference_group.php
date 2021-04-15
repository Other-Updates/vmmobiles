<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel mb-45">
        <div class="media mt--2">
            <h4>Update Reference Group</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#update-customer" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>
                </ul>

                <div class="tab-content tabbor">
                    <div role="tabpanel" class="tab-pane active" id="update-customer">
                        <?php $ref_types = array (1 => 'Workers', 2 => 'Contractor', 3 => 'HR & Team Lead', 4 => 'Others'); ?>
                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'masters/reference_groups/update_ref_group'; ?>">
                            <table  class="table table-striped  responsive no-footer dtr-inline">
                                <?php
                                if (isset($references) && !empty($references)) {

                                    $i = 0;
                                    foreach ($references as $val) {
                                        $i++;
                                        ?>
                                        <tr>
                                        <input type="hidden" name="id" class="id id_dup form-control form-align" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                        <td width="12%">Firm</td>
                                        <td width="18%">
                                            <select name="firm_id"  class="form-control form-align" id="firm" tabindex="1">
                                                <option value="">Select</option>
                                                <?php
                                                if (isset($firms) && !empty($firms)) {
                                                    foreach ($firms as $firm) {
                                                        ?>
                                                        <option <?php echo ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '' ?> value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="firm_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <td>Reference Type</td>
                                        <td>
                                            <select id="reference_type" name='reference_type' class="reference_type form-control form-align"  tabindex="1">
                                                <option value="">Select</option>
                                                <?php
                                                if (isset($ref_types) && !empty($ref_types)) {
                                                    foreach ($ref_types as $key => $value) {
                                                        ?>
                                                        <option <?php echo ($key == $val['reference_type']) ? 'selected' : '' ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select><span id="ref_type" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <td>User Name</td>
                                        <?php //if ($val['reference_type'] == 1) { ?>
                                        <td class="user_list curr_ref" <?php if ($val['reference_type'] == 1) { ?> style="display:block;" <?php } else { ?>style="display:none;" <?php } ?>>
                                            <select id="user" name='user' class="user form-control form-align"  tabindex="1">
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($user_list) && !empty($user_list)) {
                                                    foreach ($user_list as $userlist) {
                                                        ?>
                                                        <option <?php echo ($userlist['id'] == $val['user_id']) ? 'selected' : '' ?> value="<?php echo $userlist['id']; ?>"><?php echo $userlist['name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <?php //}
                                        ?>
                                        <td class="customer_list curr_ref" <?php if ($val['reference_type'] == 2) { ?> style="display:block;" <?php } else { ?>style="display:none;" <?php } ?>>
                                            <select id="customer_id" name='customer_id' class="user form-control form-align"  tabindex="1">
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($customers) && !empty($customers)) {
                                                    foreach ($customers as $customer) {
                                                        ?>
                                                        <option <?php echo ($customer['id'] == $val['customer_id']) ? 'selected' : '' ?> value="<?php echo $customer['id']; ?>"><?php echo $customer['store_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <?php //if (($val['reference_type'] == 3) || ($val['reference_type'] == 4)) { ?>
                                        <td class="other_users curr_ref" <?php if (($val['reference_type'] == 3) || ($val['reference_type'] == 4)) { ?> style="display:block;" <?php } else { ?>style="display:none;" <?php } ?>>
                                            <input type="text" name="others" id="others" class="form-control form-align" value="<?php echo $val['others']; ?>" tabindex="1">
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <?php // } ?>
                                        </tr>
                                        <tr>
                                            <td>Contact Person<span style="color:#F00; font-style:oblique;">*</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="contact_person" id="contact_person"  class="name form-control form-align" value="<?= $val['contact_person'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                </div>
                                                <span id="contact_personerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Email Id<span style="color:#F00; font-style:oblique;">*</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="mail" class="mail up_mail_dup form-control form-align" id="mail" value="<?= $val['email_id'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Mobile Number<span style="color:#F00; font-style:oblique;">*</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="number" class="mobile form-control form-align" id="mobile" maxlength="10"value="<?php echo $val['mobil_number']; ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address1<span style="color:#F00; font-style:oblique;">*</span></td>
                                            <td>
                                                <textarea  name='address1' id="address" class="form-control form-align" tabindex="1"><?php echo $val['address1']; ?></textarea>
                                                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Address2</td>
                                            <td><textarea  name='address2' id="address" class="form-control form-align" tabindex="1"><?php echo $val['address2']; ?></textarea></td>
                                            <td>State </td>
                                            <td>
                                                <select id="state_id" name='state_id' class="state_id form-control form-align" tabindex="1" >
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (isset($all_state) && !empty($all_state)) {
                                                        foreach ($all_state as $bill) {
                                                            ?>
                                                            <option <?php echo ($bill['id'] == $val['state_id']) ? 'selected' : '' ?> value="<?php echo $bill['id'] ?>"><?= $bill['state'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select><span id="cuserror" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>City<span style="color:#F00; font-style:oblique;">*</span></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="city" id="city"  class="form-control form-align" value="<?= $val['city'] ?>"tabindex="1" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Bank Name</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?= $val['bank_name'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Bank Branch</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="branch" class="form-control form-align" id="branch" value="<?= $val['bank_branch'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Account No</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?= $val['account_num'] ?>" tabindex="1" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>IFSC Code</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="ifsc" class="form-control form-align" id="" value="<?= $val['ifsc'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fax"></i>
                                                    </div>
                                                </div>
                                            </td>
                                           <!--  <td>Agent Name</td>
                                            <td>
                                                <select id='agent'  name="agent_name"  class="form-control form-align">
                                                    <option value="">Select</option>
                                            <?php
                                            /* if (isset($all_agent) && !empty($all_agent)) {
                                              foreach ($all_agent as $va1) {
                                              ?>
                                              <option <?php echo ($val['agent_name'] == $va1['id']) ? 'selected' : '' ?> value='<?php echo $va1['id'] ?>'><?php echo $va1['name']; ?></option>
                                              <?php
                                              }
                                              } */
                                            ?>
                                                </select> <span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td> -->
                                            <td>Payment Terms</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text"  name="payment_terms" class="form-control form-align"  id="payment_terms" value="<?= $val['payment_terms'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fw fa-money"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td>Commission Rate</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="commission_rate" class="store form-control form-align" id="store" value="<?php echo $val['commission_rate'] ?>" tabindex="1"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                            ?>
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <tr>
                                        <td width="570">&nbsp;</td>
                                        <td><input type="submit" value="Update" class="submit btn btn-info1" id="edit" tabindex="1"/></td>
                                        <td>&nbsp;</td>
                                        <td><input type="reset" value="Clear" class="submit btn btn-danger1" id="reset" tabindex="1"/></td>
                                        <td>&nbsp;</td>
                                        <td><a href="<?php echo $this->config->item('base_url') . 'masters/reference_groups' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>



                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#reference_type').on('change', function ()
    {
        ref_val = $(this).val();
        if ((ref_val == 3) || (ref_val == 4))
        {
            $('.other_users').show();
            $('.customer_list').hide();
            $('.user_list').hide();
        } else if (ref_val == 2) {
            $('.customer_list').show();
            $('.user_list').hide();
            $('.other_users').hide();
        } else {
            $('.other_users').hide();
            $('.customer_list').hide();
            $('.user_list').show();
        }

    });
    $('#state_id').live('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
        } else
        {
            $('#cuserror').html("");
        }
    });

    $("#mobile").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {

            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('.state_id').live('blur', function ()
    {
        var state = $('.state_id').val();
        if (state == "37")
        {
            $('#cuserror').html('<input type="text" name="state_id" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
                        <span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');
        }
    });

    $('#state').live('blur', function () {

        var this_ = $(this).val();
        if (this_ == "")
        {
            $('#cuserror_state').html("Required Field");
        } else
        {
            $('#cuserror_state').html("");
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "customer/add_state",
                data: {state: this_},
                success: function (datas) {

                }
            });
        }

    });

    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Enter Address");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#mobile").live('blur', function ()
    {
        var number = $("#mobile").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
        } else if (number.length != 10)
        {
            $("#cuserror4").html("Please enter 10 digit mobile number");
        } else
        {
            $("#cuserror4").html("");
        }
    });

    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
        } else
        {
            $("#cuserror5").html("");
        }
    });
    /*$('#bank').live('blur', function ()
     {
     var bank = $('#bank').val();
     if (bank == "" || bank == null || bank.trim().length == 0)
     {
     $('#cuserror6').html("Enter Details");
     } else
     {
     $('#cuserror6').html("");
     }
     });*/

    $('#city').live('blur', function ()
    {
        var city = $('#city').val();
        if (city == "")
        {
            $('#cuserror8').html("Required Field");
        } else
        {
            $('#cuserror8').html("");
        }
    });

    /* $("#branch").live('blur', function ()
     {
     var branch = $("#branch").val();
     if (branch == "" || branch == null || branch.trim().length == 0)
     {
     $("#cuserror10").html("Required Field");
     } else
     {
     $("#cuserror10").html("");
     }
     });
     $("#acnum").live('blur', function ()
     {
     var acnum = $("#acnum").val();
     var acfilter = /^[a-zA-Z0-9]+$/;
     if (acnum == "")
     {
     $("#cuserror11").html("Required Field");
     } else if (!acfilter.test(acnum))
     {
     $("#cuserror11").html("Numeric or Alphanumeric");
     } else
     {
     $("#cuserror11").html("");
     }
     });
     $('#agent').live('change', function ()
     {
     var agent = $('#agent').val();
     if (agent == "")
     {
     $('#cuserror12').html("Required Field");
     } else
     {
     $('#cuserror12').html("");
     }
     });
     $("#payment_terms").live('blur', function ()
     {
     var payment_terms = $("#payment_terms").val();
     if (payment_terms == "")
     {
     $("#cuserror14").html("Required Field");
     } else
     {
     $("#cuserror14").html("");
     }
     });*/
    $('#reset').live('click', function ()
    {
        $('.val').html("");
    })
</script>
<script type="text/javascript">
    $('#edit').live('click', function ()
    {
        var i = 0;
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
            i = 1;
        } else
        {
            $('#cuserror').html("");
        }
        var name = $("#contact_person").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#contact_personerr").html("Required Field");
            i = 1;
        } else if (!filter.test(name))
        {
            $("#contact_personerr").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#contact_personerr").html("");
        }

        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Enter Address");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
        }
        var number = $("#mobile").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
            i = 1;
        } else if (number.length != 10)
        {
            $("#cuserror4").html("Please enter 10 digit mobile number");
            i = 1;
        } else
        {
            $("#cuserror4").html("");
        }
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
            i = 1;
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
            i = 1;
        } else
        {
            $("#cuserror5").html("");
        }
        /* var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#cuserror6').html("Enter Details");
         i = 1;
         } else
         {
         $('#cuserror6').html("");
         }*/
        var city = $('#city').val();
        if (city == "")
        {
            $('#cuserror8').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror8').html("");
        }
        $("#number").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 40)) {

                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
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
            }
        });

        /*var branch = $("#branch").val();
         if (branch == "" || branch == null || branch.trim().length == 0)
         {
         $("#cuserror10").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror10").html("");
         }
         var acnum = $("#acnum").val();
         var acfilter = /^[a-zA-Z0-9]+$/;
         if (acnum == "")
         {
         $("#cuserror11").html("Required Field");
         i = 1;
         } else if (!acfilter.test(acnum))
         {
         $("#cuserror11").html("Numeric or Alphanumeric");
         i = 1;
         } else
         {
         $("#cuserror11").html("");
         }
         var agent = $('#agent').val();
         if (agent == "")
         {
         $('#cuserror12').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror12').html("");
         }

         var payment_terms = $("#payment_terms").val();
         if (payment_terms == "")
         {
         $("#cuserror14").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror14").html("");
         }*/

        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }
    });
</script>
<script>
    $("#mail").live('blur', function ()
    {

        mail = $("#mail").val();
        id = $('.id').val();
        $.ajax(
                {
                    url: BASE_URL + "masters/reference_groups/update_duplicate_email",
                    type: 'POST',
                    data: {value1: mail, value2: id},
                    success: function (result)
                    {
                        $("#upduplica").html(result);
                    }
                });
    });
</script>
