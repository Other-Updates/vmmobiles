<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!-- <script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style>

    .input-group-addon .fa { width:10px !important; }

</style>

<div class="mainpanel">

    <div class="media">

        <h4>Update Firm</h4>

    </div>

    <div class="contentpanel">

        <div class="panel-body">

            <div class="tabs">

                <div class="">

                    <div id="update-field">

                        <form id="firm_form" action="<?php echo $this->config->item('base_url') . 'masters/firms/update_firm/' . $firms[0]['firm_id']; ?>" enctype="multipart/form-data" name="form" method="post">

                            <?php

                            if (isset($firms) && !empty($firms)) {

                                $i = 0;

                                foreach ($firms as $val) {

                                    $i++

                                    ?>

                                    <div class="row">

                                        <div class="col-md-6">



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Firm/Company Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="firm_name" class=" form-align frim_name"  id="frim_name"  maxlength="50" value="<?php echo $val['firm_name']; ?>" org_name="<?php echo $val['firm_name']; ?>" tabindex="1"/>

                                                        <input type="hidden" id='firm_id' value="<?php echo $val['firm_id']; ?>"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-user"></i>

                                                        </div>

                                                    </div>

                                                    <span id="frim_name_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                    <span id="dup" class="dup" style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Contact Person <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="contact_person" class="  form-align" id="contact_persson" maxlength="30" value="<?php echo $val['contact_person']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-user"></i>

                                                        </div>

                                                    </div>

                                                    <span id="contact_persson_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Prefix <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="prefix" class="  form-align" id="prefix" value="<?php echo $val['prefix']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-plus-square"></i>

                                                        </div>

                                                    </div>

                                                    <span id="prefix_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Email_id <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="email_id" class="  form-align" id="email_id" value="<?php echo $val['email_id']; ?>"tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="email_id_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                        </div>



                                        <div class="col-md-6">



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="mobile_number" class="  form-align" id="mobile_number" maxlength="10" value="<?php echo $val['mobile_number']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="mobile_number_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Address <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <textarea name="address"  class=" form-control form-align" id="address" tabindex="1"><?php echo $val['address']; ?></textarea>

                                                    <span id="address_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Pin Code <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="pincode" class=" form-align" id="pin_code" value="<?php echo $val['pincode']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="pin_code_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">GSTIN <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="gstin" class=" form-align" id="gstin"  value="<?php echo $val['gstin']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="gstin_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                        </div>



                                    </div>

                                    <?php

                                }

                            }

                            ?>

                            <div class="frameset_table action-btn-align">

                                <input type="submit" name="submit" class="btn btn-success" value="Update" id="submit" tabindex="1"/>

                                <input type="reset" value="Clear" class="btn btn-danger1" id="reset" tabindex="1" />

                                <a href="<?php echo $this->config->item('base_url') . 'masters/firms/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">



    $("#frim_name").on('blur', function ()

    {

        var name = $("#frim_name").val();

        if (name == "" || name == null || name.trim().length == 0)

        {

            $("#frim_name_err").html("Required Field");

        } else

        {

            $("#frim_name_err").html("");

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

            $("#contact_persson_err").html("Required Field");

        } else

        {

            $("#contact_persson_err").html("");

        }

    });

    $("#gstin").on('blur', function ()

    {

        var gstin = $("#gstin").val();

        if (gstin == "" || gstin == null || gstin.trim().length == 0)

        {

            $("#gstin_err").html("Required Field");

        } else

        {

            $("#gstin_err").html("");

        }

    });

    $("#mobile_number").keyup(function ()

    {

        var mobile_number = $("#mobile_number").val();

        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)

        {

            $("#mobile_number_err").html("Required Field");
            i = 1;

        } else if (!nfilter.test(mobile_number))

        {

            $("#mobile_number_err").html("Enter Valid Mobile Number");
            i = 1;

        } else

        {

            $("#mobile_number_err").html("");

        }

    });

    $("#email_id").on('blur', function ()

    {

        var email_id = $("#email_id").val();

        if (email_id == "" || email_id == null || email_id.trim().length == 0)

        {

            $("#email_id_err").html("Required Field");
            i = 1;

        } else

        {

            $("#email_id_err").html("");

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



    $("#pin_code").on('blur', function ()

    {

        var pin_code = $("#pin_code").val();

        var pat1 = /^\d{6}$/;

        if (pin_code.length != '6')

        {

            $("#pin_code_err").html("Pin code should be 6 digits ");

           

            return false;

        }
        if (pin_code == "" || pin_code == null || pin_code.trim().length == 0)

        {

            $("#pin_code_err").html("Required Field");

        } else

        {

            $("#pin_code_err").html("");

        }

    });



    $("#address").on('blur', function ()

    {

        var address = $("#address").val();

        if (address == "" || address == null || address.trim().length == 0)

        {

            $("#address_err").html("Required Field");

        } else

        {

            $("#address_err").html("");

        }

    });





    $('#reset').on('click', function ()

    {

        $('.val').html("");

        $('#dup').html("");

    });

</script>

<script type="text/javascript">

    $('#submit').on('click', function ()

    {

        frim_name = $.trim($("#frim_name").val());

        id = $('#firm_id').val();

        $.ajax(

                {

                    url: BASE_URL + "masters/firms/update_duplicate_firm",

                    type: 'get',

                    async: false,

                    data: {value1: frim_name, value2: id},

                    success: function (result)

                    {

                        if ($('#frim_name').attr('org_name') != frim_name)

                            $("#dup").html(result);

                    }

                });

        var i = 0;

        var contact_persson = $("#contact_persson").val();

        if (contact_persson == "" || contact_persson == null || contact_persson.trim().length == 0)

        {

            $("#contact_persson_err").html("Required Field");

            i = 1;

        } else

        {

            $("#contact_persson_err").html("");

        }



        var name = $("#frim_name").val();

        if ($('#dup').html() == 'Firm Name Already Exist')

        {

            i = 1;

        } else if (name == "" || name == null || name.trim().length == 0)

        {

            $("#frim_name_err").html("Required Field");

            i = 1;

        } else

        {

            $("#frim_name_err").html("");

        }





           var mobile_number = $("#mobile_number").val();

        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)

        {

            $("#mobile_number_err").html("Required Field");
            i = 1;

        } else if (!nfilter.test(mobile_number))

        {

            $("#mobile_number_err").html("Enter Valid Mobile Number");
            i = 1;

        } else

        {

            $("#mobile_number_err").html("");

        }

        var email_id = $("#email_id").val();

        if (email_id == "" || email_id == null || email_id.trim().length == 0)

        {

            $("#email_id_err").html("Required Field");

            i = 1;

        } else

        {

            $("#email_id_err").html("");

        }



        var gstin = $('#gstin').val();

        if (gstin == "")

        {

            $('#gstin_err').html("Required Field");

            i = 1;

        } else

        {

            $('#gstin_err').html("");

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

        var pin_code = $('#pin_code').val();

        if (pin_code == "")

        {

            $('#pin_code_err').html("Required Field");

            i = 1;

        } else

        {

            $('#pin_code_err').html("");

        }



        var address = $('#address').val();

        if (address == "")

        {

            $('#address_err').html("Required Field");

            i = 1;

        } else

        {

            $('#address_err').html("");

        }



        if (i == 1)

        {

            return false;

        } else

        {
           // alert(i);
           // $('#firm_form').submit();
           return true;

        }



    });

</script>

<script>

    $("#frim_name").on('blur', function ()

    {

        frim_name = $.trim($("#frim_name").val());

        id = $('#firm_id').val();

        $.ajax(

                {

                    url: BASE_URL + "masters/firms/update_duplicate_firm",

                    type: 'get',

                    async: false,

                    data: {value1: frim_name, value2: id},

                    success: function (result)

                    {

                        if ($('#frim_name').attr('org_name') != frim_name)

                            $("#dup").html(result);

                    }

                });

    });

</script>

