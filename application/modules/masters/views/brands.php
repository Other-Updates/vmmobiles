<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!--<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script> -->
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css"/>

<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jquery.dataTables.min.js"></script>
<script>

    jQuery(document).ready(function () {
        var table;
        table = jQuery('#brandTable').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "pageLength": 50,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('masters/brands/brand_ajaxList/'); ?>",
                "type": "POST",
            },
            "columnDefs": [{
                    "targets": 0,
                    "searchable": false
                },
                {className: 'text-center', targets: [0, 1, 2, 3, 4]},
            ],
        });
    });
</script>
<style>
.text-center {
    text-align: left;
}
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel mb-50">
        <div class="media mt--2">
            <h4>Model Details</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#brand-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Model List</a></li>
                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'brands', 'add')): ?>#brand<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'brands', 'add')): ?>alerts<?php endif ?>">Add Model</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="brand">
                        <div class="frameset1">
                            <form action="<?php echo $this->config->item('base_url'); ?>masters/brands/insert_brand"  id="brandform1" name="form" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Shop Name<span style="color:#F00; font-style:oblique;">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select name="firm_id"  class="form-control form-align required" id="firm" onchange="Firm(this.value)">
                                                        <option value="">Select Shop</option>
                                                        <?php
                                                        if (isset($firms) && !empty($firms)) {
                                                            foreach ($firms as $firm) {

                                                                if ($key == 0) {
                                                                    $select = "selected=selected";
                                                                } else {
                                                                    $select = '';
                                                                }
                                                                ?>
                                                                <option <?php echo $select; ?>   value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span id="firmerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Category Name<span style="color:#F00; font-style:oblique;">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select name="cat_id"  class="form-control form-align required cat_id" id="cat_id" >
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        if (isset($cat) && !empty($cat)) {
                                                            foreach ($cat as $cat) {
                                                                ?>
                                                                <option value="<?php echo $cat['id']; ?>"> <?php echo $cat['categoryName']; ?> </option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <span id="caterr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Model Name<span style="color:#F00; font-style:oblique;">*</span></label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" name="brands" class="brand brandnamedup borderra0 form-align" placeholder=" Enter Model" id="brandname" maxlength="40" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fa"></i>
                                                    </div>
                                                </div>
                                                <span id="cnameerror" class="reset" style="color:#F00; font-style:italic;"></span>
                                                <span id="dup" class="dup" style="color:#F00; font-style:italic;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frameset_table action-btn-align">
                                    <input type="submit" value="Save" class="submit btn btn-success" id="submit" />
                                    <input type="reset" value="Clear" class=" btn btn-danger1" id="cancel" />
                                    <a href="<?php echo $this->config->item('base_url') . 'masters/brands' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="brand-details">
                        <div class="frameset1">
                            <div id="list">
                                <div class="">
                                    <table id="brandTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
                                        <thead>
										<tr>
                                        <th style="text-align:center;">S.No</th>
                                        <th style="text-align:center;">Shop Name</th>
                                        <th style="text-align:center;">Category Name</th>
                                        <th style="text-align:center;">Model Name</th>
                                        <th class="action-btn-align" style="text-align:center;">Actions</th>
										</tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body action-btn-align">

            <button type="button" class="btn btn-primary add_bluk_import"><i class="icon-plus-circle2 position-left"></i> Import Models</button>

        </div>


        <div id="myModal" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header bg-info">

                        <h6 class="modal-title">Import Models</h6>

                    </div>

                    <form action="<?php echo $this->config->item('base_url'); ?>masters/brands/import_brands" enctype="multipart/form-data" name="import_brands" method="post" id="import_form">

                        <div class="modal-body">

                            <div class="form-group">

                                <div class="col-lg-12">

                                    <div class="col-md-2"></div>

                                    <div class="col-md-8">

                                        <div class="form-group">

                                            <label><strong>Attachment:</strong></label>

                                            <input type="file" name="brand_data" id="model_data" class="form-control model_data_csv" onchange="return fileValidation()">


                                            <span class="error_msg"></span>

                                            <a href="<?php echo $this->config->item('base_url') . 'attachement/csv/sample_model.csv'; ?>" download><i class="fa fa-download"></i>&nbsp; Sample File</a>

                                            <span style="color:red;    margin-left: 80px;" class=" csv_error"></span>

                                        </div>

                                    </div>



                                    <div class="col-md-2"></div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="submit" name="submit" id="import" class="btn btn-success">Submit</button>

                            <button type="button" name="cancel" id="cancel" class="btn btn-warning" data-dismiss="modal">Cancel</button>

                        </div>



                    </form>

                </div>

            </div>

        </div>


        <script type="text/javascript">




            $(document).on('click', '.alerts', function () {
                sweetAlert("Oops...", "This Access is blocked!", "error");
                return false;
            });
            $('#brandname').on('blur', function ()
            {
                var cname = $('#brandname').val();
                if (cname == '' || cname == null || cname.trim().length == 0)
                {
                    $('#cnameerror').html("Required Field");
                } else
                {
                    $('#cnameerror').html(" ");
                }
            });

            $('.add_bluk_import').click(function () {



                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false

                });

                $('#myModal').modal('show');

            });
               $("#import_form").submit(function (event) {

               var data = $('.model_data_csv').val();
               if (data == "") {
                    $('.csv_error').text('Please Upload File');
                    return false;
               } else {
                    var valid_csv = $('.csv_error').text();
                    if (valid_csv == "Invalid File Format") {
                     $('.csv_error').text('Invalid File Format');   
                      return false;
                    } else {
                        $('.csv_error').text(' ');
                       
                        return true;
                    }

                   
                  
               }

               

            });


              function fileValidation() {
                    var fileInput = document.getElementById('model_data');
                    var filePath = fileInput.value;
                    var allowedExtensions = /(\.csv)$/i;
                    if (!allowedExtensions.exec(filePath)) {
                        $('.csv_error').text('Invalid File Format');

                        return false;
                    } else {
                       $('.csv_error').text(' ');
                       
                    }
                }

            $('#submit').on('click', function ()
            {
                cname = $.trim($("#brandname").val());
                var firm_id = $.trim($("#firm").val());
                if ($.trim(cname) != '')
                {
                    $.ajax(
                            {
                                url: BASE_URL + "masters/brands/add_duplicate_brandname",
                                type: 'POST',
                                async: false,
                                data: {cname: cname, firm_id: firm_id},
                                success: function (result)
                                {
                                    $("#dup").html(result);
                                }
                            });
                }
                var i = 0;

                $('select.required').each(function () {
                    this_val = $.trim($(this).val());
                    this_id = $(this).attr('id');

                    if (this_val == '') {
                        $('#firmerr').text('Required Field');
                        i = 1;
                    } else {
                        $('#firmerr').text('');

                    }
                });

                var firm = $('#firm').val();
                if (firm == '' || cname == null || cname.trim().length == 0)
                {
                    $('#firmerr').html("Required Field");
                    i = 1;
                } else
                {
                    $('#firmerr').html("");
                }

                var cat_id = $('#cat_id').val();

                if (cat_id == '' || cat_id == null || cat_id.trim().length == 0)
                {
                    $('#caterr').html("Required Field");
                    i = 1;
                } else
                {
                    $('#caterr').html("");
                }

                var cname = $('#brandname').val();
                if (cname == '' || cname == null || cname.trim().length == 0)
                {
                    $('#cnameerror').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cnameerror').html("");
                }
                var m = $('#dup').html();
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
        <script type="text/javascript">


            function Firm(val) {
                // alert(val);

                if (val != '') {
                    $.ajax({
                        type: 'POST',
                        data: {firm_id: val},
                        url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',
                        success: function (data) {

                            result = JSON.parse(data);

                            if (result != null && result.length > 0) {

                                option_text = '<option value="">Select Category</option>';

                                $.each(result, function (key, value) {

                                    option_text += '<option value="' + value.cat_id + '">' + value.categoryName + '</option>';

                                });
                                $('.cat_id').empty();

                                $('.cat_id').html(option_text);


                            } else {

                                $('.cat_id').html('');



                            }

                        }

                    });
                }
            }


            Firm(<?php echo $firms[0]['firm_id']; ?>);


            // STYLE NAME DUPLICATION
//            $(".brandnamedup").live('blur', function ()
//            {
//                cname = $.trim($("#brandname").val());
//                var firm_id = $.trim($("#firm").val());
//                if ($.trim(cname) != '')
//
//                {
//
//                    $.ajax(
//                            {
//                                url: BASE_URL + "masters/brands/add_duplicate_brandname",
//                                type: 'POST',
//                                async: false,
//                                data: {cname: cname, firm_id: firm_id},
//                                success: function (result)
//                                {
//                                    $("#dup").html(result);
//                                }
//                            });
//                }
//            });

        </script>
        <br />

        <div id="update_brand" class="modal fade in" tabindex="-1"
                role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"><a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" style="color:white;margin-top:10px">Update Model</h3>
                    </div>
                    <div class="modal-body">
                            <table class="table" width="60%">
                                <tr>
                                    <td><input type="hidden" name="id" class="id form-control id_update" id="modal_id" value="" readonly="readonly" /></td>
                                </tr>
                                <tr>
                                    <td width="12%"><b>Shop</b></td>
                                    <td width="18%">
                                        <div class="">
                                            <select name="firm_id"  class="form-control form-align required firm>" id="modal_firm" onchange="Firm(this.value)">
                                                <option value="">Select Shop</option>
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
                                        <span id="firmerr" class="val firmerr"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="12%"><b>Category</b></td>
                                    <td width="18%">
                                        <div class="">
                                            <select name="Category_Id"  class="form-control form-align  cat_id" id="modal_category" >
                                                <option value="">Select Category</option>
                                                <?php
                                                if (isset($category) && !empty($category)) {
                                                    foreach ($category as $cat_data) {
                                                        ?>
                                                        <option value="<?php echo $cat_data['cat_id']; ?>" > <?php echo $cat_data['categoryName']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <span id="caterr" class="val caterr"  style="color:#F00; font-style:oblique;"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Model Name</strong></td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="brand form-control colornameup colornamecup brandnameup borderra0 form-align" name="brands"
                                                    value="" id="modal_model" maxlength="40" /><input type="hidden" id="root1_h" class="root1_h"  value=""  />
                                            <div class="input-group-addon">
                                                <i class="fa fa-fa"></i>
                                            </div>
                                        </div>
                                        <span id="cnameerrorup" class="cnameerrorup" style="color:#F00; font-style:italic;"></span>
                                        <span id="dupup" class="dupup" style="color:#F00; font-style:italic;"></span>
                                    </td>
                                </tr>
                            </table>
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button type="button" class="edit btn btn-info1"  onclick="edit_update();" id="edit_brand">Update</button>
                        <button type="reset" class="btn btn-danger1 "  id="no" data-dismiss="modal"> Discard</button>
                    </div>
                </div>
            </div>
        </div>
       <?php
        if (isset($brand) && !empty($brand)) {
            foreach ($brand as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>

                                <h3 id="myModalLabel" class="inactivepop">In-Active Brand</h3>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active? &nbsp; <strong><?php echo $val["brand"]; ?></strong>
                                <input type="hidden" value="<?php echo $val['id']; ?>" class="hidin" />
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

            var hidin = $(this).parent().parent().find('.hidin').val();

            $.ajax({
                url: BASE_URL + "masters/brands/delete_master_brand",
                type: 'get',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "master_brand/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

        $('.brandnamecup').on('change', function ()
        {
            var cname = $(this).parent().parent().find(".$brandnamecup").val();
            //var sname=$('.style_nameup').val();
            var m = $(this).offsetParent().find('.cnameerrorup');
            if (cname == '' || cname == null || cname.trim().length == 0)
            {
                m.html("Required Field");
            } else
            {
                m.html("");
            }
        });

        $('#no').on('click', function ()
        {
            var root_h = $(this).parent().parent().parent().find('.root1_h').val();
            $(this).parent().parent().find('.brandnameup').val(root_h);
            var m = $(this).offsetParent().find('.cnameerrorup');
            var message = $(this).offsetParent().find('.dupup');
            //var message=$(this).parent().parent().find('.dupup').html();
            m.html("");
            message.html("");
        });

        $(".brandnameup").on('blur', function ()
        {
            //alert("hi");
            var cname = $.trim($(this).parent().parent().find('.brandnameup').val());
            var id = $(this).offsetParent().find('.id_update').val();
            var message = $(this).offsetParent().find('.dupup');
            $.ajax(
                    {
                        url: BASE_URL + "masters/brands/update_duplicate_brandname",
                        type: 'get',
                        data: {value1: cname, value2: id},
                        success: function (result)
                        {
                            message.html(result);
                        }
                    });
        });

        $(document).on('click','#edit',function(){
            var modelid = $(this).attr('model_id');
            var model_firm = $(this).attr('firm_id');
            var model_cat = $(this).attr('cat_id');
            var model_name = $(this).attr('model_name');
            $("#modal_firm,#modal_category,#modal_model,#modal_id,#root1_h").val('');
            $("#firmerr,#caterr,#cnameerrorup,#dupup").text('');
            $("#modal_firm").val(model_firm);
            $("#modal_category").val(model_cat);
            $("#modal_model,#root1_h").val(model_name);
            $("#modal_id").val(modelid);
            $('#update_brand').modal('show');
        });
    });
    function edit_update()
        {
            var cname = $('#modal_model').val();
            var cat_id = $('#modal_category').val();
            var firm = $('#modal_firm').val();
            //var message = $('.dupup').val();
            var message = $(this).offsetParent().find('.dupup');
            var id = $('.id_update').val();

            $.ajax({
                url: BASE_URL + "masters/brands/update_duplicatebrandname",
                type: 'POST',
                async: false,
                data: {value1: cname, value2: id, value3: cat_id, value4: firm},
                success: function (result)
                {

                    if (result != 0)
                        message.html(result);
                    else {
                        message.html('');
                    }
                }
            });
            var i = 0;

            if (firm == '') {
                $('.firmerr').text('Required Field');
                i = 1;
            } else {
                $('.firmerr').text(' ');
            }

            if (cat_id == '') {
                $('.caterr').text('Required Field');
                i = 1;
            } else {
                $('.caterr').text(' ');
            }

            var brand = cname;
            var m = $('.cnameerrorup');
            if (brand == '' || brand == null || brand.trim().length == 0)
            {
                m.html("Required Field");
                i = 1;
            } else
            {
                m.html("");
            }


            //  var m = $(this).offsetParent().find('.cnameerrorup');

            //var message=$(this).offsetParent().find('.dupup');
              var message = $(this).offsetParent().find('.dupup').html();
            if ((message.trim()).length > 0)
            {
                i = 1;
            }

            if (i == 1)
            {
                return false;
            } else
            {
                $.ajax({
                    url: BASE_URL + "masters/brands/update_brand",
                    type: 'POST',
                    data: {value1: id, value2: brand, firm: firm, cat_id: cat_id},
                    success: function (result)
                    {
                        window.location.reload(BASE_URL + "index/");
                    }
                });
            }
            $('.modal').css("display", "none");
            $('.fade').css("display", "none");
        }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cancel').on('click', function ()
        {
            $('.reset').html("");
            $('.dup').html("");
        });
    });
</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>