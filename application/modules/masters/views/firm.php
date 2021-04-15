<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>-->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>



<style>

    .input-group-addon .fa { width:10px !important; }

    .dataTables_wrapper {position: relative;clear: both;zoom: 1;}

</style>

<div class="mainpanel">

    <div class="media">

        <h4>Shop Details</h4>

    </div>

    <div class="contentpanel mb-40">

        <div class="panel-body">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#field-agent-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Shop List</a></li>

                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'firms', 'add')): ?>#field-agent<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'firms', 'add')): ?>alerts<?php endif ?>">Add Shop</a></li>

                </ul>



                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="field-agent">

                        <form action="<?php echo $this->config->item('base_url'); ?>masters/firms/insert_firms" enctype="multipart/form-data" name="form" method="post">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Shop Name<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="firm_name" class=" form-align frim_name"  id="frim_name" maxlength="50"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="frim_name_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            <span id="dup" class="dup" style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Contact Person<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="contact_person" class="  form-align" id="contact_persson" maxlength="30"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="contact_persson_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Prefix<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="prefix" class="  form-align" id="prefix" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-plus-square"></i>

                                                </div>

                                            </div>

                                            <span id="prefix_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Email id<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="email_id" class="  form-align" id="email_id" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-envelope"></i>

                                                </div>

                                            </div>

                                            <span id="email_id_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-6">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Mobile Number<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="mobile_number" class="  form-align" id="mobile_number" maxlength="10"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fw fa-phone"></i>

                                                </div>

                                            </div>

                                            <span id="mobile_number_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <textarea name="address"  class=" form-control form-align" id="address"></textarea>

                                            <span id="address_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Pin Code<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="pincode" class=" form-align" id="pin_code"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-shopping-cart"></i>

                                                </div>

                                            </div>

                                            <span id="pin_code_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">GSTIN<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="gstin" class=" form-align" id="gstin"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-shopping-cart"></i>

                                                </div>

                                            </div>

                                            <span id="gstin_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                            </div>



                            <div class="frameset_table action-btn-align">

                                <table>

                                    <td width="540">&nbsp;</td>

                                    <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>

                                    <td>&nbsp;</td>

                                    <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td><td>&nbsp;</td>

                                    <td><a href="<?php echo $this->config->item('base_url') . 'masters/firms/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>

                                </table>

                            </div>

                        </form>

                        <!--<form style="display:none">

                            <table class="table table-striped responsive no-footer dtr-inline">

                                <tr>

                                    <td width="12%">Firm/Company Name <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="firm_name" class="form-control form-align frim_name"  id="frim_name" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-user"></i>

                                            </div>

                                        </div>

                                        <span id="frim_name_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        <span id="dup" class="dup" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td width="12%">Contact Person <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="contact_person" class=" form-control form-align" id="contact_persson" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-user"></i>

                                            </div>

                                        </div>

                                        <span id="contact_persson_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                                <tr>

                                    <td width="12%">Prefix <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="prefix" class=" form-control form-align" id="prefix" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-plus-square"></i>

                                            </div>

                                        </div>

                                        <span id="prefix_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>



                                    <td width="12%">Email id <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="email_id" class=" form-control form-align" id="email_id" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-envelope"></i>

                                            </div>

                                        </div>

                                        <span id="email_id_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                                <tr>



                                    <td width="12%">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="mobile_number" class=" form-control form-align" id="mobile_number" maxlength="10"/>

                                            <div class="input-group-addon">

                                                <i class="fa fa-fw fa-phone"></i>

                                            </div>

                                        </div>

                                        <span id="mobile_number_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td width="12%">Address <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <textarea name="address"  class=" form-control form-align" id="address"></textarea>

                                        <span id="address_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                                <tr>

                                    <td width="12%">Pin Code <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td width="18%">

                                        <div class="input-group">

                                            <input type="text" name="pincode" class="form-control form-align" id="pin_code"/>

                                            <div class="input-group-addon">

                                                <i class="fa fa-marker"></i>

                                            </div>

                                        </div>

                                        <span id="pin_code_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>



                            </table>

                            <div class="frameset_table action-btn-align">

                                <input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" />

                                <input type="reset" value="Clear" class="btn btn-danger1" id="reset" />

                                <a href="<?php echo $this->config->item('base_url') . 'masters/firms/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>-->

                    </div>

                    <div role="tabpanel" class="tab-pane active tablelist" id="field-agent-details">

                        <div class="frameset_big1">

                            <table id="basicTable"  class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer">

                                <thead>

                                    <tr>

                                        <th  class='action-btn-align'>S.No</th>

                                        <th class='action-btn-align'>Shop Name</th>

                                        <th class='action-btn-align'>Contact&nbsp;Person</th>

                                        <th class='action-btn-align'>Prefix</th>

                                        <th class='action-btn-align'>Mobile Number</th>

                                        <th class='action-btn-align'>Email ID</th>

                                        <th  class="action-btn-align">Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php
                                    if (isset($firms) && !empty($firms)) {

                                        $i = 0;

                                        foreach ($firms as $val) {

                                            $i++
                                            ?>

                                            <tr>

                                                <td class="first_td action-btn-align"><?php echo "$i"; ?></td>

                                                <td><?= $val['firm_name'] ?></td>

                                                <td><?= $val['contact_person'] ?></td>

                                                <td><?= $val['prefix'] ?></td>

                                                <td class="action-btn-align"><?= $val['mobile_number'] ?></td>

                                                <td class="action-btn-align"><?= $val['email_id'] ?></td>

                                                <td class="action-btn-align">

                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'firms', 'edit')): ?><?php echo $this->config->item('base_url') . 'masters/firms/edit_firm/' . $val['firm_id'] ?><?php endif ?>" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'firms', 'edit')): ?>alerts<?php endif ?>" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;

