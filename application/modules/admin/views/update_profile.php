<style>
    .input-group-addon .fa { width:10px !important; }
    .btn-info {
        background-color: #3db9dc;
        border-color: #3db9dc;
        color: #fff;
    }
    .btn-info:hover {
        background-color: #25a7cb;
    }
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel  conteiner-fluid panel-body mt-top20">
        <form action="<?php echo $this->config->item('base_url'); ?>admin/update_profile" method="post" enctype="multipart/form-data" name="sform">
            <div class="row">
                <div class="col-md-6" style="display: <?php $user_info = $this->user_info = $this->session->userdata('user_info');
echo ($user_info[0]['role'] == 1) ? 'block' : 'none'
?>">
                    <h4 class="cpy-details sup-align profilemargin">Company Details</h4>
                    <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" align="center">
                        <tr>
                            <td class="first_td">Company Name</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[company_name]" class="form-align form-control" id="company_name" value="<?= $company_details[0]['company_name'] ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                </div>
                                <span id="profileerror2" class="val" style="color:#F00;"></span>
                            </td>
                            <td class="first_td">Phone Number</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[phone_no]" class="form-align form-control" id="phone_no" value="<?= $company_details[0]['phone_no'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                </div>
                                <span id="profileerror3" class="val" style="color:#F00;"></span></td>
                        </tr>
                        <tr>
                            <td class="first_td">Address Line 1</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[address1]" class="form-align form-control" id="address1" value="<?= $company_details[0]['address1'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-address-book"></i>
                                    </div>
                                </div>
                                <span id="profileerror4" class="val" style="color:#F00;"></span></td>
                            <td class="first_td">Address Line 2</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[address2]" class="form-align form-control" id="address2" value="<?= $company_details[0]['address2'] ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-address-book"></i>
                                    </div>
                                </div>
                                <span id="profileerror10" class="val" style="color:#F00;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="first_td">City</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[city]" class="form-align form-control" id="city"  value="<?= $company_details[0]['city'] ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                                <span id="profileerror5" class="val" style="color:#F00;"></span></td>
                            <td class="first_td">State</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[state]" class="form-align form-control" id="state" value="<?= $company_details[0]['state'] ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                                <span id="profileerror6" class="val" style="color:#F00;"></span></td>
                        </tr>
                        <tr>
                            <td class="first_td">Pin Code</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[pin]" class="form-align form-control" id="pin" value="<?= $company_details[0]['pin'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                </div>
                                <span id="profileerror7" class="val" style="color:#F00;"></span></td>
                            <td class="first_td">Email Id</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[email]" class="form-align form-control" id="email" value="<?= $company_details[0]['email'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                </div>
                                <span id="profileerror8" class="val" style="color:#F00;"></span></td>
                        </tr>
                        <tr>
                            <td class="first_td">Account Number</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[ac_no]" class="form-align form-control" value="<?= $company_details[0]['ac_no'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <span id="profileerror7" class="val" style="color:#F00;"></span></td>
                            <td class="first_td">IFSC Code</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[ifsc]" class="form-align form-control" value="<?= $company_details[0]['ifsc'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-fax"></i>
                                    </div>
                                </div>
                                <span id="profileerror8" class="val" class="form-align form-control" style="color:#F00;"></span></td>
                        </tr>
                        <tr>
                            <td class="first_td">Bank Name</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[bank_name]" class="form-align form-control" value="<?= $company_details[0]['bank_name'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                </div>
                                <span id="profileerror7" class="val" style="color:#F00;"></span></td>
                            <td class="first_td">Branch</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[branch]" class="form-align form-control"  value="<?= $company_details[0]['branch'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-bank"></i>
                                    </div>
                                </div>
                                <span id="profileerror8" class="val" class="form-align form-control" style="color:#F00;"></span></td>
                        </tr>
                        <tr>
                            <td class="first_td">Tin No</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="company[tin_no]" class="form-align form-control" value="<?= $company_details[0]['tin_no'] ?>"  />
                                    <div class="input-group-addon">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                </div>
                            </td>
                            <td class="first_td"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4">

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4 align="center" class="sup-align profilemargin">Profile Details</h4>
                    <div class="padding10">
                    <div class="row">
                    	<div class="col-md-8">
                        	<div class="form-group">
                                <label class="col-sm-4 control-label first_td">User Name</label>
                                <div class="col-sm-8">
                                	<div class="input-group">
                                        <input type="text" name="admin_name" id="admin_name" class="admin_name form-align " value="<?= $admin[0]['username']; ?>" required readonly="" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="profileerror" class="val" style="color:#F00;"></span></td>
                            		<input type="hidden" name="id" id="admin_name" class="admin_name" value="<?= $admin[0]['id']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td">Password</label>
                                <div class="col-sm-8">
                                	<div class="input-group">
                                        <input type="password" name="password" class="form-align"  id="password" value="" autocomplete="off" maxlength="20" tabindex="3"  />
                                        <div class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label first_td">Upload Images</label>
                                <div class="col-sm-8">
                                	<div class="input-group">
                                        <input type='file' name="admin_image" id="imgInp" /><span id="profileerror9" class="val" style="color:#F00;"></span>
                                        <div class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    	<div class="col-md-4">
                                <div class="action-btn-align">
                                    <?php
                                    $exists = file_exists(FCPATH . 'admin_image/original/' . $admin[0]['admin_image']);
                                    $f_name = $admin[0]['admin_image'];
                                    $logo_image = (!empty($f_name) && $exists) ? $f_name : "admin_icon.png";
                                    ?>
    
    <!--                                    <img class="restau" src="<?php echo base_url() . 'assets/uploads/logo/' . $logo_image ?>">-->
                                    <img id="blah" class="add_staff_thumbnail" width="145px" height="145px"
                                         src="<?= $this->config->item("base_url") . 'admin_image/original/' . $logo_image; ?>"/>
                                </div>                   
                        </div> 
                        <span id="profileerror1" class="val" style="color:#F00;"></span>                       
                    </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="action-btn-align">
                            <input type="submit" value="Update" name="submit" id="submit"  class="btn btn-info"/>
                            <input type="reset" value="Cancel" id="cancel" class="btn btn-danger1"  tabindex="9"/>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        if ($(this).val() == "" || $(this).val() == null)
        {

        } else
        {
            readURL(this);
        }
    });
</script>
<script type="text/javascript">
    $('.admin_name').blur(function ()
    {
        var name = $('#admin_name').val();
        if (name == '' || name == null || name.trim().length == 0)
        {
            $('#profileerror').html("Required Field");
        } else
        {
            $('#profileerror').html("");
        }
    });
    $('#password').blur(function ()
    {
        var password = $('#password').val();
        if (password == '')
        {
        } else if (password == null || password.trim().length == 0)
        {
            $('#profileerror1').html("Required Field");
        } else
        {
            $('#profileerror1').html("");
        }
    });
    $('#company_name').blur(function ()
    {
        var cname = $('#company_name').val();
        if (cname == '' || cname == null || cname.trim().length == 0)
        {
            $('#profileerror2').html("Required Field");
        } else
        {
            $('#profileerror2').html("");
        }
    });
    $('#phone_no').blur(function ()
    {
        var phone = $('#phone_no').val();
        if (phone == '' || phone == null || phone.trim().length == 0)
        {
            $('#profileerror3').html("Required Field");
        } else
        {
            $('#profileerror3').html("");
        }
    });
    $('#address1').blur(function ()
    {
        var add1 = $('#address1').val();
        if (add1 == '' || add1 == null || add1.trim().length == 0)
        {
            $('#profileerror4').html("Required Field");
        } else
        {
            $('#profileerror4').html("");
        }
    });
    $('#address2').blur(function ()
    {
        var add2 = $('#address2').val();
        if (add2 == '' || add2 == null || add2.trim().length == 0)
        {
            $('#profileerror10').html("Required Field");
        } else
        {
            $('#profileerror10').html("");
        }
    });
    $('#city').blur(function ()
    {
        var city = $('#city').val();
        if (city == '' || city == null || city.trim().length == 0)
        {
            $('#profileerror5').html("Required Field");
        } else
        {
            $('#profileerror5').html("");
        }
    });
    $('#state').blur(function ()
    {
        var state = $('#state').val();
        if (state == '' || state == null || state.trim().length == 0)
        {
            $('#profileerror6').html("Required Field");
        } else
        {
            $('#profileerror6').html("");
        }
    });
    $('#pin').blur(function ()
    {
        var pin = $('#pin').val();
        if (pin == '' || pin == null || pin.trim().length == 0)
        {
            $('#profileerror7').html("Required Field");
        } else
        {
            $('#profileerror7').html("");
        }
    });
    $('#email').blur(function ()
    {
        var email_id = $('#email').val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (email_id == "")
        {
            $("#profileerror8").html("Required Field");
        } else if (!efilter.test(email_id))
        {
            $("#profileerror8").html("Enter Valid Email");
        } else
        {
            $("#profileerror8").html("");
        }
    });
    // Image validation size checking
    $("#imgInp").change(function () {
//alert('hi');
        var val = $(this).val();

        switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case '':
                $("#profileerror9").html("");
                break;
            default:
                $(this).val();
                // error message here
                $("#profileerror9").html("Invalid File Type");
                break;
        }
    });

    $(document).ready(function ()
    {
        $('#submit').click(function ()
        {
            var i = 0;
            var name = $('#admin_name').val();
            if (name == '' || name == null || name.trim().length == 0)
            {
                $('#profileerror').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror').html("");
            }
            var password = $('#password').val();
            if (password == '')
            {
            } else if (password == null || password.trim().length == 0)
            {
                $('#profileerror1').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror1').html("");
            }
            var cname = $('#company_name').val();
            if (cname == '' || cname == null || cname.trim().length == 0)
            {
                $('#profileerror2').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror2').html("");
            }
            var phone = $('#phone_no').val();
            if (phone == '' || phone == null || phone.trim().length == 0)
            {
                $('#profileerror3').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror3').html("");
            }
            var add1 = $('#address1').val();
            if (add1 == '' || add1 == null || add1.trim().length == 0)
            {
                $('#profileerror4').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror4').html("");
            }
            var add2 = $('#address2').val();
            if (add2 == '' || add2 == null || add2.trim().length == 0)
            {
                $('#profileerror10').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror10').html("");
            }
            var city = $('#city').val();
            if (city == '' || city == null || city.trim().length == 0)
            {
                $('#profileerror5').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror5').html("");
            }
            var state = $('#state').val();
            if (state == '' || state == null || state.trim().length == 0)
            {
                $('#profileerror6').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror6').html("");
            }
            var pin = $('#pin').val();
            if (pin == '' || pin == null || pin.trim().length == 0)
            {
                $('#profileerror7').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror7').html("");
            }
            var email_id = $('#email').val();
            var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (email_id == "" || email_id == null || email_id.trim().length == 0)
            {
                $("#profileerror8").html("Required Field");
                i = 1;
            } else if (!efilter.test(email_id))
            {
                $("#profileerror8").html("Enter Valid Email");
                i = 1;
            } else
            {
                $("#profileerror8").html("");
            }
            var mess = $('#profileerror9').html();
            if ((mess.trim()).length > 0)
            {
                i = 1;
            }
            if (i == 1)
            {
                return false;
            } else
            {
                return true;
            }

        });
    });
    $('#cancel').click(function ()
    {
        $('.val').html("");

    });
    $('#email').keyup(function () {
        $(this).val($(this).val().toLowerCase());

    });
</script>