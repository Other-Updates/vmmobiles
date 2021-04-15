<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script> -->

<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<script type="text/javascript" src="<?php echo $theme_path; ?>/select2/select2.min.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/select2/select2.min.css">

<style type="text/css">

    .select2-container { border:0px #fff solid; }
	table tr td:nth-child(4) {text-align:center;}
	table tr td:nth-child(5) {text-align:center;}

</style>

<div class="mainpanel">

    <div class="media">

    </div>

    <div class="contentpanel mb-50">

        <div class="media mt--2">

            <h4>User Details</h4>

        </div>

        <div class="panel-body">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#user-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">User List</a></li>

                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'add')): ?>#user<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'add')): ?>alerts<?php endif ?>">Add User</a></li>

                </ul>



                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="user">

                        <form action="<?php echo $this->config->item('base_url'); ?>masters/users/insert_user" enctype="multipart/form-data" name="form" method="post">

                            <div class="row">

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Shop Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <select name="firm_id[]" multiple="" class="form-control required form-align select2" id="firm" >

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

                                            <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="name" class="form-align" id="name" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">User Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <input type="text" name="user_name" class="form-control form-align" id="user_name" maxlength="25" />

                                            <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            <span id="duplica_user" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Password <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <input type="password" name="pass" class="form-control form-align" maxlength="20" id="pass" />

                                            <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Nick Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="nick_name" class="form-align" id="nick_name" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="nick" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="number" class="number form-align" id="number" maxlength="10"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-phone"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Role <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <select name="role" class="form-control form-align" id="role" >

                                                <option value="">--Select--</option>

<?php
if (isset($user) && !empty($user)) {

    foreach ($user as $users) {
        ?>

                                                        <option value="<?php echo $users['id']; ?>"> <?php echo $users['user_role']; ?> </option>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>

                                            <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Email Id <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="mail" class="mail email_dup form-align" id="mail" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-envelope"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <textarea name="address1" id="address" class="form-control form-align"></textarea>

                                            <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Signature <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="row">

                                                <div class="col-md-2">

                                                    <img id="blah" class="add_staff_thumbnail" width="32px" height="33px" src="<?= $this->config->item("base_url") . 'attachement/sign/no_image.jpg'; ?>"/>

                                                </div>

                                                <div class="col-md-10">

                                                    <input type="file" name="signature" class="margin0 imgInp form-control email_dup form-align" id="signature" />

                                                    <span id="sign" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                </div>

                            </div>

                            <div class="frameset_table action-btn-align">

                                <input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" />

                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" />

                                <a href="<?php echo $this->config->item('base_url') . 'masters/users/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>

                    </div>

                    <div role="tabpanel" class="tab-pane active tablelist" id="user-details">

                        <div class="frameset_big1">



                            <table id="basicTable"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                                <thead>

                                <th class='action-btn-align' >S.No</th>

                                <th class='action-btn-align'>Name</th>

                                <th class='action-btn-align'>User Name</th>

                                <th class='action-btn-align'>Mobile Number</th>

                                <th class='action-btn-align'>Email Id</th>

                                <th class='action-btn-align'>User Role</th>

                                <th class='action-btn-align'>Shop Name</th>

                                <th class='action-btn-align' >Action</th>

                                </thead>

                                <tbody>

<?php
if (isset($agent) && !empty($agent)) {

    $i = 0;

    foreach ($agent as $val) {

        $i++;
        ?>

                                            <tr>

                                                <td class="first_td"><?php echo "$i"; ?></td>

                                                <td><?php echo $val['name']; ?></td>

                                                <td><?php echo $val['username']; ?></td>

                                                <td><?php echo $val['mobile_no']; ?></td>

                                                <td><?php echo $val['email_id']; ?></td>

                                                <td><?php echo $val['user_role']; ?></td>

                                                <td><?php foreach ($val['firm_name'] as $list) { ?>

                                                        <span class="badge bg-green" style="padding: 2px;"><?php echo $list['name']; ?></span><br>

        <?php }
        ?></td>

                                                <td class="action-btn-align">

                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'edit')): ?><?php echo $this->config->item('base_url') . 'masters/users/edit_user/' . $val['id']; ?><?php endif ?>" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'edit')): ?>alerts<?php endif ?>" title="Edit">

                                                        <span class="fa fa-edit"></span></a>

                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'delete')): ?>alerts<?php endif ?>" title="In-Active">

                                                        <span class="fa fa-ban "></span></a>

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

