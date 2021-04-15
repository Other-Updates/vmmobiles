<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!-- <script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

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

        padding: 5px;

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

    .fa-remove:before, .fa-close:before, .fa-times:before {

        content: "\f00d";

    }

    .add-defect td {

        padding: 8px;

    }

    .table-striped tbody tr:nth-child(odd) td, .table-striped tbody tr:nth-child(odd) th {

        background-color: #f7f7f7;

    }

    .ui-state-default.ui-jqgrid-toppager, .ui-state-default.ui-jqgrid-hdiv, .ui-state-default.ui-jqgrid-hdiv, table.ui-jqgrid-htable, table, .ui-state-default.ui-jqgrid-hdiv, .ui-jqgrid-bdiv {

        width: 100% !important;

    }

</style>
<!--
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<div class="mainpanel">

    <div class="media">

    </div>

    <div class="contentpanel mb-50">

        <div class="media mt--2">

            <h4>Category Details</h4>

        </div>

        <div class="panel-body">

            <div class="tabs">

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#category-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Category List</a></li>

                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'categories', 'add')): ?>#category<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'categories', 'add')): ?>alerts<?php endif ?>">Add Category </a></li>

                </ul>

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="category">

                        <form name="defect" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>masters/categories/save_defect" method="post">

                            <div class="row">

                                <div class="col-md-6">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Firm Name</label>

                                        <div class="col-sm-8">

                                            <div class="">

                                                <select name="firm_id"  class="required form-align form-control" id="firm" >

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

                                            </div>

                                            <span class="error_msg"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-6">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Category Name<span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" class="cat_dup required form-align" name="categoryName" id="defect_type" placeholder=" Enter Category" maxlength="40">

                                                <div class="input-group-addon">

                                                    <i class="fa fa-sitemap"></i>

                                                </div>



                                            </div>

                                            <span class="error_msg"></span>

                                            <span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                            </div><br />

                            <div class="frm-bot-btn action-btn-align">

                                <input id="save_defect" value="Save" type="button" class="btn  btn-success">

                                <input type="reset" value="Clear" class=" btn btn-danger1 " id="reset" />

                                <a href="<?php echo $this->config->item('base_url') . 'masters/categories' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>



                    </div>



                    <div role="tabpanel" class="tab-pane active tablelist" id="category-details">

                        <div class="frameset_big1">

                            <div class="">

                                <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">

                                    <thead>

                                        <tr><th width='5%' class="action-btn-align">S.No</th>

                                            <th width='20%' class="action-btn-align">Firm Name</th>

                                            <th width='15%' class="action-btn-align">Category Name</th>

                                            <th width='10%' class="action-btn-align">Action</th>

                                        </tr></thead>

                                    <tbody>

                                        <?php

                                        if (isset($detail) && !empty($detail)) {

                                            $i = 1;

                                            foreach ($detail as $billto) {

                                                ?>

                                                <tr><td class="first_td"><?php echo "$i"; ?></td>

                                                    <td><?php echo $billto["firm_name"]; ?></td>

                                                    <td><?php echo ucfirst($billto["categoryName"]); ?></td>

                                                    <td class="action-btn-align">

                                                        <a id="<?php $billto['cat_id']; ?>" href="<?php if ($this->user_auth->is_action_allowed('masters', 'categories', 'edit')): ?><?= $this->config->item('base_url') . 'masters/categories/update_categories/' . $billto['cat_id'] ?><?php endif ?>" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'categories', 'edit')): ?>alerts<?php endif ?>" title="Edit">

                                                            <span class="fa fa-edit"></span></a>&nbsp;

                                                        <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'categories', 'delete')): ?>#test3_<?php echo $billto['cat_id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'categories', 'delete')): ?>alerts<?php endif ?>" title="In-Active">

                                                            <span class="fa fa-ban"></span></a>

                                                    </td>

                                                </tr>

                                                <?php

                                                $i++;

                                            }

                                        }

                                        ?>

                                    </tbody>

                                </table>

                            </div>

                            <?php

                            if (isset($detail) && !empty($detail)) {

                                foreach ($detail as $billto) {

                                    ?>

                                    <div id="test3_<?php echo $billto['cat_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

                                        <div class="modal-dialog"><div class="modal-content modalcontent-top"><div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>

                                                    <h4 class="inactivepop">In-Active Category</h4><h3 id="myModalLabel">

                                                </div><div class="modal-body">

                                                    Do you want In-Active? &nbsp; <strong><?php echo $billto['categoryName']; ?></strong>

                                                    <input type="hidden" value="<?php echo $billto['cat_id']; ?>" id="hidin" class="hidin" />

                                                </div><div class="modal-footer action-btn-align">

                                                    <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>

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

                </div>

            </div>

        </div>

    </div>

</div>

<br />

<script>

    $('#asset_colors').val('defect-icon-gray.png');

    $('.icon-defeaut').css('background', 'rgba(47, 166, 0, 0.39)');

    $('.select-icon').on('click', function () {

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

                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');

                m++;

            } else {

                $(this).closest('td').find('.error_msg').text('');

            }

            if (m > 0)

                return false;

            $.ajax({

                type: "POST",

                url: '<?php echo $this->config->item('base_url') ?>' + "masters/categories/save_action",

                data: {sub_categoryName: sub_categoryName},

                success: function (data) {

                    $("#action_table").append(data);

                    $('#action_name').val('').removeAttr('id');



                }

            });

        });

    });



    $("#save_defect").on('click', function (e) {



        e.preventDefault();

        var cat = $.trim($("#defect_type").val());

        var firm_id = $.trim($("#firm").val());



        if ($.trim(cat) != '') {

            $.ajax(

                    {

                        url: BASE_URL + "masters/categories/add_duplicate_category",

                        type: 'post',

                        async: false,

                        data: {cat: cat, firm_id: firm_id},

                        success: function (result)



                        {



                            $("#duplica").html(result);

                            return false;

                        }

                    });

        }

        m = 0;

        $('.required').each(function () {

            this_val = $.trim($(this).val());

            this_id = $(this).attr("id");

            if (this_val == "") {

                $(this).closest('div.form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');

                m++;

            } else {

                $(this).closest('div.form-group').find('.error_msg').text('');



            }

        });



        if ($('#duplica').html() == 'Category Name already Exist')

        {

            m++;

        }

        if (m > 0)

            return false;

        document.getElementById("add_defect").submit();

    });

    $(".delete_corrective_action").on('click', function () {

        var element = $(this);

        var del_id = element.attr("id");

        $.ajax({

            type: "POST",

            url: '<?php echo $this->config->item('base_url') ?>' + "masters/categories/delete_action_by_id",

            data: {del_id: del_id},

            success: function (data) {



                console.log(data);

                $('#' + del_id).closest('tr').fadeOut();

                $('#' + del_id).closest('tr').hide();

            }

        });

    });</script>

