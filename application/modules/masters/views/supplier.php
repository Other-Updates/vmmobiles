<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style>

    .input-group-addon .fa { width:10px !important; }
    .text-center {
        text-align: left;
    }

</style>

<style>

    .ui-datepicker td.ui-datepicker-today a {

        background:#999999;

    }

    #ui-datepicker-div {

        z-index: 4 !important;

    }

    .center-class

    {

        text-align:center;

    }
	table tr td:nth-child(5) {text-align:center;}

</style>

<div class="mainpanel">

    <div class="media">

    </div>

    <div class="contentpanel">

        <div class="media mt--2">

            <h4>Supplier Details</h4>

        </div>

        <div class="panel-body">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#supplier-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Supplier List</a></li>

                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'suppliers', 'add')): ?>#supplier<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'suppliers', 'add')): ?>alerts<?php endif ?>">Add Supplier</a></li>

                </ul>



                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane" id="supplier">

                        <form action="<?php echo $this->config->item('base_url'); ?>masters/suppliers/insert_vendor" enctype="multipart/form-data" name="form" method="post">

                            <div class="inner-sub-tit">Supplier Details</div>

                            <div class="row">

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Shop Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <select name="firm_id"  class="form-control form-align" id="firm" >

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

                                            <span id="firmerr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Supplier Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="store" class="store form-align" id="store" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="superror2" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Landline Number <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="landline" class="landline  form-align" id="landline" maxlength="11" tabindex="1"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-volume-control-phone"></i>

                                                </div>

                                            </div>

                                            <span id="landlinerr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            <span id="duplica1" class="val" style="color:#F00; font-style:oblique;"></span>

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

                                            <span id="superror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Contact Person</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="name" class="name  form-align" id="name" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="superror1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">City <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="city" class=" form-align" id="city" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-map-marker"></i>

                                                </div>

                                            </div>

                                            <span id="superror10" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>



                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">State</label>

                                        <div class="col-sm-8">

                                            <select id="state_id" name='state_id' class="state_id form-control form-align" >

                                                <option value="">Select</option>

                                                <?php
                                                if (isset($all_state) && !empty($all_state)) {

                                                    foreach ($all_state as $val) {

                                                        if ($val['id'] == 31) {

                                                            $selected = 'selected="selected"';
                                                        } else {

                                                            $selected = '';
                                                        }
                                                        ?>

                                                        <option <?php echo $selected; ?> value="<?php echo $val['id']; ?>"><?php echo $val['state']; ?></option>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select><span id="superror" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Email Address</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="mail" class="  form-align" id="mail" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-envelope"></i>

                                                </div>

                                            </div>

                                            <span id="superror5" class="val" style="color:#F00; font-style:oblique;"></span>

                                            <span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address Line1 <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <textarea name="address1" id="address1" class="form-control form-align"></textarea>

                                            <span id="superror3" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address Line2</label>

                                        <div class="col-sm-8">

                                            <textarea name="address2" id="address2" class="form-control form-align"></textarea>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Pin Code <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" class=" form-align" name="pin" id="pincode" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-map-marker"></i>

                                                </div>

                                            </div>

                                            <span id="superror7" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>



                                <div class="col-md-4">

                                    <!-- <div class="form-group">

                                         <label class="col-sm-4 control-label">Credit Days <span style="color:#F00; font-style:oblique;"></span></label>

                                         <div class="col-sm-8">



                                             <select id="credit_days" name='credit_days' class="credit_days form-control form-align" tabindex="1">

                                                 <option value="">Select</option>

                                    <?php
                                    for ($x = 1; $x <= 90; $x++) {
                                        ?>

                                                                                 <option  value="<?php echo $x; ?>"><?php echo $x; ?></option>

                                        <?php
                                    }
                                    ?>

                                             </select>

                                             <span id="credit_dayserr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                         </div>

                                     </div>

                                     <div class="form-group">

                                         <label class="col-sm-4 control-label">Payment Percentage</label>

                                         <div class="col-sm-8">

                                             <div class="input-group">

                                                 <input type="text" class=" form-align" name="payment" id="payment" />

                                                 <div class="input-group-addon">

                                                     <i class="fa fa-money"></i>

                                                 </div>

                                             </div>

                                             <span id="paymenterr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                         </div>

                                     </div>



                                     <div class="form-group">

                                         <label class="col-sm-4 control-label">DOB</label>

                                         <div class="col-sm-8">

                                             <div class="input-group">

                                                 <input type="text" name="dob"  class="datepicker form-align" id="dob"/>

                                                 <div class="input-group-addon">

                                                     <i class="fa fa-calendar"></i>

                                                 </div>

                                             </div>

                                             <span id="dob1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                         </div>

                                     </div>



                                     <div class="form-group">

                                         <label class="col-sm-4 control-label">Anniversary Date</label>

                                         <div class="col-sm-8">

                                             <div class="input-group">

                                                 <input type="text"  name="anniversary"  class="datepicker  form-align" id="anniversary" />

                                                 <div class="input-group-addon">

                                                     <i class="fa fa-calendar"></i>

                                                 </div>

                                             </div>

                                             <span id="anniversary1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                         </div>

                                     </div>-->



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">GSTIN <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="tin" class="number  form-align" id="tin" maxlength="15"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-cog"></i>

                                                </div>

                                            </div>

                                            <span id="superror12" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="clearfix"></div>

                            <div class="inner-sub-tit mstyle">Bank Details</div>

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Bank Name <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="bank" class=" form-align" id="bank" maxlength="25" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-bank"></i>

                                                </div>

                                            </div>

                                            <span id="superror6" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Account No <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="acnum" class=" form-align" id="acnum" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user-circle"></i>

                                                </div>

                                            </div>

                                            <span id="superror9" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>



                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">IFSC Code <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="ifsc" class=" form-align" id="ifsc" maxlength="15"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fax"></i>

                                                </div>

                                            </div>

                                            <span id="ifsc1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Bank Branch <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="branch" class=" form-align" id="branch" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-bank"></i>

                                                </div>

                                            </div>

                                            <span id="superror8" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>





                                </div>



                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Payment Terms <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="payment_terms" class="number  form-align" id="payment_terms" maxlength="25"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fw fa-money"></i>

                                                </div>

                                            </div>

                                            <span id="superror11" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                            </div>

                            <div class="frameset_table action-btn-align">

                                <table>

                                    <tr>

                                        <td width="570">&nbsp;</td>

                                        <td><input type="submit" value="Save" class="submit btn btn-success  savebtn" id="submit" /></td>

                                        <td>&nbsp;</td>

                                        <td><input type="reset" value="Clear" class=" btn btn-danger1 " id="reset" /></td><td>&nbsp;</td>

                                        <td><a href="<?php echo $this->config->item('base_url') . 'masters/suppliers/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>



                                    </tr>

                                </table>

                            </div>

                        </form>

                    </div>

                    <div role="tabpanel" class="tab-pane active tablelist" id="supplier-details">

                        <div class="frameset_big1">

                            <table id="example" class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer aln-cntr" cellspacing="0" width="100%">

                                <thead>

                                    <tr>

                                        <th  class='action-btn-align' >S.No</th>

                                        <th style="text-align:center;" >Shop Name</th>

                                        <th style="text-align:center;">Supplier Name</th>

                                        <th style="text-align:center;">Email Address</th>

                                        <th style="text-align:center;">Mobile Number</th>


                                        <th style="text-align:center;">City</th>

                                        <th style="text-align:center;">GSTIN</th>

                                        <th  class="action-btn-align"><div class="">Action</div></th>

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

        <div class="panel-body action-btn-align">

            <button type="button" class="btn btn-primary add_bluk_import"><i class="icon-plus-circle2 position-left"></i> Import Suppliers</button>

        </div>

        <div id="myModal" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header bg-info">

                        <h6 class="modal-title">Import Suppliers</h6>

                    </div>

                    <form action="<?php echo $this->config->item('base_url'); ?>masters/suppliers/import_suppliers" enctype="multipart/form-data" name="importsuppliers" method="post" id="import_form">

                        <div class="modal-body">

                            <div class="form-group">

                                <div class="col-lg-12">

                                    <div class="col-md-2"></div>

                                    <div class="col-md-8">

                                        <div class="form-group">

                                            <label><strong>Attachment:</strong></label>

                                            <input type="file" name="supplier_data" id="supplier_data" class="form-control supplier_data_csv" onchange="return fileValidation()">

                                            <span class="error_msg"></span>

                                            <a href="<?php echo $this->config->item('base_url') . 'attachement/csv/sample_supplier.csv'; ?>" download><i class="fa fa-download"></i>&nbsp; Sample File</a>


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

        <?php
        if (isset($vendor) && !empty($vendor)) {

            $i = 0;

            foreach ($vendor as $val) {

                $i++
                ?>



                <div id="test<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

                    <div class="modal-dialog">

                        <div class="modal-content modalcontent-top">

                            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor border0" data-dismiss="modal">×</a>

                                <h3 id="myModalLabel" class="inactivepop">In-Active Supplier</h3>

                            </div>

                            <div class="modal-body">

                                Do You Want In-Active This Supplier? <?php echo $val['name']; ?> <strong>(<?php echo $val['store_name']; ?>)</strong>

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



        <script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.12.4.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/dataTables.buttons.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.flash.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jszip.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/pdfmake.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/vfs_fonts.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.html5.min.js"></script>

        <script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.print.min.js"></script>

        <script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>

        <script src="<?= $theme_path; ?>/js/jquery-ui.js"></script>

        <script type="text/javascript">



                                                var table;



                                                jQuery(document).ready(function () {





                                                    //datatables

                                                    table = jQuery('#example').DataTable({
                                                        "processing": true, //Feature control the processing indicator.

                                                        "serverSide": true, //Feature control DataTables' server-side processing mode.

                                                        "order": [], //Initial no order.

                                                        //dom: 'Bfrtip',

                                                        // Load data for the table's content from an Ajax source

                                                        "ajax": {
                                                            "url": "<?php echo site_url('masters/suppliers/ajaxList/'); ?>",
                                                            "type": "POST",
                                                        },
                                                        //Set column definition initialisation properties.

                                                        "columnDefs": [
                                                            {
                                                                "targets": [0, 7], //first column / numbering column

                                                                "orderable": false, //set not orderable

                                                            },
                                                            {className: 'text-center', targets: [1, 2, 3, 4, 5, 6]},
                                                        ],
                                                    });



                                                });



                                                function check(val)

                                                {

                                                    $('#test' + val).modal('show');

                                                }





        </script>

        <script type="text/javascript">

            $(document).on('click', '.alerts', function () {

                sweetAlert("Oops...", "This Access is blocked!", "error");

                return false;

            });

            $(document).ready(function ()

            {

                $('#state_id').select2();

                $('.datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                });

            });

            $('#firm').on('blur', function ()

            {

                var firm = $('#firm').val();

                if (firm == "")

                {

                    $('#firmerr').text("Select State");

                } else

                {

                    $('#firmerr').text("");

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

                var data = $('.supplier_data_csv').val();
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
                var fileInput = document.getElementById('supplier_data');
                var filePath = fileInput.value;
                var allowedExtensions = /(\.csv)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    $('.csv_error').text('Invalid File Format');

                    return false;
                } else {
                    $('.csv_error').text(' ');

                }
            }



            /* $('#state_id').on('blur', function ()

             {

             var state = $('#state_id').val();

             if (state == "")

             {

             $('#superror').html("Select State");

             } else

             {

             $('#superror').html("");

             }

             });

             $("#name").on('blur', function ()

             {

             var name = $("#name").val();

             var filter = /^[a-zA-Z.\s]{3,30}$/;

             if (name == "" || name == null || name.trim().length == 0)

             {

             $("#superror1").html("Required Field");

             } else if (!filter.test(name))

             {

             $("#superror1").html("Alphabets and Min 3 to Max 30 ");

             } else

             {

             $("#superror1").html("");

             }

             }); */

            $("#store").on('blur', function ()

            {

                var store = $("#store").val();

                if (store == "" || store == null || store.trim().length == 0)

                {

                    $("#superror2").text("Required Field");

                } else

                {

                    $("#superror2").text("");

                }

            });

            $('#address1').on('blur', function ()

            {

                var address = $('#address1').val();

                if (address == "" || address == null || address.trim().length == 0)

                {

                    $('#superror3').text("Required Field");

                } else

                {

                    $('#superror3').text("");

                }

            });

            $("#pincode").on('blur', function ()

            {

                var pin_code = $("#pincode").val();

                var pat1 = /^\d{6}$/;



                if (pin_code == "" || pin_code == null || pin_code.trim().length == 0)

                {

                    //$("#superror7").text("Required Field");

                } else

                {

                    if (!pat1.test(pin_code))

                    {

                        $("#superror7").text("Pin code should be 6 digits ");

                        pin_code.focus();

                        //return false;

                    } else {

                        $("#superror7").text("");

                    }



                }

            });

            $("#number").keyup('blur', function ()

            {

                var number = $("#number").val();

                var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

                if (number == "")

                {

                    $("#superror4").text("Required Field");

                } else if (!nfilter.test(number))

                {

                    $("#superror4").text("Enter Valid Mobile Number");

                } else

                {

                    $("#superror4").text("");

                }

            });

            $("#landline").keyup('blur', function ()

            {

                var number = $("#landline").val();

                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;

                if (number == "")

                {

                    //$("#landlinerr").text("Required Field");

                } else if (!nfilter.test(number))

                {

                    $("#landlinerr").text("Enter valid Landline Number");

                } else

                {

                    $("#landlinerr").text("");

                }

            });

            $("#mail").on('blur', function ()

            {

                var mail = $("#mail").val();

                var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

                if (mail == "")

                {

                    $("#superror5").text("");

                } else if (!efilter.test(mail))

                {

                    $("#superror5").text("Enter Valid Email");

                } else

                {

                    $("#superror5").text("");

                }

            });

            $('#bank').on('blur', function ()

            {

                var bank = $('#bank').val();

                if (bank == "" || bank == null || bank.trim().length == 0)

                {

                    //$('#superror6').text("Required Field");

                } else

                {

                    $('#superror6').text("");

                }

            });



            $("#credit_days").on('blur', function ()

            {

                var credit_days = $("#credit_days").val();

                if (credit_days == "")

                {

                    // $("#credit_dayserr").text("Required Field");

                } else

                {

                    $("#credit_dayserr").text("");

                }

            });



            $("#branch").on('blur', function ()

            {

                var branch = $("#branch").val();

                if (branch == "" || branch == null || branch.trim().length == 0)

                {

                    // $("#superror8").text("Required Field");

                } else

                {

                    $("#superror8").text("");

                }

            });

            $("#acnum").on('blur', function ()

            {

                var acnum = $("#acnum").val();

//                var acfilter = /^[a-zA-Z0-9]+$/;

                if (acnum == "")

                {

                    // $("#superror9").text("Required Field");

//                } else if (!acfilter.test(acnum))

//                {

//                    $("#superror9").text("Numeric or Alphanumeric");

                } else

                {

                    $("#superror9").text("");

                }

            });

            $("#acnum").keydown(function (e) {



                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode >= 35 && e.keyCode <= 40)) {



                    return;

                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

                    e.preventDefault();

                    $("#superror9").text("Numeric only");

                } else

                {

                    $("#superror9").text("");

                }

            });



            $("#city").on('blur', function ()

            {

                var city = $("#city").val();

                var regex = new RegExp("^[a-zA-Z\\s]+$");
                var char_test = regex.test(city);

                if (city == "" || city == null || city.trim().length == 0)

                {

                    $("#superror10").html("Required Field");

                } else if (city != "") {

                    if (char_test == false) {

                        $("#superror10").html("Invalid City");

                        i = 1;
                    } else {
                        $("#superror10").html("");
                    }

                } else
                {

                    $("#superror10").html("");

                }

            });



            $("#payment_terms").on('blur', function ()

            {

                var payment_terms = $("#payment_terms").val();



                if (payment_terms == "")

                {

                    // $("#superror11").text("Required Field");

                } else

                {

                    $("#superror11").text("");

                }

            });

            $("#ifsc").on('blur', function ()

            {

                var ifsc = $("#ifsc").val();



                if (ifsc == "")

                {

                    //$("#ifsc1").text("Required Field");

                } else

                {

                    $("#ifsc1").text("");

                }

            });

            $("#tin").on('blur', function ()

            {

                var tin = $("#tin").val();

                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;

                if (tin == "" || tin == null || tin.trim().length == 0)

                {

                    // $("#superror12").html("Required Field");

                } else if (!nfilter.test(tin))

                {

                    $("#superror12").text("Enter Valid GSTIN Number");

                } else

                {

                    $("#superror12").text("");

                }

            });

            $('#reset').on('click', function ()

            {

                $('.val').html("");

            });



        </script>

        <script type="text/javascript">

            $('#submit').on('click', function ()

            {

                var i = 0;

                var state = $('#state_id').val();

                if (state == "")

                {

                    $('#superror').text("Select State");

                    i = 1;

                } else

                {

                    $('#superror').text("");

                }

                /*var name = $("#name").val();

                 var filter = /^[a-zA-Z.\s]{3,30}$/;

                 if (name == "" || name == null || name.trim().length == 0)

                 {

                 $("#superror1").html("Required Field");

                 i = 1;

                 } else if (!filter.test(name))

                 {

                 $("#superror1").html("Alphabets and Min 3 to Max 30 ");

                 i = 1;

                 } else

                 {

                 $("#superror1").html("");

                 } */

                var store = $("#store").val();

                if (store == "" || store == null || store.trim().length == 0)

                {

                    $("#superror2").text("Required Field");

                    i = 1;

                } else

                {

                    $("#superror2").text("");

                }

                var pin_code = $('#pincode').val();

                var pat1 = /^\d{6}$/;

                if (pin_code == "")

                {

                    // $('#superror7').text("Required Field");

                    // i = 1;

                } else

                {

                    if (!pat1.test(pin_code))

                    {

                        $("#superror7").text("Pin code should be 6 digits ");

                        i = 1;

                    } else {

                        $("#superror7").text("");

                    }

                }



                var address = $('#address1').val();

                if (address == "" || address == null || address.trim().length == 0)

                {

                    $('#superror3').text("Required Field");

                    i = 1;

                } else

                {

                    $('#superror3').text("");

                }

                var number = $("#number").val();

                var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

                if (number == "")

                {

                    $("#superror4").text("Required Field");

                    i = 1;

                } else if (!nfilter.test(number))

                {

                    $("#superror4").text("Enter Valid Mobile Number");

                    i = 1;

                } else

                {

                    $("#superror4").text("");

                }



                var numbers = $("#landline").val();

                var nfilters = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;

                if (numbers == "")

                {

                    // $("#landlinerr").text("Required Field");

                    //i = 1;

                } else if (!nfilters.test(numbers))

                {

                    $("#landlinerr").text("Enter Valid Landline Number");

                    i = 1;

                } else

                {

                    $("#landlinerr").text("");

                }

                var mail = $("#mail").val();

                var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

                if (mail == "")

                {

                    $("#superror5").text("");

                } else if (!efilter.test(mail))

                {

                    $("#superror5").text("Enter Valid Email");

                    i = 1;

                } else

                {

                    $("#superror5").text("");

                }

                var bank = $('#bank').val();

                if (bank == "" || bank == null || bank.trim().length == 0)

                {

                    // $('#superror6').text("Required Field");

                    //  i = 1;

                } else

                {

                    $('#superror6').text("");

                }

                var credit_days = $("#credit_days").val();

                if (credit_days == "")

                {

                    //$("#credit_dayserr").text("Required Field");

                    // i = 1;

                } else

                {

                    $("#credit_dayserr").text("");

                }

                var branch = $("#branch").val();

                if (branch == "" || branch == null || branch.trim().length == 0)

                {

                    //$("#superror8").text("Required Field");

                    // i = 1;

                } else

                {

                    $("#superror8").text("");

                }

                var acnum = $("#acnum").val();

//                var acfilter = /^[0-9]+$/;

                if (acnum == "")

                {

                    //$("#superror9").text("Required Field");

                    //  i = 1;

                } else

                {

                    $("#superror9").text("");

                }

                var city = $("#city").val();

                var regex = new RegExp("^[a-zA-Z\\s]+$");
                var char_test = regex.test(city);



                if (city == "" || city == null || city.trim().length == 0)

                {

                    $("#superror10").html("Required Field");

                    i = 1;

                }
                if (city != "") {
                    if (char_test == false) {
                        $("#superror10").html("Invalid City Name");

                        i = 1;
                    } else {
                        $("#superror10").html("");
                    }

                } else

                {

                    $("#superror10").html("");

                }



                var firm = $('#firm').val();

                if (firm == "")

                {

                    $('#firmerr').text("Select State");

                    i = 1;

                } else

                {

                    $('#firmerr').text("");



                }

                var payment_terms = $("#payment_terms").val();

                if (payment_terms == "")

                {

                    //   $("#superror11").text("Required Field");

                    //   i = 1;

                } else

                {

                    $("#superror11").text("");

                }

                var ifsc = $("#ifsc").val();

                if (ifsc == "")

                {

                    // $("#ifsc1").text("Required Field");

                    //  i = 1;

                } else

                {

                    $("#ifsc1").text("");

                }

                var tin = $("#tin").val();

                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;

                if (tin == "" || tin == null || tin.trim().length == 0)

                {

                    //$("#superror12").text("Required Field");

                } else if (!nfilter.test(tin))

                {

                    $("#superror12").text("Enter Valid GSTIN Number");

                } else

                {

                    $("#superror12").text("");

                }

                var mess = $('#duplica').html();

                if ((mess.trim()).length > 0)

                {

                    i = 1;

                }

                var mess1 = $('#duplica1').html();

                if ((mess1.trim()).length > 0)

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

        <br /><br /><br />

    </div>

</div>



<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">

    <div class="modal-dialog">

        <div class="modal-content">

            <a class="close1" data-dismiss="modal">×</a>

            <div class="modal-body">

                <img src="<?= $this->config->item('base_url') . 'admin_image/original/' . $val['vendor_image'] ?>" width="50%" />

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function ()

    {

        $(".delete_yes").on("click", function ()

        {



            var hidin = $(this).parent().parent().find('.id').val();



            $.ajax({
                url: BASE_URL + "masters/suppliers/delete_vendor",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {



                    window.location.reload(BASE_URL + "masters/suppliers/");

                }

            });



        });



        $('.modal').css("display", "none");

        $('.fade').css("display", "none");



    });

</script>

<script type="text/javascript">

    $(".mail").on('blur', function ()

    {

        mail = $("#mail").val();

        $.ajax(
                {
                    url: BASE_URL + "masters/suppliers/add_duplicate_mail",
                    type: 'get',
                    data: {value1: mail

                    },
                    success: function (result)

                    {

                        $("#duplica").html(result);

                    }

                });

    });

    $(".landline").on('blur', function ()

    {

        landline = $("#landline").val();
        if (landline != "") {
            $.ajax(
                    {
                        url: BASE_URL + "masters/suppliers/add_duplicate_land",
                        type: 'get',
                        data: {value1: landline

                        },
                        success: function (result)

                        {

                            $("#duplica1").html(result);

                        }

                    });
        }



    });

</script>