<script type="text/javascript">

    $(document).on('click', '.alerts', function () {

        sweetAlert("Oops...", "This Access is blocked!", "error");

        return false;

    });

    function readURL(input) {

        console.log(input);

        if (input.files && input.files[0]) {

            var reader = new FileReader();



            reader.onload = function (e) {

                $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);

                $(input).closest('div').find('#blah').attr('src', e.target.result);

            }

            reader.readAsDataURL(input.files[0]);

        }

    }

    $(".imgInp").on('change', function () {

        readURL(this);

    });



    $("#name").on('blur', function ()

    {

        var name = $("#name").val();

        var filter = /^[a-zA-Z.\s]{3,30}$/;

        if (name == "" || name == null || name.trim().length == 0)

        {

            $("#cuserror1").text("Required Field");

        } else if (!filter.test(name))

        {

            $("#cuserror1").text("Alphabets and Min 3 to Max 30 ");

        } else

        {

            $("#cuserror1").text("");

        }

    });

    $("#user_name").on('blur', function ()

    {

        var store = $("#user_name").val();

        if (store == "" || store == null || store.trim().length == 0)

        {

            $("#cuserror8").text("Required Field");

        } else

        {

            $("#cuserror8").text("");

        }

    });

    $("#nick_name").on('blur', function ()

    {

        var nick_name = $("#nick_name").val();

        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)

        {

            $("#nick").text("Required Field");

        } else

        {

            $("#nick").text("");

        }

    });



    $('#address').on('blur', function ()

    {

        var address = $('#address').val();

        if (address == "" || address == null || address.trim().length == 0)

        {

            $('#cuserror3').text("Required Field");

        } else

        {

            $('#cuserror3').text("");

        }

    });

    $("#number").keyup(function ()

    {

        var number = $("#number").val();

        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (number == "")

        {

            $("#cuserror4").text("Required Field");

        } else if (!nfilter.test(number))

        {

            $("#cuserror4").text("Enter Valid Mobile Number");

        } else

        {

            $("#cuserror4").text("");

        }

    });

    $("#mail").on('blur', function ()

    {

        var mail = $("#mail").val();

        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        if (mail == "")

        {

            $("#cuserror5").text("Required Field");

        } else if (!efilter.test(mail))

        {

            $("#cuserror5").text("Enter Valid Email");

        } else

        {

            $("#cuserror5").text("");

        }

    });

    $('#role').on('blur', function ()

    {

        var bank = $('#role').val();

        if (bank == "" || bank == null || bank.trim().length == 0)

        {

            $('#cuserror6').text("Required Field");

        } else

        {

            $('#cuserror6').text("");

        }

    });



    $('#firm').on('blur', function ()

    {

        var firm = $('#firm').val();



        if (firm == "" || firm == null || firm.trim().length == 0)

        {

            $('#cuserror9').text("Required Field");

        } else

        {

            $('#cuserror9').text("");

        }

    });



    $("#pass").on('blur', function ()

    {

        var acnum = $("#pass").val();

        if (this.value.length > 8) {

            $("#cuserror11").text('You have entered less than 8 characters for password');

            $(this).focus();

            return false;

        }

        if (acnum == "")

        {

            $("#cuserror11").text("Required Field");

        } else

        {

            $("#cuserror11").text("");

        }

    });

    $("#signature").on('blur', function () {

        var file = $('input[type="file"]').val();

        var exts = ["jpg", "jpeg", "gif", "png"];

        if (file) {

            var get_ext = file.split('.');

            get_ext = get_ext.reverse();

            if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {

                $("#sign").text('');



            } else {

                $("#sign").text("File must be jpg,png,jpeg,gif");

                return false;

            }

        }

        var file_size = $('#signature')[0].files[0].size;

        if (file_size > 2097152) {

            $("#sign").text("File size is greater than 2MB");

            return false;

        }

    });



</script>