<script>

    $('.cat_dup').on('blur', function ()

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

    $('#submit').on('click', function ()

    {

        i = 0;

        var men = $('#men').val();

        if (men == '' || men == null || men.trim().length == 0)

        {

            $('#caterror').html("Required Field");

            i = 1;

        } else

        {

            $('#caterror').html(" ");

        }

        var m = $('#duplica').html();

        if ((m.trim()).length > 0)

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

    });</script>

<script>

    $(".cat_dup").on('blur', function ()

    {

        var cat = $.trim($("#defect_type").val());

        if ($.trim(cat) != '')

        {

            $.ajax(

                    {

                        url: BASE_URL + "masters/categories/add_duplicate_category",

                        type: 'get',

                        data: {value1: cat},

                        success: function (result)

                        {



                            $("#duplica").html(result);

                            return false;

                        }

                    });

        }

    });</script>



</div>





<script type="text/javascript">

    $(document).ready(function ()

    {



        $(".delete_yes").on("click", function ()

        {

            for_loading('Loading Data Please Wait...');

            var hidin = $(this).parent().parent().find('.hidin').val();

            $.ajax({

                url: '<?php echo $this->config->item('base_url') ?>' + "masters/categories/delete_master_category",

                type: 'get',

                data: {value1: hidin},

                success: function (result) {





                    window.location.reload(BASE_URL + "master_category/");

                    for_response('Deleted Successfully...');

                }

            });

        });

        $('.modal').css("display", "none");

        $('.fade').css("display", "none");

    });</script>





<script type="text/javascript">

    $("#edit").on("click", function ()

    {



        var i = 0;

        var id = $(this).parent().parent().find('.id').val();

        var up_men = $(this).parent().parent().find(".up_men").val();

        var up_women = $(this).parent().parent().find(".up_women").val();

        var up_kids = $(this).parent().parent().find(".up_kids").val();

        var m = $(this).offsetParent().find('.upcategoryerror');

        var mess = $(this).parent().parent().find('.upduplica').html();

        if (up_men == '' || up_men == null || up_men.trim().length == 0)

        {

            m.html("Required Field");

            i = 1;

        } else

        {

            m.html("");

        }

        if ((mess.trim()).length > 0)

        {

            i = 1;

        }



        if (i == 1)

        {

            return false;

        } else

        {

            for_loading('Loading Data Please Wait...');

            $.ajax({

                url: BASE_URL + "masters/categories/update_category",

                type: 'POST',

                data: {value1: id, value2: up_men, value3: up_women, value4: up_kids},

                success: function (result)

                {

                    window.location.reload(BASE_URL + "master_category");

                    for_response('Updated Successfully...');

                }

            });

        }



        $('.modal').css("display", "none");

        $('.fade').css("display", "none");

    });

    $("#no").on("click", function ()

    {





        var h_category = $(this).parent().parent().parent().find('.h_category').val();

        $(this).parent().parent().find('.up_category').val(h_category);

        var m = $(this).offsetParent().find('.upcategoryerror');

        var message = $(this).offsetParent().find('.upduplica');

        m.html("");

        message.html("");

    });</script>



<script>

    $(".up_cat_dup").on('keyup', function ()

    {

        var cat = $(this).parent().parent().find('.up_men').val();

        var id = $(this).offsetParent().find('.id_dup').val();

        var message = $(this).offsetParent().find('.upduplica');

        $.ajax(

                {

                    url: BASE_URL + "masters/categories/update_duplicate_category",

                    type: 'POST',

                    data: {value1: cat, value2: id},

                    success: function (result)

                    {

                        message.html(result);

                    }

                });

    });</script>



<script type="text/javascript">

    $(document).on('click', '.alerts', function () {

        sweetAlert("Oops...", "This Access is blocked!", "error");

        return false;

    });

    $(document).ready(function ()

    {

        $('#cancel').on('click', function ()

        {

            $('.reset').html("");

            $('.dup').html("");

        });

    });

</script>