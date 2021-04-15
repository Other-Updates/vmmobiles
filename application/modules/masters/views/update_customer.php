<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style>

    .input-group-addon .fa { width:10px !important; }

</style>

<style>

    .ui-datepicker td.ui-datepicker-today a {

        background:#999999;

    }



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

    <div class="contentpanel mb-45">

        <div class="media mt--2">

            <h4>Update Customer</h4>

        </div>

        <div class="panel-body">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#update-customer" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>

                </ul>



                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane active" id="update-customer">

                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'masters/customers/update_customer'; ?>">

                            <?php
                            if (isset($customer) && !empty($customer)) {



                                $i = 0;

                                foreach ($customer as $val) {

                                    $i++;

                                    if ($customer[0]['state_id'] == 0) {

                                        $customer[0]['state_id'] = 31;
                                    }
                                    ?>

                                    <div class="inner-sub-tit">Customer Details</div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <input type="hidden" name="id" class="id id_dup form-control form-align" readonly="readonly" value="<?php echo $val['id']; ?>" />



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Shop Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <select name="firm_id"  class="form-control form-align" id="firm" tabindex="1" >

                                                        <?php
                                                        if (isset($firms) && !empty($firms)) {

                                                            foreach ($firms as $firm) {

                                                                $select = ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '';
                                                                ?>

                                                                <option value="<?php echo $firm['firm_id']; ?>" <?php echo $select; ?>> <?php echo $firm['firm_name']; ?> </option>

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

                                                        <input type="text" name="store" class="store form-align" id="store" value="<?php echo $val['store_name']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="name" id="name"  class="name form-align" value="<?php echo $val['name']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="mail" class="mail up_mail_dup form-align" id="mail" value="<?php echo $val['email_id']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-envelope"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                    <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="number" class="mobile form-align" id="mobile" maxlength="10" value="<?php echo $val['mobil_number']; ?>" tabindex="1" />

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-phone"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                    <span id="upduplica1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">DOB</label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="dob"  class="datepicker form-align" id="dob" value="<?php echo $val['dob']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-calendar"></i>

                                                        </div>

                                                    </div>

                                                    <span id="dob1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <!--<div class="form-group">

                                                <label class="col-sm-4 control-label">Anniversary Date</label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text"  name="anniversary"  class="datepicker  form-align" id="anniversary" value="<?php echo $val['anniversary']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-calendar"></i>

                                                        </div>

                                                    </div>

                                                    <span id="anniversary1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>-->



                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">State</label>

                                                <div class="col-sm-8">

                                                    <select id="state_id" name='state_id' class="state_id form-control form-align"  tabindex="1">

                                                        <option value="">Select</option>

                                                        <?php
                                                        if (isset($all_state) && !empty($all_state)) {

                                                            foreach ($all_state as $bill) {
                                                                ?>

                                                                <option <?php echo ($bill['id'] == $customer[0]['state_id']) ? 'selected' : '' ?> value="<?php echo $bill['id']; ?>"><?php echo $bill['state']; ?></option>

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

                                                        <input type="text" name="city" id="city"  class="form-align" value="<?php echo $val['city']; ?>" tabindex="1"/>

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

                                                    <textarea  name='address1' id="address" class="form-control form-align" tabindex="1"><?php echo $val['address1']; ?></textarea>

                                                    <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Address2</label>

                                                <div class="col-sm-8">

                                                    <textarea  name='address2' id="address2" class="form-control form-align" tabindex="1"><?php echo $val['address2']; ?></textarea>

                                                </div>

                                            </div>



                                            <!-- <div class="form-group">

                                                <label class="col-sm-4 control-label">Agent Name</label>

                                                <div class="col-sm-8">

                                                    <select id='agent'  name="agent_name"  class="form-control form-align" tabindex="1">

                                                        <option value="">Select</option>

                                            <?php
                                            /* if (isset($all_agent) && !empty($all_agent)) {

                                              foreach ($all_agent as $va1) {

                                              ?>

                                              <option <?php echo ($val['agent_name'] == $va1['id']) ? 'selected' : '' ?> value='<?php echo $va1['id']; ?>'><?php echo $va1['name']; ?></option>

                                              <?php

                                              }

                                              } */
                                            ?>

                                                    </select> <span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div> -->



                                            <!-- <div class="form-group">

                                                 <label class="col-sm-4 control-label">Credit Days </label>

                                                 <div class="col-sm-8">

                                                     <div class="input-group">

                                                         <input type="text"  name="credit_days"  class="form-align" id="credit_days" value="<?php echo $val['credit_days']; ?>" tabindex="1"/>

                                                         <div class="input-group-addon">

                                                             <i class="fa fa-fw fa-money"></i>

                                                         </div>

                                                     </div>

                                                     <!--<span id="credit_days1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                 </div>

                                             </div>-->
                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Customer Type <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <select id="customer_type" name="customer_type"  class="form-control form-align" tabindex="1">

                                                        <option value="">Select Type</option>
                                                        <option value="1" <?php echo ($val['customer_type'] == 1) ? 'selected' : ''; ?>>Regular</option>
                                                        <option value="2" <?php echo ($val['customer_type'] == 2) ? 'selected' : ''; ?>>Non - Regular</option>

                                                        <!--  <option value="1" <?php
                                                        if ($val['customer_type'] == 1) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T1</option>

                                                          <option value="2" <?php
                                                        if ($val['customer_type'] == 2) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T2</option>

                                                          <option value="3" <?php
                                                        if ($val['customer_type'] == 3) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T3</option>

                                                          <option value="4" <?php
                                                        if ($val['customer_type'] == 4) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T4</option>

                                                          <option value="5" <?php
                                                        if ($val['customer_type'] == 5) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T5</option>

                                                          <option value="6" <?php
                                                        if ($val['customer_type'] == 6) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>T6</option>

                                                          <option value="7" <?php
                                                        if ($val['customer_type'] == 7) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>H1</option>

                                                          <option value="8" <?php
                                                        if ($val['customer_type'] == 8) {

                                                            echo "selected=selected";
                                                        } else {

                                                            echo '';
                                                        }
                                                        ?>>H2</option>-->

                                                    </select>

                                                    <span id="cust_type" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">



                                            <!--<div class="form-group">

                                                <label class="col-sm-4 control-label">Credit Limit </label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text"  name="credit_limit"  class="form-align" id="credit_limit" value="<?php
                                            if ($val['credit_limit'] != '') {

                                                echo $val['credit_limit'];
                                            } else {

                                                echo '';
                                            }
                                            ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <!--<span id="credit_limit1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Temporary Credit Limit</label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text"  name="temp_credit"  class="form-align" id="temp_credit" value="<?php
                                            if ($val['temp_credit_limit'] != '') {

                                                echo $val['temp_credit_limit'];
                                            } else {

                                                echo '';
                                            }
                                            ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="credit_limit1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>
                                            -->






                                            <!--  <div class="form-group">

                                                  <label class="col-sm-4 control-label">Customer Region <span style="color:#F00; font-style:oblique;"></span></label>

                                                  <div class="col-sm-8">

                                                      <select name="customer_region" id="customer_region" class="customer_region form-control form-align" tabindex="1">

                                                          <option value="">Select Type</option>

                                                          <option value="local" <?php
                                            if ($val['customer_region'] == 'local') {

                                                echo 'selected=selected';
                                            } else {

                                                echo '';
                                            }
                                            ?>>Local Customers</option>

                                                          <option value="non-local" <?php
                                            if ($val['customer_region'] == 'non-local') {

                                                echo 'selected=selected';
                                            } else {

                                                echo '';
                                            }
                                            ?>>Non-Local Customers</option>



                                                      </select>

                                                      <span id="cus_region" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                  </div>

                                              </div>

                                              <div class="form-group">

                                                  <div  id="streetdiv" class="form-group" >

                                                      <label class="col-sm-4 control-label">Kayalpattinam Street <span style="color:#F00; font-style:oblique;">*</span></label>

                                                      <div class="col-sm-8">

                                                          <input type="text"  name="street_name" class="form-control form-align"  id="street" value="<?php echo $customer[0]['street_name'] ?>" tabindex="1"/>

                                                          <span id="streeterr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                      </div>

                                                  </div>

                                              </div>



                                              <div class="form-group">

                                                  <label class="col-sm-4 control-label">Payment Terms</label>

                                                  <div class="col-sm-8">

                                                      <div class="input-group">

                                                          <input type="text"  name="payment_terms" class="form-align"  id="payment_terms" value="<?php echo $val['payment_terms']; ?>" tabindex="1"/>

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

                                                          <input type="text"  name="advance"  class="form-align" id="advance" value="<?php echo $val['advance']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="bank" class="bank form-align" id="bank" value="<?php echo $val['bank_name']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="branch" class="form-align" id="branch" value="<?php echo $val['bank_branch']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="acnum" class="form-align" id="acnum" value="<?php echo $val['account_num']; ?>" tabindex="1"/>

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

                                                        <input type="text" name="ifsc" class="form-align" id="ifsc" value="<?php echo $val['ifsc']; ?>" tabindex="1"/>

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

                                                        <input type="text" class="form-align"   name="tin" id="tin" value="<?php echo $val['tin']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-user"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cuserror15" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                        </div>



                                        <input type="hidden"  name="approved_by" class="form-align"  id="approved_by" value="<?php echo ($user_id) ? $user_id : ''; ?>"/>

                                    </div>



                                    <?php
                                }
                            }
                            ?>

                            <div class="frameset_table action-btn-align">

                                <input type="submit" value="Update" class="submit btn btn-info1" id="edit"  tabindex="1"/>

                                <input type="reset" value="Clear" class="submit btn btn-danger1" id="reset"  tabindex="1"/>

                                <a href="<?php echo $this->config->item('base_url') . 'masters/customers/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $('#dob').datepicker({
            dateFormat: 'yy-mm-dd',
        });

        $('#anniversary').datepicker({
            dateFormat: 'yy-mm-dd',
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



        $("#mobile").keydown(function (e) {

            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 40)) {



                return;

            }

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

                e.preventDefault();

            }

        });

        var customer_region = $('#customer_region').val();

        if (customer_region == 'local') {

            $('#streetdiv').css('display', 'block');

        } else {

            $('#streetdiv').css('display', 'none');

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

            $('#cuserror').html('<input type="text" name="state_id" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off"><span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');

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
                url: "<?php echo $this->config->item('base_url'); ?>" + "masters/customers/add_state",
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

     }); */

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

            $('#cuserror3').html("Enter Address");

        } else

        {

            $('#cuserror3').html("");

        }

    });

    $("#mobile").on('blur', function ()

    {

        var number = $("#mobile").val();

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

    /* $('#bank').on('blur', function ()

     {

     var bank = $('#bank').val();

     if (bank == "" || bank == null || bank.trim().length == 0)

     {

     $('#cuserror6').html("Enter Details");

     } else

     {

     $('#cuserror6').html("");

     }

     });

     $('#percent').on('blur', function ()

     {

     var percentage = $('#percent').val();

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

     $('#tin').on('blur', function ()

     {

     var tin = $('#tin').val();

     if (tin == "" || tin == null || tin.trim().length == 0)

     {

     $('#cuserror15').html("Required Field");

     } else

     {

     $('#cuserror15').html("");

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

    $('#customer_type').on('blur', function ()

    {

        var customer_type = $('#customer_type').val();

        if (customer_type == "" || customer_type == null || customer_type.trim().length == 0)

        {

            $('#cust_type').html("Required Field");

        } else

        {

            $('#cust_type').html("");

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

     });

     $('#sell_price').on('blur', function ()

     {

     var sell_price = $('#sell_price').val();

     if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)

     {

     $('#sell_price1').html("Required Field");

     } else

     {

     $('#sell_price1').html("");

     }

     });

     $('#c_cst').on('blur', function ()

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

    })

</script>

<script type="text/javascript">

    $('#edit').on('click', function ()

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

        /*var name = $("#name").val();

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

        var address = $('#address').val();

        if (address == "" || address == null || address.trim().length == 0)

        {

            $('#cuserror3').html("Enter Address");

            i = 1;

        } else

        {

            $('#cuserror3').html("");

        }

        var number = $("#mobile").val();

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



        /*var bank = $('#bank').val();

         if (bank == "" || bank == null || bank.trim().length == 0)

         {

         $('#cuserror6').html("Enter Details");

         i = 1;

         } else

         {

         $('#cuserror6').html("");

         }

         var city = $('#city').val();

         if (city == "")

         {

         $('#cuserror8').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror8').html("");

         }*/

        var customer_region = $('#customer_region').val();

        if (customer_region == "")

        {

            // $('#cus_region').html("Required Field");

            //  i = 1;

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

        /*var branch = $("#branch").val();

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

         $("#cuserror11").html("Numeric Only");

         i = 1;

         } else

         {

         $("#cuserror11").html("");

         } */

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

         var tin = $('#tin').val();

         if (tin == "" || tin == null || tin.trim().length == 0)

         {

         $('#cuserror15').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror15').html("");

         }

         var ifsc = $('#ifsc').val();

         if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)

         {

         $('#ifsc1').html("Required Field");

         i = 1;

         } else

         {

         $('#ifsc1').html("");

         }*/

        var customer_type = $('#customer_type').val();

        if (customer_type == "" || customer_type == null || customer_type.trim().length == 0)

        {

            $('#cust_type').html("Required Field");

            i = 1;

        } else

        {

            $('#cust_type').html("");

        }





        /* var tin = $('#tin').val();

         if (tin == "" || tin == null || tin.trim().length == 0)

         {

         $('#cuserror15').html("Required Field");

         i = 1;

         } else

         {

         $('#cuserror15').html("");

         }

         var dob = $('#dob').val();

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




        var mess = $("#upduplica").html();

        if ((mess.trim()).length > 0)

        {

            i = 1;

        }

        var mess1 = $("#upduplica1").html();

        if ((mess1.trim()).length > 0)

        {

            i = 1;

        }

        //alert(i);

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

    $("#mail").on('blur', function () {



        var mail = $("#mail").val();

        var id = $('.id').val();

        if (mail != '') {

            $.ajax({
                url: BASE_URL + "masters/customers/update_duplicate_email",
                type: 'POST',
                data: {value1: mail, value2: id},
                success: function (result)

                {

                    $("#upduplica").html(result);

                }

            });

        }

    });



    $("#mobile").on('blur', function () {



        var mobile = $("#mobile").val();

        var id = $('.id').val();

        if (mobile != '') {

            $.ajax({
                url: BASE_URL + "masters/customers/update_duplicate_mobile",
                type: 'POST',
                data: {value1: mobile, value2: id},
                success: function (result)

                {

                    $("#upduplica1").html(result);

                }

            });

        }

    });

</script>