<script type="text/javascript">





    $('#submit').on('click', function ()

    {

        var i = 0;



        $('select.required').each(function () {

            this_val = $.trim($(this).val());

            this_id = $(this).attr('id');



            if (this_val == '') {

                $('#cuserror9').text('Required Field');

                i = 1;

            } else {

                $('#cuserror9').text('');



            }

        });



        var name = $("#name").val();

        var filter = /^[a-zA-Z.\s]{3,30}$/;

        if (name == "" || name == null || name.trim().length == 0)

        {

            $("#cuserror1").text("Required Field");

            i = 1;

        } else if (!filter.test(name))

        {

            $("#cuserror1").text("Alphabets and Min 3 to Max 30 ");

            i = 1;

        } else

        {

            $("#cuserror1").text("");

        }





        var user_name = $("#user_name").val();

        if (user_name == "" || user_name == null || user_name.trim().length == 0)

        {

            $("#cuserror8").text("Required Field");

            i = 1;

        } else

        {

            $("#cuserror8").text("");

        }



        var acnum = $("#pass").val();

        if (acnum == "")

        {

            $("#cuserror11").text("Required Field");

        } else

        {

            $("#cuserror11").text("");

        }



        var signature = $("#signature").val();

        if (signature == "" || signature == null || signature.trim().length == 0)

        {

            // $("#sign").text("Required Field");

            //   i = 1;

        } else

        {

            $("#sign").text("");

        }



        var nick_name = $("#nick_name").val();

        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)

        {

            $("#nick").text("Required Field");

            i = 1;

        } else

        {

            $("#nick").text("");

        }



        var number = $("#number").val();

        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (number == "")

        {

            $("#cuserror4").text("Required Field");

            i = 1;

        } else if (!nfilter.test(number))

        {

            $("#cuserror4").text("Enter Valid Mobile Number");

            i = 1;

        } else

        {

            $("#cuserror4").text("");

        }



        var mail = $("#mail").val();

        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        if (mail == "")

        {

            $("#cuserror5").text("Required Field");

            i = 1;

        } else if (!efilter.test(mail))

        {

            $("#cuserror5").text("Enter Valid Email");

            i = 1;

        } else

        {

            $("#cuserror5").text("");

        }

        var bank = $('#role').val();

        if (bank == "" || bank == null || bank.trim().length == 0)

        {

            $('#cuserror6').text("Required Field");

            i = 1;

        } else

        {

            $('#cuserror6').text("");

        }



        var address = $('#address').val();

        if (address == "" || address == null || address.trim().length == 0)

        {

            $('#cuserror3').text("Required Field");

            i = 1;

        } else

        {

            $('#cuserror3').text("");

        }

        var acnum = $("#pass").val();

        if (acnum == "")

        {

            $("#cuserror11").text("Required Field");

            i = 1;

        } else

        {

            $("#cuserror11").text("");

        }

        var mess = $('#duplica').html();

        if ((mess.trim()).length > 0)

        {

            i = 1;

        }



        var user = $('#duplica_user').html();

        if ((user.trim()).length > 0)

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

</script>

<script>

    $(".email_dup").on('blur', function ()

    {

        email = $("#mail").val();

        $.ajax(
                {
                    url: BASE_URL + "masters/users/add_duplicate_email",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)

                    {

                        $("#duplica").html(result);

                    }

                });

    });



    $("#user_name").on('blur', function ()

    {



        email = $("#user_name").val();

        $.ajax(
                {
                    url: BASE_URL + "masters/users/add_duplicate_user",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)

                    {

                        $("#duplica_user").html(result);

                    }

                });

    });

</script>







<?php
if (isset($agent) && !empty($agent)) {

    foreach ($agent as $val) {
        ?>

        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

            <div class="modal-dialog">

                <div class="modal-content modalcontent-top">

                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                        <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>

                    </div>

                    <div class="modal-body">

                        Do You Want In-Active This user?<strong><?php echo $val['name']; ?></strong>

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





<script type="text/javascript">

    $(document).ready(function ()

    {

        $('#firm').select2();

        $(".delete_yes").on("click", function ()

        {



            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "masters/users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {



                    window.location.reload(BASE_URL + "masters/users/");

                }

            });



        });



        $('.modal').css("display", "none");

        $('.fade').css("display", "none");



    });

</script>