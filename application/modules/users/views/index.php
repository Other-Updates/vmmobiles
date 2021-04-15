<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
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
                    <li role="presentation" class=""><a href="#user" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add User</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="user">
                        <!--<h4 align="center" class="sup-align">Add User</h4>-->
                        <form action="<?php echo $this->config->item('base_url'); ?>users/insert_user" enctype="multipart/form-data" name="form" method="post"> 
                            <table class="table table-striped responsive no-footer dtr-inline">
                                <tr>
                                    <td width="12%">Name</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control form-align" id="name" /> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="12%">Nick Name</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="nick_name" class=" form-control form-align" id="nick_name" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <span id="nick" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="12%">User Name</td>
                                    <td width="18%">
                                        <input type="text" name="user_name" class=" form-control form-align" id="user_name" />
                                        <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>                 
                                </tr>
                                <tr>
                                    <td width="12%">Password</td>
                                    <td width="18%">
                                        <input type="password" name="pass" class="form-control form-align" id="pass" />
                                        <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="12%">Mobile Number</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="number" class="number form-control form-align" id="number" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                        </div>
                                        <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>         
                                    <td width="12%">Role</td>
                                    <td width="18%">
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
                                    </td>

                                </tr>
                                <tr>
                                    <td width="12%">Email Id</td>
                                    <td width="18%">
                                        <div class="input-group">
                                        <input type="text" name="mail" class="mail form-control email_dup form-align" id="mail" />
                                        <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                        </div>
                                        <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td> 
                                    <td width="12%">Address</td>
                                    <td width="18%">
                                        <textarea name="address1" id="address" class="form-control form-align"></textarea>
                                        <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                    <td width="12%">Signature</td>
                                    <td width="18%" rowspan="2" colspan="2">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img id="blah" class="add_staff_thumbnail" width="32px" height="33px" 
                                                     src="<?= $this->config->item("base_url") . 'attachement/sign/no-img.gif' ?>"/> 
                                            </div>
                                            <div class="col-md-10 adminprofile">
                                                <input type="file" name="signature" class=" imgInp form-control email_dup form-align" id="signature" />
                                                <span id="sign" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </table>    
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <td width="570">&nbsp;</td>
                                    <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>
                                    <td>&nbsp;</td>
                                    <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td> <td>&nbsp;</td>
                                    <td><a href="<?php echo $this->config->item('base_url') . 'users/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="user-details">
                        <div class="frameset_big1">

                            <!--<h4 align="center" class="sup-align">User Details</h4>-->
                            <table id="basicTable"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="list">
                                <thead>
                                <th>S.No</th>       
                                <th>Name</th>
                                <th>Nick Name</th>
                                <th>User Name</th>
                                <th>Mobile Number</th>
                                <th>Email Id</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th class="action-btn-align">Action</th>
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
                                                <td><?= $val['name'] ?></td>
                                                <td><?= $val['nick_name'] ?></td>
                                                <td><?= $val['username'] ?></td>
                                                <td><?= $val['mobile_no'] ?></td>
                                                <td><?= $val['email_id'] ?></td>
                                                <td><?= $val['address'] ?></td>
                                                <td><?= $val['role'] ?></td>                    
                                                <td class="action-btn-align">
                                                    <a href="<?= $this->config->item('base_url') . 'users/edit_user/' . $val['id'] ?>" class="tooltips btn btn-info btn-xs" title="Edit">
                                                        <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active">
                                                        <span class="fa fa-ban "></span></a>
                                                </td>
                                            </tr>   
                                        <?php }
                                    } ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <br />
        <script type="text/javascript">

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
            $(".imgInp").live('change', function () {
                readURL(this);
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
            $("#user_name").live('blur', function ()
            {
                var store = $("#user_name").val();
                if (store == "" || store == null || store.trim().length == 0)
                {
                    $("#cuserror8").html("Required Field");
                } else
                {
                    $("#cuserror8").html("");
                }
            });
            $("#nick_name").live('blur', function ()
            {
                var nick_name = $("#nick_name").val();
                if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
                {
                    $("#nick").html("Required Field");
                } else
                {
                    $("#nick").html("");
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
                } else if (!nfilter.test(number))
                {
                    $("#cuserror4").html("Enter Valid Mobile Number");
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
            $('#role').live('blur', function ()
            {
                var bank = $('#role').val();
                if (bank == "" || bank == null || bank.trim().length == 0)
                {
                    $('#cuserror6').html("Required Field");
                } else
                {
                    $('#cuserror6').html("");
                }
            });

            $("#pass").live('blur', function ()
            {
                var acnum = $("#pass").val();
                if (acnum == "")
                {
                    $("#cuserror11").html("Required Field");
                } else
                {
                    $("#cuserror11").html("");
                }
            });



        </script>
        <script type="text/javascript">
            $('#submit').live('click', function ()
            {
                var i = 0;
                var name = $("#name").val();
                var filter = /^[a-zA-Z.\s]{3,30}$/;
                if (name == "" || name == null || name.trim().length == 0)
                {
                    $("#cuserror1").html("Required Field");
                    i = 1;
                } else if (!filter.test(name))
                {
                    $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
                    i = 1;
                } else
                {
                    $("#cuserror1").html("");
                }


                var user_name = $("#user_name").val();
                if (user_name == "" || user_name == null || user_name.trim().length == 0)
                {
                    $("#cuserror8").html("Required Field");
                    i = 1;
                } else
                {
                    $("#cuserror8").html("");
                }

                var signature = $("#signature").val();
                if (signature == "" || signature == null || signature.trim().length == 0)
                {
                    $("#sign").html("Required Field");
                } else
                {
                    $("#sign").html("");
                }

                var nick_name = $("#nick_name").val();
                if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
                {
                    $("#nick").html("Required Field");
                    i = 1;
                } else
                {
                    $("#nick").html("");
                }

                var number = $("#number").val();
                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
                if (number == "")
                {
                    $("#cuserror4").html("Required Field");
                    i = 1;
                } else if (!nfilter.test(number))
                {
                    $("#cuserror4").html("Enter Valid Mobile Number");
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
                var bank = $('#role').val();
                if (bank == "" || bank == null || bank.trim().length == 0)
                {
                    $('#cuserror6').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cuserror6').html("");
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
                var acnum = $("#pass").val();
                if (acnum == "")
                {
                    $("#cuserror11").html("Required Field");
                    i = 1;
                } else
                {
                    $("#cuserror11").html("");
                }
                var mess = $('#duplica').html();
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
        </script>
        <script>
            $(".email_dup").live('blur', function ()
            {
                email = $("#mail").val();
                $.ajax(
                        {
                            url: BASE_URL + "users/add_duplicate_email",
                            type: 'get',
                            data: {value1: email},
                            success: function (result)
                            {
                                $("#duplica").html(result);
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
                                Do You Want In-Active This user?<strong><?= $val['name']; ?></strong>
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                            </div>
                            <div class="modal-footer action-btn-align">
                                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                                <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
                            </div>
                        </div>
                    </div>  
                </div>
    <?php }
} ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "users/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>