<a href="<?php if ($this->user_auth->is_action_allowed('masters', 'firms', 'delete')): ?>#test3_<?php echo $val['firm_id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'firms', 'delete')): ?>alerts<?php endif ?>" title="In-Active">

                                                        <span class="fa fa-ban"></span></a>

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





    <br />





    <script type="text/javascript">

        $(document).on('click', '.alerts', function () {

            sweetAlert("Oops...", "This Access is blocked!", "error");

            return false;

        });



        $("#frim_name").on('blur', function ()

        {

            var name = $("#frim_name").val();

            if (name == "" || name == null || name.trim().length == 0)

            {

                $("#frim_name_err").text("Required Field");

            } else

            {

                $("#frim_name_err").text("");

            }

        });

        $("#prefix").on('blur', function ()

        {

            var prefix = $("#prefix").val();

             var regex = new RegExp("^[a-zA-Z\\s]+$");
            var char_test = regex.test(prefix);


            if (prefix == "" || prefix == null || prefix.trim().length == 0)

            {

                $("#prefix_err").text("Required Field");

            } else if (prefix != "") {

                    if (char_test == false) {

                        $("#prefix_err").html("Invalid Prefix");

                        i = 1;
                    } else {
                        $("#prefix_err").html("");
                    }

                } 
            else
            {

                $("#prefix_err").text("");

            }

        });

        $("#contact_persson").on('blur', function ()

        {

            var contact_persson = $("#contact_persson").val();

            if (contact_persson == "" || contact_persson == null || contact_persson.trim().length == 0)

            {

                $("#contact_persson_err").text("Required Field");

            } else

            {

                $("#contact_persson_err").text("");

            }

        });



        $("#mobile_number").keyup(function ()

        {

            var mobile_number = $("#mobile_number").val();

            var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

            if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)

            {

                $("#mobile_number_err").text("Required Field");

            } else if (!nfilter.test(mobile_number))

            {

                $("#mobile_number_err").text("Enter Valid Mobile Number");

            } else

            {

                $("#mobile_number_err").text("");

            }

        });



        $("#email_id").on('blur', function ()

        {

            var email_id = $("#email_id").val();

            if (email_id == "" || email_id == null || email_id.trim().length == 0)

            {

                $("#email_id_err").text("Required Field");

            } else

            {

                $("#email_id_err").text("");

            }

        });



        $("#pin_code").on('blur', function ()

        {

            var pin_code = $("#pin_code").val();

            var pat1 = /^\d{6}$/;



            if (pin_code == "" || pin_code == null || pin_code.trim().length == 0)

            {

                $("#pin_code_err").text("Required Field");

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



        $("#gstin").on('blur', function ()

        {

            var gstin = $("#gstin").val();



//            var reggst = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/;

//            if (!reggst.test(gstin) && gstin != '' && gstin.length != 15) {

//                $("#gstin_err").html('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');

//            }

            if (gstin == "" || gstin == null || gstin.trim().length == 0)

            {

                $("#gstin_err").text("Required Field");

            } else

            {

                $("#gstin_err").text("");

            }

        });


        $("#email_id").on('blur', function ()

        {

            var mail = $("#email_id").val();

            var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

            if (mail == "")

            {

                $("#email_id_err").text("Required Field");
                i = 1;

            } else if (!efilter.test(mail))

            {

                $("#email_id_err").text("Enter Valid Email");
                i = 1;

            } else

            {

                $("#email_id_err").text("");

            }

        });


        $("#address").on('blur', function ()

        {

            var address = $("#address").val();

            if (address == "" || address == null || address.trim().length == 0)

            {

                $("#address_err").text("Required Field");

            } else

            {

                $("#address_err").text("");

            }

        });





        $('#reset').on('click', function ()

        {

            $('.val').text("");

            $('#dup').text("");

        });

    </script>

    <script type="text/javascript">

        $('#submit').on('click', function ()

        {

            frim_name = $.trim($("#frim_name").val());

            $.ajax(
                    {
                        url: BASE_URL + "masers/firms/add_duplicate_firm",
                        type: 'get',
                        async: false,
                        data: {value1: frim_name},
                        success: function (result)

                        {

                            $("#dup").html(result);

                        }

                    });

            var i = 0;

            var contact_persson = $("#contact_persson").val();

            if (contact_persson == "" || contact_persson == null || contact_persson.trim().length == 0)

            {

                $("#contact_persson_err").text("Required Field");

                i = 1;

            } else

            {

                $("#contact_persson_err").text("");

            }



            var name = $("#frim_name").val();

            if ($('#dup').html() == 'Firm Name Already Exist')

            {

                i = 1;

            } else if (name == "" || name == null || name.trim().length == 0)

            {

                $("#frim_name_err").text("Required Field");

                i = 1;

            } else

            {

                $("#frim_name_err").text("");

            }



            var mobile_number = $("#mobile_number").val();

            if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)

            {

                $("#mobile_number_err").text("Required Field");

            } else

            {

                $("#mobile_number_err").text("");

            }



            var mail = $('#email_id').val();

            var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

            if (mail == "")

            {

                $("#email_id_err").text("MailID is required");

                i = 1;

            } else if (mail != "" && !efilter.test(mail)) {

                $("#email_id_err").text('Enter Valid Email');

                i = 1;

            } else

            {

                $("#email_id_err").text('');

            }






            var pin_code = $('#pin_code').val();

            var pat1 = /^\d{6}$/;

            if (pin_code == "")

            {

                $('#pin_code_err').text("Required Field");

                i = 1;

            } else

            {

                if (!pat1.test(pin_code))

                {

                    $("#pin_code_err").text("Pin code should be 6 digits ");

                    i = 1;

                } else {

                    $("#pin_code_err").text("");

                }

            }





            var gstin = $('#gstin').val();

            if (gstin == "")

            {

                $('#gstin_err').text("Required Field");

                i = 1;

            } else

            {

                $('#gstin_err').text("");

            }



            var prefix = $('#prefix').val();
            var regex = new RegExp("^[a-zA-Z\\s]+$");
            var char_test = regex.test(prefix);

            if (prefix == "")

            {

                $('#prefix_err').text("Required Field");

                i = 1;

            } else if (prefix != "") {

                    if (char_test == false) {

                        $("#prefix_err").html("Invalid Prefix");

                        i = 1;
                    } else {
                        $("#prefix_err").html("");
                    }

                } 
             else

            {

                $('#prefix_err').text("");

            }



            var address = $('#address').val();

            if (address == "")

            {

                $('#address_err').text("Required Field");

                i = 1;

            } else

            {

                $('#address_err').text("");

            }



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

        $("#frim_name").on('blur', function ()

        {

            firm_name = $.trim($("#frim_name").val());



            $.ajax(
                    {
                        url: BASE_URL + "masters/firms/add_duplicate_firm",
                        type: 'get',
                        data: {value1: firm_name},
                        success: function (result)

                        {

                            $("#dup").html(result);

                        }

                    });

        });

    </script>











<?php
if (isset($firms) && !empty($firms)) {

    foreach ($firms as $val) {
        ?>

            <div id="test3_<?php echo $val['firm_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

                <div class="modal-dialog">

                    <div class="modal-content modalcontent-top">

                        <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                            <h3 id="myModalLabel" class="inactivepop">In-Active Product</h3>

                        </div>

                        <div class="modal-body">

                            Do You Want In-Active This Product?<strong><?= $val['firm_name']; ?></strong>

                            <input type="hidden" value="<?php echo $val['firm_id']; ?>" class="id" />

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

</div>

</div>



<script type="text/javascript">

    $(document).ready(function ()

    {

        $(".delete_yes").on("click", function ()

        {



            var hidin = $(this).parent().parent().find('.id').val();



            $.ajax({
                url: BASE_URL + "masters/firms/delete_firm",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {



                    window.location.reload(BASE_URL + "masters/firms");

                }

            });



        });



        $('.modal').css("display", "none");

        $('.fade').css("display", "none");



    });

</script>