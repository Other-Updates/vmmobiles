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
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel mb-50">
        <div class="media mt--2">
            <h4>Category Details</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#category-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Category List</a></li>
                    <li role="presentation" class=""><a href="#category" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Category </a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="category">

                        <div class="frameset1">

                            <form name="defect" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>master_category/save_defect" method="post">

                                <div class="row">	
                                    <div class="col-md-12">
                                        <div class="frameset1">    

                                            <div class="form-group" >
                                                <div class="frameset_inner">
                                                    <table align="center">
                                                        <tr>
                                                            <td>Category Name</td>
                                                            <td width="10">&nbsp;</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="text" class="cat_dup form-control required form-align" name="categoryName" id="defect_type" placeholder=" Enter Category">
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
                                            </div>
                                        </div>      

                                    </div><br />
                                    <div class="box-footer"></div>
                                    <div class="frm-bot-btn  bot-btn-cen ">
                                        <div class="action-btn-align " style="text-align:center;">
                                            <input id="save_defect" value="Save" type="button" class="btn  btn-success">
                                            <input type="reset" value="Clear" class=" btn btn-danger1 " id="reset" />
                                            <a href="<?php echo $this->config->item('base_url') . 'master_category/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                                        </div>
                                    </div>
                            </form> 
                        </div>    
                    </div>
                </div>
                <script>
                    $('#asset_colors').val('defect-icon-gray.png');
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
                                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                                m++;
                            } else {
                                $(this).closest('td').find('.error_msg').text('');
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
                        var cat = $.trim($("#defect_type").val());

                        $.ajax(
                                {
                                    url: BASE_URL + "master_category/add_duplicate_category",
                                    type: 'get',
                                    async: false,
                                    data: {value1: cat},
                                    success: function (result)
                                    {
                                        // $(this).closest('div.form-group').find('.error_msg').text(result).slideDown("500").css('display','inline-block');
                                        $("#duplica").html(result);
                                    }
                                });
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


                </script>



                <div role="tabpanel" class="tab-pane active tablelist" id="category-details">
                    <div class="frameset1">
                        <!--<h4 align="center" class="sup-align">Category Details</h4>-->
                        <div class="tabpad">
                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                <thead>
                                    <tr><th>S.No</th>
                                        <th>Category Name</th>
                                        <th class="action-btn-align">Action</th>
                                    </tr></thead>
                                <tbody>
<?php
if (isset($detail) && !empty($detail)) {
    $i = 1;
    foreach ($detail as $billto) {
        ?>   
                                            <tr><td class="first_td"><?php echo "$i"; ?></td>
                                                <td><?php echo $billto["categoryName"]; ?></td>       
                                                <td class="action-btn-align"><a id="<?php $billto['cat_id']; ?>" href="<?= $this->config->item('base_url') . 'master_category/update_cat/' . $billto['cat_id'] ?>" class="tooltips btn btn-info btn-xs" title="Edit">
                                                        <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $billto['cat_id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active">
                                                        <span class="fa fa-ban"></span></a>
                                                </td>
                                            </tr>
        <?php
        $i++;
    }
} else {
    ?>
                                        <tr>
                                            <td colspan="7">No Data Found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>    
                        </div>
                                    <?php
                                    if (isset($detail) && !empty($detail)) {
                                        foreach ($detail as $billto) {//print_r($billto);exit;
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
    <?php }
} ?>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>


<br />
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

    $('#submit').live('click', function ()
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
    });
</script>
<script>
    $(".cat_dup").live('blur', function ()
    {
        var cat = $.trim($("#defect_type").val());

        $.ajax(
                {
                    url: BASE_URL + "master_category/add_duplicate_category",
                    type: 'get',
                    data: {value1: cat},
                    success: function (result)
                    {
                        // $(this).closest('div.form-group').find('.error_msg').text(result).slideDown("500").css('display','inline-block');
                        $("#duplica").html(result);
                    }
                });
    });
</script>

</div>


<script type="text/javascript">
    $(document).ready(function ()
    {

        $("#yesin").live("click", function ()
        {
            for_loading('Loading Data Please Wait...');

            var hidin = $(this).parent().parent().find('.hidin').val();
            $.ajax({
                url: '<?php echo $this->config->item('base_url') ?>' + "master_category/delete_master_category",
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

    });
</script>


<!-- Update script  -->

<script type="text/javascript">
    $("#edit").live("click", function ()
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
                url: BASE_URL + "master_category/update_category",
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
    $("#no").live("click", function ()
    {


        var h_category = $(this).parent().parent().parent().find('.h_category').val();

        $(this).parent().parent().find('.up_category').val(h_category);
        var m = $(this).offsetParent().find('.upcategoryerror');
        var message = $(this).offsetParent().find('.upduplica');
        m.html("");
        message.html("");
    });

</script>

<script>
    $(".up_cat_dup").live('keyup', function ()
    {
        var cat = $(this).parent().parent().find('.up_men').val();
        var id = $(this).offsetParent().find('.id_dup').val();
        var message = $(this).offsetParent().find('.upduplica');


        $.ajax(
                {
                    url: BASE_URL + "master_category/update_duplicate_category",
                    type: 'POST',
                    data: {value1: cat, value2: id},
                    success: function (result)
                    {
                        message.html(result);
                    }
                });
    });
</script> 

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#cancel').live('click', function ()
        {
            $('.reset').html("");
            $('.dup').html("");
        });
    });
</script>