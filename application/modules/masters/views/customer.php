<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

<style>

    .input-group-addon .fa { width:10px !important; }

</style>

<style>

    .ui-datepicker td.ui-datepicker-today a {

        background:999999;

    }

    #ui-datepicker-div {

        z-index: 4 !important;

    }
    .action-style {
        width: auto;
        text-align: center;
    }
    .text-center {
        text-align: left;
    }
	table tr td:nth-child(5) {text-align:center;}
	table tr td:nth-child(6) {text-align:center;}
</style>

<?php
$customers_json = array();

if (!empty($all_street)) {

    foreach ($all_street as $list) {

        if ($list['street_name'] != '')
            $customers_json[] = '{ value: "' . $list['street_name'] . '"}';
    }
}
?>

<div class="mainpanel">

    <div class="media">



    </div>

    <div class="contentpanel">

        <div class="media mt--2">

            <h4>Customer Details</h4>

        </div>

        <div class="panel-body  mb-25">

            <div class="tabs">



                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#customer-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Customer List</a></li>

                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'customers', 'add')): ?>#customer<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'customers', 'add')): ?>alerts<?php endif ?>">Add Customer</a></li>

                </ul>



                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane" id="customer">

                        <form action="<?php echo $this->config->item('base_url'); ?>masters/customers/insert_customer" enctype="multipart/form-data" name="form" method="post">

                            <div class="inner-sub-tit">Customer Details</div>

                            <div class="row">

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Shop Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <select name="firm_id"  class="form-control form-align" id="firm" >

                                                <option value="">Select</option>

                                                <?php
                                                if (isset($firms) && !empty($firms)) {

                                                    foreach ($firms as $key => $firm) {

                                                        if ($key == 0) {

                                                            $selected = 'selected="selected"';
                                                        } else {

                                                            $selected = '';
                                                        }
                                                        ?>

                                                        <option <?php echo $selected; ?> value="<?php echo $firm['firm_id']; ?>" > <?php echo $firm['firm_name']; ?> </option>

                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>

                                            <span id="firm_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Customer Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="store" class="store form-align" id="store" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-bank"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Contact Person</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="name" class="name form-align" id="name" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-phone"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Email Address</label>

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

                                        <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="number" class="number form-align" id="number" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-phone"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            <span id="duplica1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">DOB</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="dob"  class="datepicker form-align" id="dob" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-calendar"></i>

                                                </div>

                                            </div>

                                            <span id="dob1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-4">



                                    <!--    <div class="form-group">

                                            <label class="col-sm-4 control-label">Anniversary Date</label>

                                            <div class="col-sm-8">

                                                <div class="input-group">

                                                    <input type="text"  name="anniversary"  class="datepicker form-align" id="anniversary" />

                                                    <div class="input-group-addon">

                                                        <i class="fa fa-calendar"></i>

                                                    </div>

                                                </div>

                                                <span id="anniversary1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </div>

                                        </div>
                                    -->


                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">State</label>

                                        <div class="col-sm-8">

                                            <select id="state_id" name='state_id' class="state_id form-control form-align"  >

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

                                            </select><span id="cuserror" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">City</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="city" class="form-align" id="city" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-map-marker"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address1 <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <textarea name="address1" id="address" class="form-control form-align"></textarea>

                                            <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Address2</label>

                                        <div class="col-sm-8">

                                            <textarea name="address2" id="address2"  class="form-control form-align"></textarea>

                                        </div>

                                    </div>




                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Customer Type <span style="color:#F00; font-style:oblique;">*</span></label>

                                        <div class="col-sm-8">

                                            <select name="customer_type" id="customer_type" class="customer_type form-control form-align">

                                                <option value="">Select Type</option>
                                                <option value="1">Regular</option>

                                                <option value="2">Non - Regular</option>

                                                <!--<option value="1">T1</option>

                                                <option value="2">T2</option>

                                                <option value="3">T3</option>

                                                <option value="4">T4</option>

                                                <option value="5">T5</option>

                                                <option value="6">T6</option>

                                                <option value="7">H1</option>

                                                <option value="8">H2</option>-->

                                            </select>

                                            <span id="cus_type" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>


                                </div>



                                <div class="col-md-4">



                                    <!-- <div class="form-group">

                                        <label class="col-sm-4 control-label">Agent Name</label>

                                        <div class="col-sm-8">

                                            <select id='agent'  name="agent_name"  class="form-control form-align">

                                                <option value="">Select</option>

                                    <?php
                                    /* if (isset($all_agent) && !empty($all_agent)) {

                                      foreach ($all_agent as $val) {

                                      ?>

                                      <option value='<?php echo $val['id']; ?>'><?php echo $val['name']; ?></option>

                                      <?php

                                      }

                                      } */
                                    ?>

                                            </select><span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div> -->



                                    <!--  <div class="form-group">

                                          <label class="col-sm-4 control-label">Credit Days </label>

                                          <div class="col-sm-8">

                                              <div class="input-group">

                                                  <input type="text"  name="credit_days"  class="form-align" id="credit_days" />

                                                  <div class="input-group-addon">

                                                      <i class="fa fa-fw fa-money"></i>

                                                  </div>

                                              </div>

                                              <!--<span id="credit_days1" class="val"  style="color:#F00; font-style:oblique;"></span></td>

                                          </div>

                                      </div>



                                      <div class="form-group">

                                          <label class="col-sm-4 control-label">Credit Limit </label>

                                          <div class="col-sm-8">

                                              <div class="input-group">

                                                  <input type="text"  name="credit_limit"  class="form-align" id="credit_limit" />

                                                  <div class="input-group-addon">

                                                      <i class="fa fa-fw fa-money"></i>

                                                  </div>

                                              </div>

                                              <!--<span id="credit_limit1" class="val"  style="color:#F00; font-style:oblique;"></span></td>

                                          </div>

                                      </div>
                                    -->





                                    <!--<div class="form-group">

                                        <label class="col-sm-4 control-label">Customer Region <span style="color:#F00; font-style:oblique;"></span></label>

                                        <div class="col-sm-8">

                                            <select name="customer_region" id="customer_region" class="customer_type form-control form-align">

                                                <option value="">Select Type</option>

                                                <option value="local">Local Customers</option>

                                                <option value="non-local">Non-Local Customers</option>



                                            </select>

                                            <span id="cus_region" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <div  id="streetdiv" class="form-group" style="display:none">

                                            <label class="col-sm-4 control-label">Kayalpattinam Street <span style="color:#F00; font-style:oblique;">*</span></label>

                                            <div class="col-sm-8">

                                                <input type="text"  name="street_name"  class="form-control form-align" id="street"/>

<!--                                                <select id="street" name='street_name' class="state_id form-control form-align" >

                                                    <option value="">Select</option>

                                    <?php
                                    if (isset($all_street) && !empty($all_street)) {

                                        foreach ($all_street as $vals) {
                                            ?>



                                            <?php
                                        }
                                    }
                                    ?>

                                                </select>

                                                <span id="streeterr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Payment Terms</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text"  name="payment_terms"  class="form-align" id="payment_terms"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fw fa-money"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Advance Amount</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text"  name="advance"  class="form-align" id="advance"/>

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fw fa-money"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror15" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>-->



                                </div>

                            </div>

                            <div class="clearfix"></div>

                            <div class="inner-sub-tit mstyle">Bank Details</div>

                            <div class="row">

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Bank Name </label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="bank" class="form-align" id="bank" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-bank"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Bank Branch </label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="branch" class="form-align" id="branch" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-bank"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>

                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Account No </label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="acnum" class="form-align" id="acnum" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-user"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">IFSC Code </label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text" name="ifsc" class="form-align" id="ifsc" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-fax"></i>

                                                </div>

                                            </div>

                                            <span id="ifsc1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>



                                <div class="col-md-4">



                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">GSTIN</label>

                                        <div class="col-sm-8">

                                            <div class="input-group">

                                                <input type="text"  name="tin"  class="form-align" id="tin_vat" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-cog"></i>

                                                </div>

                                            </div>

                                            <span id="cuserror15" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </div>

                                    </div>



                                </div>



                            </div>



                            <div class="frameset_table action-btn-align">

                                <input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" />

                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" />

                                <a href="<?php echo $this->config->item('base_url') . 'masters/customers/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>

                    </div>

                    <div role="tabpanel" class="tab-pane active tablelist" id="customer-details">

                        <div class="frameset_big1">

                            <table id="example" class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer " cellspacing="0" width="100%">

                                <thead>

                                    <tr style="text-align:center;">

                                        <th style="text-align:center;" class="sorting">S.No</th>

                                        <th style="text-align:center;">Shop Name</th>

                                        <th style="text-align:center;" >Customer Name</th>

                                        <th style="text-align:center;" >Customer Type</th>

                                        <th style="text-align:center;">Mobile Number</th>

                                        <th style="text-align:center;">Email&nbsp;Address</th>

                                        <th style="text-align:center;"><div class="action-style">Action</div></th>

                                    </tr>

                                </thead>

                                <tbody>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <div class="panel-body action-btn-align">

                <button type="button" class="btn btn-primary add_bluk_import"><i class="icon-plus-circle2 position-left"></i> Import Customers</button>

            </div>

        </div>

    </div>

</div>

<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-info">

                <h6 class="modal-title">Import Customers</h6>

            </div>

            <form action="<?php echo $this->config->item('base_url'); ?>masters/customers/import_customers" enctype="multipart/form-data" name="import_customers" method="post" id="import_form">

                <div class="modal-body">

                    <div class="form-group">

                        <div class="col-lg-12">

                            <div class="col-md-2"></div>

                            <div class="col-md-8">

                                <div class="form-group">

                                    <label><strong>Attachment:</strong></label>

                                    <input type="file" name="customer_data" id="customer_data" class="form-control customer_data_csv" onchange="return fileValidation()">

                                    <span class="error_msg"></span>

                                    <a href="<?php echo $this->config->item('base_url') . 'attachement/csv/sample_customer.csv'; ?>" download><i class="fa fa-download"></i>&nbsp; Sample File</a>

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
if (isset($customer) && !empty($customer)) {

    foreach ($customer as $val) {
        ?>

        <div id="test<?php echo $val['id']; ?>" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content modalcontent-top">

                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>



                        <h3 id="myModalLabel" class="inactivepop">In-Active Customer</h3>

                    </div>

                    <div class="modal-body">

                        Do You Want In-Active This Customer? <?= $val['name']; ?> <strong>(<?= $val['store_name']; ?>)</strong>

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



<br />



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
                                                    "url": "<?php echo site_url('masters/customers/ajaxList/'); ?>",
                                                    "type": "POST",
                                                    sucess: function (data) {

                                                        console.log(data);
                                                    }

                                                },
                                                //Set column definition initialisation properties.

                                                "columnDefs": [
                                                    {
                                                        "targets": [0, 5], //first column / numbering column

                                                        "orderable": false, //set not orderable

                                                    },
                                                    {className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6]},
                                                ],
                                            });
                                        });</script>



