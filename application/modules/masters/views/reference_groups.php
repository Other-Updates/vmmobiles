<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">

    </div>
    <div class="contentpanel">
        <div class="media mt--2">
            <h4>Reference Group Details</h4>
        </div>
        <div class="panel-body  mb-25">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#reference-groups" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Reference Groups</a></li>
                    <li role="presentation" class=""><a href="#reference" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Reference</a></li>
                </ul>
                <div class="tab-content tabbor">
                    <?php $ref_types = array(1 => 'Workers', 2 => 'Contractor', 3 => 'HR & Team Lead', 4 => 'Others'); ?>
                    <div role="tabpanel" class="tab-pane" id="reference">
                        <form action="<?php echo $this->config->item('base_url'); ?>masters/reference_groups/insert_ref_groups" enctype="multipart/form-data" name="form" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Firm Name</label>
                                        <div class="col-sm-8">
                                            <select name="firm_id"  class="form-control form-align" id="firm" tabindex="1">
                                                <?php
                                                if (isset($firms) && !empty($firms)) {
                                                    foreach ($firms as $firm) {
                                                        ?>
                                                        <option value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="firm_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Contact Person<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="contact_person" class="name  form-align" id="contact_person" tabindex="1" maxlength="30" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            <span id="contact_personerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Address1<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea name="address1" id="address" class="form-control form-align" tabindex="1"></textarea>
                                            <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">City<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="city" class="  form-align" id="city" tabindex="1" maxlength="30"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Reference Type</label>
                                        <div class="col-sm-8">
                                            <select id="reference_type" name='reference_type' class="reference_type form-control form-align"  tabindex="1">
                                                <option value="">Select</option>
                                                <?php
                                                if (isset($ref_types) && !empty($ref_types)) {
                                                    foreach ($ref_types as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select><span id="ref_type" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email Id<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="mail" class="mail  email_dup form-align" id="mail" tabindex="1" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Address2</label>
                                        <div class="col-sm-8">
                                            <textarea name="address2" id="address"  class="form-control form-align" tabindex="1"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">User Name</label>
                                        <div class="col-sm-8 user_list">
                                            <select id="user" name='user' class="user form-control form-align" tabindex="1" >
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($user_list) && !empty($user_list)) {
                                                    foreach ($user_list as $userlist) {
                                                        ?>
                                                        <option value="<?php echo $userlist['id']; ?>"><?php echo $userlist['name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                        <div class="col-sm-8 customer_list">
                                            <select id="customer_id" name='customer_id' class="user form-control form-align" tabindex="1">
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($customers) && !empty($customers)) {
                                                    foreach ($customers as $customer) {
                                                        ?>
                                                        <option value="<?php echo $customer['id']; ?>"><?php echo $customer['store_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                        <div class="col-sm-8 other_users">
                                            <input type="text" name="others" id="others" class="form-control form-align" tabindex="1">
                                            <span id="user1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Mobile Number<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="number" class="number  form-align" id="number" tabindex="1" maxlength="10"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">State<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select id="state_id" name='state_id' class="user form-control form-align" tabindex="1" >
                                                <option value="">Select</option>
                                                <?php
                                                if (isset($all_state) && !empty($all_state)) {
                                                    foreach ($all_state as $val) {
                                                        ?>
                                                        <option value="<?php echo $val['id']; ?>"><?php echo $val['state']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select><span id="cuserror" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="inner-sub-tit mstyle">Bank Details</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Bank Name</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="bank" class=" form-align" id="bank" tabindex="1" maxlength="40"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-bank"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">IFSC Code<span style="color:#F00; font-style:oblique;"></span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="ifsc" class=" form-align" id="ifsc" tabindex="1" maxlength="12"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fax"></i>
                                                </div>
                                            </div>
                                            <span id="ifsc1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Bank Branch</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="branch" class=" form-align" id="branch" tabindex="1"  maxlength="40"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-bank"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Payment Terms</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text"  name="payment_terms"  class=" form-align" id="payment_terms" tabindex="1" maxlength="40"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fw fa-money"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Account No</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="acnum" class=" form-align" id="acnum" tabindex="1" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Commission Rate</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="commission_rate" class="store  form-align" id="store" tabindex="1" maxlength="40"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-bank"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

         <!-- <td>Agent Name</td>
         <td>
             <select id='agent'  name="agent_name"  class=" form-align">
                 <option value="">Select</option>
                            <?php
                            /* if (isset($all_agent) && !empty($all_agent)) {
                              foreach ($all_agent as $val) {
                              ?>
                              <option value='<?php echo $val['id']; ?>'><?php echo $val['name']; ?></option>
                              <?php
                              }
                              } */
                            ?>
             </select><span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>
         </td> -->



                            <div class="frameset_table action-btn-align">
                                <table>
                                    <tr>
                                        <td width="570">&nbsp;</td>
                                        <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" tabindex="1"/></td>
                                        <td>&nbsp;</td>
                                        <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" tabindex="1" /></td><td>&nbsp;</td>
                                        <td><a href="<?php echo $this->config->item('base_url') . 'masters/reference_groups' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="reference-groups">
                        <div class="frameset_big1">
                            <!--<h4 align="center" class="sup-align">Customer Details</h4>-->
                            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="list">
                                <thead>
                                <th width='5%'>S.No</th>
                                <th width='20%'>Firm Name</th>
                                <th width='10%'>User Name</th>
                                <th width='10%'>Reference Type</th>
                                <th width='15%'>Email Id</th>
                                <th width='10%'>Mobile Number</th>
                                <th width='10%' class="action-btn-align">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($references) && !empty($references)) {
                                        $this->load->model('masters/customer_model');
                                        $this->load->model('masters/user_model');
                                        $i = 0;
                                        foreach ($references as $val) {
                                            if ($val['reference_type'] == 1) {
                                                $user_name = $this->user_model->get_user_name_by_id($val['user_id']);
                                            } else if ($val['reference_type'] == 2) {
                                                $user_name = $this->customer_model->get_customer_name_by_id($val['customer_id']);
                                            } else {
                                                $user_name = array();
                                            }
                                            $i++
                                            ?>
                                            <tr>
                                                <td class="first_td"><?php echo "$i"; ?></td>
                                                <td><?= $val['firm_name'] ?></td>
                                                <td>
                                                    <?php
                                                    if (count($user_name) > 0) {
                                                        echo $user_name[0]['name'];
                                                    } else {
                                                        echo $val['others'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $ref_types[$val['reference_type']]; ?></td>
                                                <td><?php echo $val['email_id']; ?></td>
                                                <td><?php echo $val['mobil_number']; ?></td>
                                                <td class="action-btn-align">
                                                    <a href="<?php echo $this->config->item('base_url') . 'masters/reference_groups/edit_ref_group/' . $val['id']; ?>" class="tooltips btn btn-default btn-xs" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<?php $base_url = $this->config->item('base_url'); ?>
<script type="text/javascript">
    $('document').ready(function ()
    {
        $('.customer_list').hide();
        $('.other_users').hide();
    });

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
    $('.state_id').live('blur', function ()
    {
        var state = $('.state_id').val();
        if (state == "37")
        {
            $('#cuserror').html('<input type="text" name="state" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
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


    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#cuserror1").html("");
        }
    });

    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
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
    /* $('#bank').live('blur', function ()
     {
     var bank = $('#bank').val();
     if (bank == "" || bank == null || bank.trim().length == 0)
     {
     $('#cuserror6').html("Required Field");
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


    $('#reset').live('click', function ()
    {
        $('.val').html("");
    });
</script>
<script type="text/javascript">
    $('#submit').live('click', function ()
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
            $('#cuserror3').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
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

        var mobile_number = $("#number").val();
        if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)
        {
            $("#cuserror4").html("Required Field");
        } else if (mobile_number.length != 10)
        {
            $("#cuserror4").html("Please enter 10 digit mobile number");
        } else
        {
            $("#cuserror4").html("");
        }
        var mail = $('#mail').val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").text("MailID is required");
            i = 1;
        } else if (mail != "" && !efilter.test(mail)) {
            $("#cuserror5").text('Enter Valid Email');
            i = 1;
        } else
        {
            $("#cuserror5").text('');
        }

//        var ifsc = $('#ifsc').val();
//        var ifscformat = /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/;
//        if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)
//        {
//            $('#ifsc1').html("Required Field");
//            i = 1;
//        } else if (ifsc != "" && !ifscformat.test(ifsc)) {
//            $("#ifsc1").text('Enter Valid IFSC Code');
//            i = 1;
//        } else
//        {
//            $("#ifsc1").text('');
//        }

        /*var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#cuserror6').html("Required Field");
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

        /* var branch = $("#branch").val();
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
    $(".email_dup").live('blur', function ()
    {
        email = $.trim($("#mail").val());
        var firm_id = $.trim($("#firm").val());
        if ($.trim(email) != '')
        {
            $.ajax(
                    {
                        url: BASE_URL + "masters/reference_groups/add_duplicate_email",
                        type: 'POST',
                        async: false,
                        data: {email: email, firm_id: firm_id},
                        success: function (result)
                        {
                            $("#duplica").html(result);
                        }
                    });
        }


//        email = $("#mail").val();
//        $.ajax(
//                {
//                    url: BASE_URL + "masters/reference_groups/add_duplicate_email",
//                    type: 'get',
//                    data: {value1: email},
//                    success: function (result)
//                    {
//                        $("#duplica").html(result);
//                    }
//                });
    });
</script>



<?php
if (isset($references) && !empty($references)) {
    foreach ($references as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                        <h3 id="myModalLabel" class="inactivepop">In-Active Reference Groups</h3>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This Reference Group? </strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>



<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="close1" data-dismiss="modal">×</a>
            <div class="modal-body">
                <img src="<?php echo $this->config->item('base_url') . '/cust_image/thumb/' . $val['cus_image']; ?>" width="50%" />

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);

            $.ajax({
                url: BASE_URL + "masters/reference_groups/delete_reference_group",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "reference_groups/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>