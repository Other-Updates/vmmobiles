<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style>
    #loadingmessage
    {
        text-align: center;
        height: 400px;
        position: relative;
        background-color: #fff; /* for demonstration */
    }
    .add-defect .fa-edit {
        color: #fff;
        background: #2fa600;
        border-radius: 50%;
        padding: 6px 6px;
        font-size:12px;
    }
    .add-defect .fa-close {
        color: #fff;
        background: #fe5a5a;
        border-radius: 50%;
        padding: 5px 6px;
        font-size:12px;
    }
    .add-defect td {
        padding:8px;
    }
    .input-group .input-group-addon#addfile {
        background: #2fa600;
        color: #fff;
        border-color: #2fa600;
    }
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    input[type="text"]:disabled {background-color: #f1f1f1; border:0px}
    .table-striped tbody tr:nth-child(odd) td, .table-striped tbody tr:nth-child(odd) th {
        background-color: #f7f7f7;
    }
    .ui-state-default.ui-jqgrid-toppager, .ui-state-default.ui-jqgrid-hdiv, .ui-state-default.ui-jqgrid-hdiv, table.ui-jqgrid-htable, table, .ui-state-default.ui-jqgrid-hdiv, .ui-jqgrid-bdiv {
        width: 100% !important;
    }
    .error_msg, em{color: rgb(255, 0, 0); font-size: 12px;font-weight: normal;}
    input[type="text"]:disabled {background-color: #f1f1f1; border:0px}
    .fa-remove:before, .fa-close:before, .fa-times:before {
        content: "\f00d";
    }
     .input-group-addon .fa { width:10px !important; }

</style>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel">
        <div class="media">
            <h4>Update Category</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <!--        <li role="presentation" class="active"><a href="#update-cat-sub" aria-controls="profile" >Update Category</a></li>-->
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="update-cat-sub">
                        <div class="tabpad">
                            <div class="frameset1">
                                <!--  <h4 align="center" class="sup-align">Update Category</h4>-->
                                <form name="defect" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>master_category/update_category "method="post">    
                                    <div class="row">
                                        <input type="hidden" id="cats" name="cat_id" value="<?php echo $defect_type[0]['cat_id'] ?>" >
                                        <div class="col-md-12">
                                            <?php if (isset($defect_type[0]) && !empty($defect_type[0])) { ?>
                                                <div class="form-group" >
                                                    <div class="frameset_inner">
                                                        <table align="center">
                                                            <tr>
                                                                <td>Category Name</td>
                                                                <td> 
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control required cat_dup form-align" org_name="<?php echo $defect_type[0]['categoryName'] ?>" name="categoryName" value="<?php echo $defect_type[0]['categoryName'] ?>" id="defect_type">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                        </div>
                                                                    </div>
                                                                    <span class="error_msg"></span>
                                                                    <span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span>
                                                                </td>
                                                            </tr>
                                                        </table>     
                                                    </div>
                                                <?php } ?>

                                                <!--	<div class="col-md-6">
                                                 
                                                    <label class="form-label ml">Sub Category Name</label>
                                                    <table class="add-defect table-striped" id="action_table">
                                                       
                                                <?php
                                                $action_array = array();
                                                if (isset($selected_action) && !empty($selected_action)) {
                                                    foreach ($selected_action as $act) {
                                                        $action_array[] = $act['actionId'];
                                                    }
                                                }
                                                $data['actionId'] = '';
                                                foreach ($corrective_action as $data) {
                                                    $ch = '';
                                                    if (in_array($data['actionId'], $action_array)) {
                                                        $ch = 'checked';
                                                    }
                                                    ?>
                                                            <tr>
                                                                <td><input type="checkbox" <?php echo $ch; ?> name="actionId[]" value="<?php echo $data['actionId']; ?>"/></td>
                                                                <td class="edit_name hide_edit"><input type="text" id="<?php echo $data['actionId']; ?>" value="<?php echo $data['sub_categoryName']; ?>" disabled /></td>
                                                                <td class="text-right"><a href="javascript:void(0);" class="edit_corrective_action" maze="<?php echo $data['sub_categoryName']; ?>" id="<?php echo $data['actionId']; ?>" ><i class="fa fa-edit"></i></a> &nbsp; 
                                                                    <a href="javascript:void(0);"  id="<?php echo $data['actionId']; ?>" class="delete_corrective_action" data-original-title="Delete"><i class="fa fa-close"></i></a></td>
                                                            </tr>
    <?php
}
?>
                                                        
                                                    </table>            -->

<!--    <table class="add-defect table-striped" id="table2">
<tr class="clone_tr">
    <td width="5%"></td>
    <td width="95%">
            <div class="input-group">
            <input type="text" id="action_name" placeholder="Enter Action Name" class="form-control action_nmae mtmb" name="sub_categoryName">
            <span class="input-group-addon" id="addfile"><i class="fa fa-plus" aria-hidden="true"></i></span>                      
          </div>
        <span class="error_msg"></span>
    </td>
</tr>
</table>-->


                                            </div>    
                                        </div>
                                        <div class="box-footer"></div>
                                        <div class="frm-bot-btn  bot-btn-cen">
                                            <div class="action-btn-align mb-bot20">
                                                <input id="save_defect" value="Update" type="button" class="btn btn-info1">
                                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" />
                                                <a href="<?php echo $this->config->item('base_url') . 'master_category/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                                            </div>
                                        </div>
                                </form> 
                            </div>
                        </div>
                    </div>



                </div>

                <script>
                    $('.cat_dup').live('blur', function ()
                    {
                        var men = $('.cat_dup').val();
                        if (men == '' || men == null || men.trim().length == 0)
                        {
                            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
                        } else
                        {
                            $(this).closest('div.form-group').find('.error_msg').text('').slideUp("500");
                        }
                    });

                    $('.icon-defeaut').css('background', 'rgba(47, 166, 0, 0.39)');
                    $('.select-icon').live('click', function () {
                        $('.select-icon').css('background', '');
                        $(this).css('background', 'rgba(47, 166, 0, 0.39)');
                        $('#asset_colors').val($(this).attr('icon_image'));
                    });
                    $(document).ready(function () {
                        $("#addfile").on('click', function (e) {
                            e.preventDefault();
                            var sub_categoryName = $('.action_nmae').val();
                            m = 0;
                            if (sub_categoryName == "") {
                                $(this).closest('td').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
                                m++;
                            } else {
                                $(this).closest('td').find('.error_msg').text('').slideUp("500");
                            }
                            if (m > 0)
                                return false;
                            $.ajax({
                                type: "POST",
                                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/save_action",
                                data: {sub_categoryName: sub_categoryName},
                                success: function (data) {
                                    $("#action_table").append(data);
                                    $('#action_name').val('').removeAttr('id');
                                    //$("#action_name").trigger("reset");
                                    // $("#table2").append('<tr class="clone_tr"><td width="5%"><input type="checkbox" name="" value="" checked="checked"/></td><td width="95%"><div class="input-group"><input type="text" placeholder="Enter Action Name" class="form-control" name="actionName"><span class="input-group-addon" id="addfile"><i class="fa fa-plus" aria-hidden="true"></i></span></div></td></tr>');
                                    //$("#dynamicfieldsdata").trigger("chosen:updated");
                                }
                            });
                        });
                    });

                    $("#save_defect").on('click', function (e) {
                        e.preventDefault();
                        m = 0;
                        $('.required').each(function () {
                            this_val = $.trim($(this).val());
                            this_id = $(this).attr("id");
                            if (this_val == "") {
                                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown("500").css('display', 'inline-block');
                                m++;
                            } else {
                                $(this).closest('div.form-group').find('.error_msg').text('').slideUp("500");
                            }
                        });
                        if ($('#duplica').html() == 'Category Name already Exist')
                        {
                            m++;
                        } else
                        {
                            $('#duplica').html('');
                        }
                        if (m > 0)
                            return false;
                        document.getElementById("add_defect").submit();
                        var cat = $.trim($("#defect_type").val());
                        var id = $("#cats").val();
                        $.ajax(
                                {
                                    url: BASE_URL + "master_category/update_duplicate_category",
                                    type: 'post',
                                    async: false,
                                    data: {value1: cat, value2: id},
                                    success: function (result)
                                    {
                                        if ($('#defect_type').attr('org_name') != cat)
                                            $("#duplica").html(result);
                                    }
                                });
                    });

                    $(".delete_corrective_action").live('click', function () {
                        var element = $(this);
                        var del_id = element.attr("id");
                        $.ajax({
                            type: "POST",
                            url: '<?php echo $this->config->item('base_url') ?>' + "master_category/delete_action_by_id",
                            data: {del_id: del_id},
                            success: function (data) {

                                console.log(data);
                                $('#' + del_id).closest('tr').fadeOut();
                                $('#' + del_id).closest('tr').hide();

                            }
                        });
                    });
                    $(".edit_corrective_action").live('click', function () {
                        $("#action_table").find("input[type=text]")
                                .removeClass('editme')
                                .prop("disabled", true);
                        $(event.target).closest('tr').find("input[type=text]")
                                .addClass('editme')
                                .prop("disabled", false);
                    });

                    $(document).on('blur', 'input[type=text]', function () {
                        var val = $(this).val();
                        var element = $(this);
                        var edit_id = element.attr("id");
                        if (val != '')
                        {
                            $.ajax({
                                type: "POST",
                                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/edit_action_by_id",
                                data: {actionId: edit_id, sub_categoryName: val},
                                success: function (data) {
                                    $("#action_table").find("input[type=text]")
                                            .removeClass('editme')
                                            .prop("disabled", true);
                                }
                            });
                        }
                    });
                </script>
                <script>
                    $(".cat_dup").live('blur', function ()
                    {
                        var cat = $.trim($("#defect_type").val());
                        var id = $("#cats").val();
                        $.ajax(
                                {
                                    url: BASE_URL + "master_category/update_duplicate_category",
                                    type: 'post',
                                    data: {value1: cat, value2: id},
                                    success: function (result)
                                    {
                                        if ($('#defect_type').attr('org_name') != cat)
                                            $("#duplica").html(result);
                                    }
                                });
                    });
                </script>