<script type="text/javascript">

    $(document).on('click', '.alerts', function () {

        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $(document).ready(function () {

        $('#state_id').select2();
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true
        });
    });
    $('body').on('keydown', 'input#street', function (e) {

        var c_data = [<?php echo implode(',', $customers_json); ?>];
        $("#street").autocomplete({
            source: function (request, response) {

                // filter array to only entries you want to display limited to 10

                var outputArray = new Array();
                for (var i = 0; i < c_data.length; i++) {

                    if (c_data[i].value.match(request.term)) {

                        outputArray.push(c_data[i]);
                    }

                }

                response(outputArray.slice(0, 10));
            },
            minLength: 0,
            autoFill: false,
            select: function (event, ui) {

                $("#street").val(ui.item.label);
            }

        });
    });
    function check(val)

    {

        $('#test' + val).modal('show');
    }



    $('.add_bluk_import').click(function () {



        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false

        });
        $('#myModal').modal('show');
    });
    $("#import_form").submit(function (event) {

        var data = $('.customer_data_csv').val();
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
        var fileInput = document.getElementById('customer_data');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv)$/i;
        if (!allowedExtensions.exec(filePath)) {
            $('.csv_error').text('Invalid File Format');

            return false;
        } else {
            $('.csv_error').text(' ');

        }
    }
    $('#state_id').on('blur', function ()

    {

        var state = $('#state_id').val();
        if (state == "")

        {

            $('#cuserror').html("Select State");
        } else

        {

            $('#cuserror').html("");
        }

    });
    $('.state_id').on('blur', function ()

    {


        var state = $('.state_id').val();
        if (state == "37")

        {

            $('#cuserror').html('<input type="text" name="state" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off"> <span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');
        }

    });
    $('#state').on('blur', function () {



        var this_ = $(this).val();
        if (this_ == "")

        {

            $('#cuserror_state').html("Required Field");
        } else

        {

            $('#cuserror_state').html("");
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "customer/add_state",
                data: {state: this_},
                success: function (datas) {



                }

            });
        }



    });
    /* $("#name").on('blur', function ()

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

     });*/

    $("#store").on('blur', function ()

    {

        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)

        {

            $("#cuserror2").html("Required Field");
        } else

        {

            $("#cuserror2").html("");
        }

    });
    $('#address').on('blur', function ()

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
    $("#number").on('blur', function ()

    {

        var number = $("#number").val();
        var nfilter = /^[0-9]+$/;
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
    $("#mail").on('blur', function ()

    {

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail != "" && !efilter.test(mail))

        {

            $("#cuserror5").html("Enter Valid Email");
        } else

        {

            $("#cuserror5").html("");
        }

    });
    /* $ $('#bank').on('blur', function ()

     {

     var bank = $('#bank').val();

     if (bank == "" || bank == null || bank.trim().length == 0)

     {

     $('#cuserror6').html("Required Field");

     } else

     {

     $('#cuserror6').html("");

     }

     });

     ('#percentage').on('blur', function ()

     {

     var percentage = $('#percentage').val();

     var pefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;

     if (percentage == "" || percentage == null || percentage.trim().length == 0)

     {

     $('#cuserror7').html("Required Field");

     } else if (!pefilter.test(percentage))

     {

     $("#cuserror7").html("Enter Valid Percentage");

     } else

     {

     $('#cuserror7').html("");

     }

     });

     $('#city').on('blur', function ()

     {

     var city = $('#city').val();

     if (city == "")

     {

     $('#cuserror8').html("Required Field");

     } else

     {

     $('#cuserror8').html("");

     }

     });

     $("#pincode").on('blur', function ()

     {

     var pincode = $("#pincode").val();

     if (pincode == "")

     {

     $("#cuserror9").html("Required Field");

     } else if (pincode.length != 6)

     {

     $("#cuserror9").html("Maximum 6 characters");

     } else

     {

     $("#cuserror9").html("");

     }

     });

     $("#branch").on('blur', function ()

     {

     var branch = $("#branch").val();

     if (branch == "" || branch == null || branch.trim().length == 0)

     {

     $("#cuserror10").html("Required Field");

     } else

     {

     $("#cuserror10").html("");

     }

     });

     $("#acnum").on('blur', function ()

     {

     var acnum = $("#acnum").val();

     var acfilter = /^[0-9]+$/;

     if (acnum == "")

     {

     $("#cuserror11").html("Required Field");

     } else if (!acfilter.test(acnum))

     {

     $("#cuserror11").html("Numeric Only");

     } else

     {

     $("#cuserror11").html("");

     }

     });*/



    /* $('#agent').on('change', function ()

     {

     var agent = $('#agent').val();

     if (agent == "")

     {

     $('#cuserror12').html("Required Field");

     } else

     {

     $('#cuserror12').html("");

     }

     });

     $('#agent_comm').on('blur', function ()

     {

     var agent_comm = $('#agent_comm').val();

     var apefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;

     if (agent_comm == "" || agent_comm == null || agent_comm.trim().length == 0)

     {

     $('#cuserror13').html("Required Field");

     } else if (!apefilter.test(agent_comm))

     {

     $("#cuserror13").html("Enter Valid Percentage");

     } else

     {

     $('#cuserror13').html("");

     }

     });

     $("#payment_terms").on('blur', function ()

     {

     var payment_terms = $("#payment_terms").val();



     if (payment_terms == "")

     {

     $("#cuserror14").html("Required Field");

     } else

     {

     $("#cuserror14").html("");

     }

     });

     $('#tin_vat').on('blur', function ()

     {

     var tin = $('#tin_vat').val();

     if (tin == "" || tin == null || tin.trim().length == 0)

     {

     $('#cuserror15').html("Required Field");

     } else

     {

     $('#cuserror15').html("");

     }

     });*/



    $('#customer_type').on('blur', function ()

    {

        var customer_type = $('#customer_type').val();
        if (customer_type == "" || customer_type == null || customer_type.trim().length == 0)

        {

            $('#cus_type').html("Required Field");
        } else

        {

            $('#cus_type').html("");
        }



    });
    /* $('#ifsc').on('blur', function ()

     {

     var ifsc = $('#ifsc').val();

     if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)

     {

     $('#ifsc1').html("Required Field");

     } else

     {

     $('#ifsc1').html("");

     }

     });*/

//    $('#credit_days').on('blur', function ()

//    {

//        var credit_days = $('#credit_days').val();

//        if (credit_days == "" || credit_days == null || credit_days.trim().length == 0)

//        {

//            $('#credit_days1').html("Required Field");

//        } else

//        {

//            $('#credit_days1').html("");

//        }

//    });

//    $('#credit_limit').on('blur', function ()

//    {

//        var credit_limit = $('#credit_limit').val();

//        if (credit_limit == "" || credit_limit == null || credit_limit.trim().length == 0)

//        {

//            $('#credit_limit1').html("Required Field");

//        } else

//        {

//            $('#credit_limit1').html("");

//        }

//    });

    $('#customer_region').on('blur', function ()

    {

        var customer_region = $('#customer_region').val();
        if (customer_region == "" || customer_region == null || customer_region.trim().length == 0)

        {

            // $('#cus_region').html("Required Field");

        } else

        {

            $('#cus_region').html("");
        }

    });
    $('#customer_region').on('change', function ()

    {

        var customer_region = $('#customer_region').val();
        if (customer_region == 'local') {

            $('#streetdiv').css('display', 'block');
        } else {

            $('#streetdiv').css('display', 'none');
        }

    });
    $('#firm').on('blur', function ()

    {

        var firm = $('#firm').val();
        if (firm == "" || firm == null || firm.trim().length == 0)

        {

            $('#firm_err').html("Required Field");
        } else

        {

            $('#firm_err').html("");
        }

    });
    /* $('#c_cst').on('blur', function ()

     {

     var cst = $('#c_cst').val();

     if (cst == "")

     {

     $("#c_cst").css('border-color', 'red');

     } else

     {

     $("#c_cst").css('border-color', '');

     }

     });

     $('#c_vat').on('blur', function ()

     {

     var vat = $('#c_vat').val();

     if (vat == "")

     {

     $("#c_vat").css('border-color', 'red');

     } else

     {

     $("#c_vat").css('border-color', '');

     }

     });*/

    $('#reset').on('click', function ()

    {

        $('.val').html("");
    });</script>

<script type="text/javascript">

    $('#submit').on('click', function ()

    {



        var i = 0;
        var state = $('#state_id').val();
        if (state == "")

        {

            $('#cuserror').html("Select State");
            i = 1;
        } else

        {

            $('#cuserror').html("");
        }

        /* var name = $("#name").val();

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

         }*/

        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)

        {

            $("#cuserror2").html("Required Field");
            i = 1;
        } else

        {

            $("#cuserror2").html("");
        }

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").text("");

        } else if (!efilter.test(mail))
        {
            $("#cuserror5").text("Enter Valid Email");
            i = 1;
        } else
        {
            $("#cuserror5").text("");
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

        var number = $("#number").val();
        var nfilter = /^[0-9]+$/;
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





        /* var bank = $('#bank').val();

         if (bank == "" || bank == null || bank.trim().length == 0)

         {

         $('#cuserror6').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror6').html("");

         }

         var ifsc = $('#ifsc').val();

         if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)

         {

         $('#ifsc1').html("Required Field");

         i = 1;

         } else

         {

         $('#ifsc1').html("");

         }

         var city = $('#city').val();

         if (city == "")

         {

         $('#cuserror8').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror8').html("");

         }



         var branch = $("#branch").val();

         if (branch == "" || branch == null || branch.trim().length == 0)

         {

         $("#cuserror10").html("Required Field");

         i = 1;

         } else

         {

         $("#cuserror10").html("");

         }

         var acnum = $("#acnum").val();

         var acfilter = /^[0-9]+$/;

         if (acnum == "")

         {

         $("#cuserror11").html("Required Field");

         i = 1;

         } else if (!acfilter.test(acnum))

         {

         $("#cuserror11").html("Numeric or Alphanumeric");

         i = 1;

         } else

         {

         $("#cuserror11").html("");

         }*/

        /*var agent = $('#agent').val();

         if (agent == "")

         {

         $('#cuserror12').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror12').html("");

         }



         var payment_terms = $("#payment_terms").val();



         if (payment_terms == "")

         {

         $("#cuserror14").html("Required Field");

         i = 1;

         } else

         {

         $("#cuserror14").html("");

         }

         var tin = $('#tin_vat').val();

         if (tin == "" || tin == null || tin.trim().length == 0)

         {

         $('#cuserror15').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror15').html("");

         }*/

        var customer_type = $('#customer_type').val();
        if (customer_type == "" || customer_type == null || customer_type.trim().length == 0)

        {

            $('#cus_type').html("Required Field");
            i = 1;
        } else

        {

            $('#cus_type').html("");
        }

//        var credit_days = $('#credit_days').val();

//        if (credit_days == "" || credit_days == null || credit_days.trim().length == 0)

//        {

//            $('#credit_days1').html("Required Field");

//            i = 1;

//        } else

//        {

//            $('#credit_days1').html("");

//        }

//        var credit_limit = $('#credit_limit').val();

//        if (credit_limit == "" || credit_limit == null || credit_limit.trim().length == 0)

//        {

//            $('#credit_limit1').html("Required Field");

//            i = 1;

//        } else

//        {

//            $('#credit_limit1').html("");

//        }

        var customer_region = $('#customer_region').val();
        if (customer_region == "" || customer_region == null || customer_region.trim().length == 0)

        {

            //  $('#cus_region').html("Required Field");

            // i = 1;

        } else if (customer_region == 'local') {

            var street = $('#street').val();
            if (street == "" || street == null || street.trim().length == 0)

            {

                $('#streeterr').html("Required Field");
                i = 1;
            } else

            {

                $('#streeterr').html("");
            }



        } else

        {

            $('#cus_region').html("");
        }

        /*var dob = $('#dob').val();

         if (dob == "" || dob == null || dob.trim().length == 0)

         {

         $('#dob1').html("Required Field");

         i = 1;

         } else

         {

         $('#dob1').html("");

         }

         var anniversary = $('#anniversary').val();

         if (anniversary == "" || anniversary == null || anniversary.trim().length == 0)

         {

         $('#anniversary1').html("Required Field");

         i = 1;

         } else

         {

         $('#anniversary1').html("");

         }*/

        var firm = $('#firm').val();
        if (firm == "" || firm == null || firm.trim().length == 0)

        {

            $('#firm_err').html("Required Field");
            i = 1;
        } else

        {

            $('#firm_err').html("");
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



    });</script>

<script>

    $(".email_dup").on('blur', function ()

    {

        email = $("#mail").val();
        if (email != '') {

            $.ajax(
                    {
                        url: BASE_URL + "masters/customers/add_duplicate_email",
                        type: 'get',
                        data: {value1: email},
                        success: function (result)

                        {

                            $("#duplica").html(result);
                        }

                    });
        }

    });
    $(".number").on('blur', function ()

    {

        number = $("#number").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/customers/add_duplicate_mobile",
                    type: 'get',
                    data: {value1: number

                    },
                    success: function (result)

                    {

                        $("#duplica1").html(result);
                    }

                });
    });</script>

















<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">

    <div class="modal-dialog">

        <div class="modal-content">

            <a class="close1" data-dismiss="modal">×</a>

            <div class="modal-body">

               <!-- <img src="<?= $this->config->item('base_url') . '/cust_image/thumb/' . $val['cus_image'] ?>" width="50%" />-->

                <img src="" width="50%" />

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
                url: BASE_URL + "masters/customers/delete_customer",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {



                    window.location.reload(BASE_URL + "masters/customers/");
                }

            });
        });
        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    });

</script>