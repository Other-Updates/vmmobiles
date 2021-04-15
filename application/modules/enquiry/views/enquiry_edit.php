<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>

<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;  
    }
    .btn-info { background-color:#3db9dc;border-color: #3db9dc;color:#fff;  }
    .btn-info:hover { background-color:#25a7cb; }
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">      
    <div class="media">
        <h4>Add Enquiry List</h4>
    </div>
    <div class="contentpanel panel-body ">

        <div class="tab-content1 tabpad1">
            <!--<h4 align="center" class="sup-align updateen">Update Enquiry</h4>-->
            <?php
            if (isset($all_enquiry) && !empty($all_enquiry)) {
                foreach ($all_enquiry as $val) {
                    ?>
                    <form action="<?php echo $this->config->item('base_url'); ?>enquiry/update_enquiry/<?php echo $val['id']; ?>" enctype="multipart/form-data" name="form" method="post"> 
                        <table class="table table-striped  responsive no-footer dtr-inline twidth-65">
                            <tr>
                                <td>Enquiry Number</td>
                                <td>
                                    <input type="text" name="enquiry_no" value="<?php echo $val['enquiry_no']; ?>" class=" form-control form-align" id="user_name" readonly/>
                                    <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>  
                                <td>Customer Name</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="customer_name"  value="<?php echo $val['customer_name']; ?>" class="form-control form-align" id="name" > 
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>    
                            </tr>
                            <tr>
                                <td>Customer Email</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="customer_email" value="<?php echo $val['customer_email']; ?>" class="mail form-control email_dup form-align" id="mail" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                    </div>
                                    <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td> 

                                <td>Enquiry About</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="enquiry_about" value="<?php echo $val['enquiry_about']; ?>" class="number form-control form-align" id="enquiry_about" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="cuserror_enquiry_about" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>   
                            </tr>
                            <tr>
                                <td>Followup Date</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="followup_date" class="datepicker1 form-control form-align" id="date"  value="<?php echo $val['followup_date']; ?>"  />
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <span id="date1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>

                                <td>Contact Number</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="contact_number"  class="form-control form-align" id="number" value="<?php echo $val['contact_number']; ?>" > 
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                    </div>
                                    <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>  

                            </tr> 
                            <tr>

                                <td>Remarks</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="remarks" value="<?php echo $val['remarks']; ?>" class="number form-control form-align" id="remarks" />
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="cuserror_remarks" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>
                                <td>Status</td>
                                <td>
                                    <select class='form-control form-align' name='status' id='status'>
                                        <option value="<?php echo $val['status']; ?>"> <?php echo $val['status']; ?> </option>       
                                        <option value='Pending'>Pending</option>  
                                        <option value='Completed'>Completed</option>
                                        <option value='Reject'>Rejected</option>
                                    </select>
                                    <span id="status1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>    
                            </tr> 
                            <tr>
                                <td>Customer Address</td>
                                <td>
                                    <textarea name="customer_address"   id="address" class="form-control form-align"> <?php echo $val['customer_address']; ?> </textarea>
                                    <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>

                            </tr> 
                        </table>

                        <div class="frameset_table action-btn-align">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="530">&nbsp;</td>
                                        <td><input type="submit" value="Update" class="submit btn btn-info right" id="edit" autocomplete="off"></td>
                                        <td>&nbsp;</td>
                                        <td> <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list/' ?>" class="btn btn-defaultback "><span class="glyphicon"></span> Back </a></td>
                                        <td>&nbsp;</td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        <?php
        }
    }
    ?>
    <br />
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery('.datepicker1').datepicker({dateFormat: 'dd-mm-yy',
                todayHighlight: true});
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
        $("#date").live('blur', function ()
        {
            var date = $("#date").val();

            if (date == "" || date == null || date.trim().length == 0)
            {
                $("#date1").html("Required Field");
            } else
            {
                $("#date1").html("");
            }
        });
        $("#status").live('blur', function ()
        {
            var date = $("#status").val();

            if (date == "" || date == null || date.trim().length == 0)
            {
                $("#status1").html("Required Field");
            } else
            {
                $("#status1").html("");
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
        $('#remarks').live('blur', function ()
        {
            var bank = $('#remarks').val();
            if (bank == "" || bank == null || bank.trim().length == 0)
            {
                $('#cuserror_remarks').html("Required Field");
            } else
            {
                $('#cuserror_remarks').html("");
            }
        });
        $('#enquiry_about').live('blur', function ()
        {
            var bank1 = $('#enquiry_about').val();
            if (bank1 == "" || bank1 == null || bank1.trim().length == 0)
            {
                $('#cuserror_enquiry_about').html("Required Field");
            } else
            {
                $('#cuserror_enquiry_about').html("");
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

            var date = $("#date").val();

            if (date == "" || date == null || date.trim().length == 0)
            {
                $("#date1").html("Required Field");
                i = 1;
            } else
            {
                $("#date1").html("");
            }
            var status = $('#status').val();
            if (status == "" || status == null || status.trim().length == 0)
            {
                $('#status1').html("Required Field");
                i = 1;
            } else
            {
                $('#status1').html("");
            }
            var bank = $('#remarks').val();
            if (bank == "" || bank == null || bank.trim().length == 0)
            {
                $('#cuserror_remarks').html("Required Field");
                i = 1;
            } else
            {
                $('#cuserror_remarks').html("");
            }

            var bank1 = $('#enquiry_about').val();
            if (bank1 == "" || bank1 == null || bank1.trim().length == 0)
            {
                $('#cuserror_enquiry_about').html("Required Field");
                i = 1;
            } else
            {
                $('#cuserror_enquiry_about').html("");
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

            var address = $('#address').val();
            if (address == "" || address == null || address.trim().length == 0)
            {
                $('#cuserror3').html("Required Field");
                i = 1;
            } else
            {
                $('#cuserror3').html("");
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
                        url: BASE_URL + "enquiry/add_duplicate_email",
                        type: 'get',
                        data: {value1: email},
                        success: function (result)
                        {
                            $("#duplica").html(result);
                        }
                    });
        });
    </script>
