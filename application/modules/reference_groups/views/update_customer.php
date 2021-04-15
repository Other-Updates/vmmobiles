<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
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
                <!-- Tab panes -->
                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane active" id="update-customer">
                        <!-- <h4 align="center" class="sup-align">Update Customer</h4>-->
                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'customer/update_customer'; ?>"> 
                            <table  class="table table-striped  responsive no-footer dtr-inline">
                                <?php
                                if (isset($customer) && !empty($customer)) {

                                    $i = 0;
                                    foreach ($customer as $val) {
                                        $i++
                                        ?>
                                        <tr>
                                        <input type="hidden" name="id" class="id id_dup form-control form-align" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                        <td>State</td>
                                        <td>
                                            <select id="state_id" name='state_id' class="state_id form-control form-align"  >
                                                <option value="">Select</option>
                                                <?php
                                                if (isset($all_state) && !empty($all_state)) {
                                                    foreach ($all_state as $bill) {
                                                        ?>
                                                        <option <?= ($bill['id'] == $customer[0]['state_id']) ? 'selected' : '' ?> value="<?= $bill['id'] ?>"><?= $bill['state'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select><span id="cuserror" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <td>City</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="city" id="city"  class="form-control form-align" value="<?= $val['city'] ?>" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-map-marker"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>
                                        <td>Account No</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?= $val['account_num'] ?>" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </td>

                                        </tr>
                                      <!--  <tr>
                                         
                                           <td width="15%">Agent Commission(%)</td>
                                          <td width="15%">
                                              <input type="text"  name="agent_comm" class="form-control form-align"  id="agent_comm" value="<?= $val['agent_comm'] ?>"/>
                                               <span id="cuserror13" class="val"  style="color:#F00; font-style:oblique;"></span>
                                          </td>
                                          
                                         
                                        </tr>-->
                                        <tr>
                                            <td>Company Name</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="store" class="store form-control form-align" id="store" value="<?= $val['store_name'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Contact Person</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="name" id="name"  class="name form-control form-align" value="<?= $val['name'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Payment Terms</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text"  name="payment_terms" class="form-control form-align"  id="payment_terms" value="<?= $val['payment_terms'] ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fw fa-money"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Bank Name</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?= $val['bank_name'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>

                                            <td>Bank Branch</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="branch" class="form-control form-align" id="branch" value="<?= $val['bank_branch'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-bank"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Email Id</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="mail" class="mail up_mail_dup form-control form-align" id="mail" value="<?= $val['email_id'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>IFSC Code</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="ifsc" class="form-control form-align" id="" value="<?= $val['ifsc'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fax"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Agent Name</td>
                                            <td>
                                                <select id='agent'  name="agent_name"  class="form-control form-align">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (isset($all_agent) && !empty($all_agent)) {
                                                        foreach ($all_agent as $va1) {
                                                            ?>
                                                            <option <?= ($val['agent_name'] == $va1['id']) ? 'selected' : '' ?> value='<?= $va1['id'] ?>'><?= $va1['name'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>                                                         
                                                </select> <span id="cuserror12" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </td>
                                            <td>Mobile Number</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="number" class="mobile form-control form-align" id="mobile" value="<?= $val['mobil_number'] ?>" />
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td>Address1</td>
                                            <td>
                                                <textarea  name='address1' id="address" class="form-control form-align"><?= $val['address1'] ?></textarea>
                                                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Address2</td>
                                            <td><textarea  name='address2' id="address" class="form-control form-align"><?= $val['address2'] ?></textarea></td>


                                            <td>Tin / Vat No</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-align"   name="tin" id="tin" value="<?= $val['tin'] ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror15" class="val"  style="color:#F00; font-style:oblique;"></span></td>

                                        </tr>
                                        <tr>
                                            <td>customer Type</td>
                                            <td>
                                                
                                                    <select id="customer_type" name="customer_type"  class="form-control form-align">
                                            <option value="">Select Type</option>
                                            <option value="1" <?php if($val['customer_type'] == 1) { echo "selected=selected";}else{echo '';}?>>Cash Customers</option>
                                            <option value="2" <?php if($val['customer_type'] == 2) { echo "selected=selected";}else{echo '';}?>>Credit Customers</option>
                                            <option value="3" <?php if($val['customer_type'] == 3) { echo "selected=selected";}else{echo '';}?>>Cash Contractor</option>
                                            <option value="4" <?php if($val['customer_type'] == 4) { echo "selected=selected";}else{echo '';}?>>Credit Contractor</option>
                                                    </select> 
                                                <span id="cust_type" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                                            
                                            <td>Selling Price</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-align"   name="sell_price" id="sell_price" value="<?= $val['sell_price'] ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <span id="sell_price1" class="val"  style="color:#F00; font-style:oblique;"></span></td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                            ?>
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <tr>
                                        <td width="570">&nbsp;</td>
                                        <td><input type="submit" value="Update" class="submit btn btn-info1" id="edit" /></td>
                                        <td>&nbsp;</td>
                                        <td><input type="reset" value="Clear" class="submit btn btn-danger1" id="reset" /></td>
                                        <td>&nbsp;</td>
                                        <td><a href="<?php echo $this->config->item('base_url') . 'customer/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                        <td>&nbsp;</td>
                                    </tr> 
                                </table>
                            </div>
                        </form>
                    </div>



                </div>

            </div>
        </div>
        <script type="text/javascript">
            $('#state_id').live('blur', function ()
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
            $('.state_id').live('blur', function ()
            {
                var state = $('.state_id').val();
                if (state == "37")
                {
                    $('#cuserror').html('<input type="text" name="state_id" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
                        <span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');
                }
            });

            $('#state').live('blur', function () {

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
            $("#store").live('blur', function ()
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
            $('#address').live('blur', function ()
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
            $("#mobile").live('blur', function ()
            {
                var number = $("#mobile").val();
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
            $('#bank').live('blur', function ()
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
            $('#percent').live('blur', function ()
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
            $('#city').live('blur', function ()
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
            $("#pincode").live('blur', function ()
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
            $("#branch").live('blur', function ()
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
            $("#acnum").live('blur', function ()
            {
                var acnum = $("#acnum").val();
                var acfilter = /^[a-zA-Z0-9]+$/;
                if (acnum == "")
                {
                    $("#cuserror11").html("Required Field");
                } else if (!acfilter.test(acnum))
                {
                    $("#cuserror11").html("Numeric or Alphanumeric");
                } else
                {
                    $("#cuserror11").html("");
                }
            });
            $('#agent').live('change', function ()
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
            $('#agent_comm').live('blur', function ()
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
            $("#payment_terms").live('blur', function ()
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
            $('#tin').live('blur', function ()
            {
                var tin = $('#tin').val();
                if (tin == "" || tin == null || tin.trim().length == 0)
                {
                    $('#cuserror15').html("Required Field");
                } else
                {
                    $('#cuserror15').html("");
                }
            });
             $('#customer_type').live('blur', function ()
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
            $('#sell_price').live('blur', function ()
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
            $('#c_cst').live('blur', function ()
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
            $('#c_vat').live('blur', function ()
            {
                var vat = $('#c_vat').val();
                if (vat == "")
                {
                    $("#c_vat").css('border-color', 'red');
                } else
                {
                    $("#c_vat").css('border-color', '');
                }
            });
            $('#reset').live('click', function ()
            {
                $('.val').html("");
            })
        </script>
        <script type="text/javascript">
            $('#edit').live('click', function ()
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
                var bank = $('#bank').val();
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
                }
                //	var percentage=$('#percent').val();
                //	var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
                //	if(percentage=="" || percentage==null || percentage.trim().length==0)
                //	{
                //		$('#cuserror7').html("Required Field");
                //		i=1;
                //	}
                //	else if(!pefilter.test(percentage))
                //	{
                //		$("#cuserror7").html("Enter Valid Percentage");
                //		i=1;
                //	}
                //	else
                //	{
                //		$('#cuserror7').html("");
                //	}

                //	var pincode=$("#pincode").val();
                //	if(pincode=="")
                //	{
                //		$("#cuserror9").html("Required Field");
                //		i=1;
                //	}
                //	else if (pincode.length!=6) 
                //    {
                //	    $("#cuserror9").html("Maximum 6 characters");
                //		i=1;	
                //    }
                //	else
                //	{
                //		$("#cuserror9").html("");
                //	}
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
                var acfilter = /^[a-zA-Z0-9]+$/;
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
                }
                var agent = $('#agent').val();
                if (agent == "")
                {
                    $('#cuserror12').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cuserror12').html("");
                }
                //	var agent_comm=$('#agent_comm').val();
                //	var apefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
                //	if(agent_comm=="" || agent_comm==null || agent_comm.trim().length==0)
                //	{
                //		$('#cuserror13').html("Required Field");
                //		i=1;
                //	}
                //	else if(!apefilter.test(agent_comm))
                //	{
                //		$("#cuserror13").html("Enter Valid Percentage");
                //		i=1;
                //	}
                //	else
                //	{
                //		$('#cuserror13').html("");
                //	}
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
                 var customer_type = $('#customer_type').val();
                if (tin == "" || tin == null || tin.trim().length == 0)
                {
                    $('#cuserror15').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cuserror15').html("");
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
                //	var cst=$('#c_cst').val();
                //	if(cst=="")
                //	{
                //		$("#c_cst").css('border-color','red');
                //		i=1;
                //	}
                //	else
                //	{
                //		$("#c_cst").css('border-color','');
                //	}
                //	var vat=$('#c_vat').val();
                //	if(vat=="")
                //	{
                //		$("#c_vat").css('border-color','red');
                //		i=1;
                //	}
                //	else
                //	{
                //		$("#c_vat").css('border-color','');
                //	}
                var mess = $("#upduplica").html();
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
            $("#mail").live('blur', function ()
            {
                //var fit=$(this).parent().parent().find('.up_fit').val();
                //var id=$(this).offsetParent().find('.id_dup').val();
                //var message=$(this).offsetParent().find('.upduplica');
                mail = $("#mail").val();
                id = $('.id').val();

                $.ajax(
                        {
                            url: BASE_URL + "customer/update_duplicate_email",
                            type: 'POST',
                            data: {value1: mail, value2: id},
                            success: function (result)
                            {
                                $("#upduplica").html(result);
                            }
                        });
            });
        </script> 
