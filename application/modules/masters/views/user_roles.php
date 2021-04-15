<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!-- <script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script> -->
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style type="text/css">
    .td-pad { padding:6px; }
</style>
<div class="mainpanel">
    <div class="media"></div>
    <div class="contentpanel  mb-50">
        <div class="media mt--2">
            <h4>User Role Details</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">
                    <li role="presentation" class="active"><a href="#userrole-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">User Role List</a></li>
                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'user_roles', 'add')): ?>#userrole<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'add')): ?>alerts<?php endif ?>">Add User Role</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabbor">
                    <div role="tabpanel" class="tab-pane" id="userrole">
                        <div class="frameset1">
                            <form name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>masters/user_roles/add/">
                                <div class="">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="form-group margin0">
                                                <label class="col-sm-4 control-label">User Role<span style="color:#F00; font-style:oblique;">*</span></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input type="text" name="user_role[user_role]" id="user_role" class="borderra0 form-align" placeholder="Enter User Role" id="fit" maxlength="30" />
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <span id="user_role_error" class="reset" style="color:#F00;"></span>
                                                    <span id="duplica_user" class="val"  style="color:#F00;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frameset_table action-btn-align">
                                    <input type="submit" value="Save" class="submit btn btn-success " id="submit" />
                                    <input type="reset" value="Clear" class="btn  btn-danger1" id="cancel" />
                                    <a href="<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="userrole-details">
                        <div class="frameset1">
                            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
                                <thead>
                                    <tr>
                                        <th class='action-btn-align'>S.No</th>
                                        <th class='action-btn-align'>User Role</th>
                                        <th class="action-btn-align">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($user_roles) && !empty($user_roles)) {
                                        $i = 1;
                                        foreach ($user_roles as $list) {
                                            if ($list['id'] != 0) {
                                                ?>
                                                <tr><td class="first_td"><?php echo $i; ?></td>
                                                    <td><?php echo ucfirst($list['user_role']); ?></td>
                                                    <td class="action-btn-align">
                                                        <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?><?php echo base_url() . 'masters/user_roles/user_permissions/' . $list['id']; ?><?php endif ?>" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'user_roles', 'edit')): ?>alerts<?php endif ?>" title="User Permissions"><span class="fa fa-gear"></span></a>&nbsp;
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3">No User Roles found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div id="view"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('#user_role').on('blur', function () {
        var user_role = $('#user_role').val();
        if (user_role == '' || user_role == null || user_role.trim().length == 0) {
            $('#user_role_error').html('Required Field');
        } else {
            $('#user_role_error').html('');
        }
    });

    $('#submit').on('click', function () {
        var i = 0;
        var user_role = $('#user_role').val();
        if (user_role == '' || user_role == null || user_role.trim().length == 0) {
            $('#user_role_error').html('Required Field');
            i = 1;
        } else {
            $('#user_role_error').html('');
        }

        var user = $('#duplica_user').html();
        if ((user.trim()).length > 0)
        {
            i = 1;
        }
        if (i == 1) {
            return false;
        } else {
            return true;
        }
    });
    $("#user_role").on('blur', function ()
    {
        email = $("#user_role").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/user_roles/add_duplicate_user",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#duplica_user").html(result);
                    }
                });
    });
</script>
<br />
<?php
if (isset($user_roles) && !empty($user_roles)) {
    $i = 0;
    foreach ($user_roles as $role) {
        ?>
        <div id="test1_<?php echo $role['id']; ?>" class="modal fade in" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" style="color:white;margin-top:10px;">Update User Role</h3>
                    </div>
                    <div class="modal-body">
                        <table width="60%">
                            <tr>
                                <td><input type="hidden" name="id" class="id form-control id_dup" id="id" value="<?php echo $role['id']; ?>" readonly /></td>
                            </tr>
                            <tr>
                                <td><strong>User Role</strong></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input type="text" class="up_fit form-control up_fit_dup borderra0" id="up_fit" name="up_fit" value="<?php echo $role['user_role']; ?>" maxlength="30" /><span id="upfiterror" class="upfiterror" style="color:#F00; font-style:italic;"></span>
                                    <span id="upduplica" class="upduplica" style="color:#F00; font-style:italic;"></span>
                                    <input type="hidden" class="h_fit" id="h_fit" value="<?php echo $role['user_role']; ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button type="button" class="btn btn-info" id="edit"> Update</button>
                        <button type="reset" class="btn btn-danger" id="no" data-dismiss="modal"> Discard</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<!--delete all-->
<?php
if (isset($user_roles) && !empty($user_roles)) {
    foreach ($user_roles as $role) {
        ?>
        <div id="test3_<?php echo $role['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog"><div class="modal-content modalcontent-top"><div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a><h4 class="inactivepop">In-Active Fit</h4><h3 id="myModalLabel">
                    </div><div class="modal-body">
                        Do you want In-Active? &nbsp; <strong><?php echo $role['user_role']; ?></strong>
                        <input type="hidden" value="<?php echo $role['id']; ?>" id="hidin" class="hidin" />
                    </div><div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.delete_yes').on('click', function () {
            for_loading('Loading Data Please Wait...');
            var hidin = $(this).parent().parent().find('.hidin').val();
            $.ajax({
                url: BASE_URL + 'masters/user_roles/delete',
                type: 'get',
                data: {value1: hidin},
                success: function (result) {
                    window.location.reload(BASE_URL + 'masters/user_roles');
                    for_response('Deleted Successfully...');
                }
            });
        });
        $('.modal').css('display', 'none');
        $('.fade').css('display', 'none');
    });

    $('.up_fit').on('blur', function () {
        var up_fit = $(this).parent().parent().find('.up_fit').val();
        var m = $(this).offsetParent().find('.upfiterror');
        if (up_fit == '' || up_fit == null || up_fit.trim().length == 0) {
            m.html('Required Field');
        } else {
            m.html('');
        }
    });

    $('#cancel').on('click', function () {
        $('.reset').html('');
        $('.dup').html('');
    });

    $('#edit').on('click', function () {
        var i = 0;
        var id = $(this).parent().parent().find('.id').val();
        var up_fit = $(this).parent().parent().find('.up_fit').val();
        var m = $(this).offsetParent().find('.upfiterror');
        var mess = $(this).parent().parent().find('.upduplica').html();
        if (up_fit == '' || up_fit == null || up_fit.trim().length == 0) {
            m.html('Required Field');
            i = 1;
        } else {
            m.html('');
        }
        if ((mess.trim()).length > 0) {
            i = 1;
        }
        if (i == 1) {
            return false;
        } else {
            for_loading('Loading Data Please Wait...');
            $.ajax({
                url: BASE_URL + 'masters/user_roles/update_user_role',
                type: 'POST',
                data: {value1: id, value2: up_fit, value3: up_per},
                success: function (result) {
                    window.location.reload(BASE_URL + 'masters/user_roles');
                    for_response('Updated Successfully...');
                }
            });
        }
        $('.modal').css('display', 'none');
        $('.fade').css('display', 'none');
    });

    $('#no').on('click', function () {
        var h_fit = $(this).parent().parent().parent().find('.h_fit').val();
        $(this).parent().parent().find('.up_fit').val(h_fit);
        var m = $(this).offsetParent().find('.upfiterror');
        var message = $(this).offsetParent().find('.upduplica');
        m.html('');
        message.html('');

    });
</script>