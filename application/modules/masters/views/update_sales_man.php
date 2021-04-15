<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style>

    .input-group-addon .fa { width:10px !important; }

</style>

<div class="mainpanel">

    <div class="media">

    </div>

    <div class="contentpanel mb-45">

        <div class="media mt--2">

            <h4>Update Sales man</h4>

        </div>

        <div class="panel-body">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#update-sales-man" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Update List</a></li>

                </ul>



                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane active" id="update-sales-man">



                        <form  method="POST" id="sales_man_form"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'masters/sales_man/update_sales_man'; ?>">

                            <table  class="table table-striped  responsive no-footer dtr-inline">

                                <?php

                                if (isset($sales_man) && !empty($sales_man)) {



                                    $i = 1;

                                    foreach ($sales_man as $val) {

                                        $i++;

                                        ?>

                                        <tr>

                                        <input type="hidden" name="id" class="id id_dup form-control form-align" readonly="readonly" value="<?php echo $val['id']; ?>" />

                                        <td width="12%">Firm Name</td>

                                        <td width="18%">

                                            <select name="firm_id"  class="form-control form-align" id="firm" >

                                                <?php

                                                if (isset($firms) && !empty($firms)) {

                                                    foreach ($firms as $firm) {

                                                        ?>

                                                        <option <?php echo ($firm['firm_id'] == $val['firm_id']) ? 'selected' : '' ?> value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>

                                                        <?php

                                                    }

                                                }

                                                ?>

                                            </select>

                                            <span id="firm_err" class="val"  style="color:#F00; font-style:oblique;"></span>

                                        </td>

                                        <td>Name</td>

                                        <td>

                                            <div class="input-group">

                                                <input type="text" name="sales_man_name" id="sales_man_name"  class="name form-control form-align" value="<?= $val['sales_man_name'] ?>" />

                                                <div class="input-group-addon">

                                                    <i class="fa fa-phone"></i>

                                                </div>

                                            </div>

                                            <span id="contact_personerr" class="val"  style="color:#F00; font-style:oblique;"></span>

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

                                            <td>Address</td>

                                            <td>

                                                <textarea  name='address1' id="address" class="form-control form-align"><?php echo $val['address1']; ?></textarea>

                                                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </td>

                                            <td>Mobile Number</td>

                                            <td>

                                                <div class="input-group">

                                                    <input type="text" name="number" class="mobile form-control form-align" id="mobile" maxlength="10"value="<?php echo $val['mobil_number']; ?>" />

                                                    <div class="input-group-addon">

                                                        <i class="fa fa-phone"></i>

                                                    </div>

                                                </div>

                                                <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </td>



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

                                        </tr>

                                        <tr>

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

                                            <td>IFSC Code</td>

                                            <td>

                                                <div class="input-group">

                                                    <input type="text" name="ifsc" class="form-control form-align" id="" value="<?= $val['ifsc'] ?>" />

                                                    <div class="input-group-addon">

                                                        <i class="fa fa-fax"></i>

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                        <tr>



                                            <td>Target Rate / Year</td>

                                            <td>

                                                <div class="input-group">

                                                    <input type="number" name="target_rate" class="store form-control form-align" id="target_rate" value="<?php echo $val['target_rate'] ?>"/>

                                                    <div class="input-group-addon">

                                                        <i class="fa fa-bank"></i>

                                                    </div>

                                                </div>

                                                <span id="cuserror14" class="val"  style="color:#F00; font-style:oblique;"></span>

                                            </td>

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

                                        <td><input type="button" value="Update" class="submit btn btn-info1" id="edit" /></td>

                                        <td>&nbsp;</td>

                                        <td><input type="reset" value="Clear" class="submit btn btn-danger1" id="reset" /></td>

                                        <td>&nbsp;</td>

                                        <td><a href="<?php echo $this->config->item('base_url') . 'masters/sales_man' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>

                                        <td>&nbsp;</td>

                                    </tr>

                                </table>

                            </div>

                        </form>

                    </div>







                </div>



            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

    $('document').ready(function ()

    {

        $("#sales_man_name").on('blur', function ()

        {

            var name = $("#sales_man_name").val();

            var filter = /^[a-zA-Z.\s]{3,30}$/;

            if (name == "" || name == null || name.trim().length == 0)

            {

                $("#contact_personerr").html("Required Field");

            } else if (!filter.test(name))

            {

                $("#contact_personerr").html("Alphabets and Min 3 to Max 30 ");

            } else

            {

                $("#contact_personerr").html("");

            }

        });

         $("#target_rate").on('blur', function ()

        {

            var target_rate = $("#target_rate").val();

            if (target_rate == "" || target_rate == null || target_rate.trim().length == 0)

            {

                $("#cuserror14").html("Required Field");

                i = 1;

            }
            if (target_rate.length != 4){

                $("#cuserror14").html("Invalid Format");

                i = 1;
            }
            if (!target_rate.match(/\d{4}/)){

                $("#cuserror14").html("Invalid Format");

                i = 1;
            } 
            var _thisYear = new Date().getFullYear();
            if (parseInt(target_rate) > _thisYear || parseInt(target_rate) < 1900)
            {
            $("#cuserror14").html("Invalid Format");

            i = 1;
            }else

            {

                $("#cuserror14").html("");

            }

        });

        $("#mail").on('blur', function ()

        {

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

        });

        $("#moblie").keydown(function (e) {

            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||

                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||

                    (e.keyCode >= 35 && e.keyCode <= 40)) {



                return;

            }

            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

                e.preventDefault();

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

            }

        });

        $('#address').on('blur', function ()

        {

            var address = $('#address').val();

            if (address == "" || address == null || address.trim().length == 0)

            {

                $('#cuserror3').html("Enter Address");
                 i = 1;

            } else

            {

                $('#cuserror3').html("");

            }

        });

        $("#mobile").on('blur', function ()

        {

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

        });

            $("#mobile").keyup(function ()

    {

        var number = $("#mobile").val();

//        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));

        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (number == "")

        {

            $("#cuserror4").text("Required Field");
             i = 1;

        } else if (!nfilter.test(number))

        {

            $("#cuserror4").text("Enter Valid Mobile Number");
             i = 1;

        } else

        {

            $("#cuserror4").text("");

        }

    });



        $('#bank').on('blur', function ()

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



        $('#reset').on('click', function ()

        {

            $('.val').html("");

        });



        $('#edit').on('click', function ()

        {

            var i = 0;

            var name = $("#sales_man_name").val();

            var filter = /^[a-zA-Z.\s]{3,30}$/;

            if (name == "" || name == null || name.trim().length == 0)

            {

                $("#contact_personerr").html("Required Field");

                i = 1;

            } else if (!filter.test(name))

            {

                $("#contact_personerr").html("Alphabets and Min 3 to Max 30 ");

                i = 1;

            } else

            {

                $("#contact_personerr").html("");

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



            var address = $('#address').val();

            if (address == "" || address == null || address.trim().length == 0)

            {

                $('#cuserror3').html("Enter Address");

                i = 1;

            } else

            {

                $('#cuserror3').html("");

            }

             var mobile_number = $("#mobile").val();

             var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

            if (mobile_number == "")

            {

                $("#cuserror4").text("Required Field");

                 i = 1;

            } else if (!nfilter.test(mobile_number))

            {

                $("#cuserror4").text("Enter Valid Mobile Number");

                i = 1;

            } else

            {

                $("#cuserror4").text("");

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

            var branch = $("#branch").val();

            if (branch == "" || branch == null || branch.trim().length == 0)

            {

                $("#cuserror10").html("Required Field");

                i = 1;

            } else

            {

                $("#cuserror10").html("");

            }


            var target_rate = $("#target_rate").val();



            if (target_rate == "")

            {

                $("#cuserror14").html("Required Field");

                i = 1;

            } 
            if (target_rate.length != 4){

                $("#cuserror14").html("Invalid Format");

                i = 1;
            }
            if (!target_rate.match(/\d{4}/)){

                $("#cuserror14").html("Invalid Format");

                i = 1;
            }
             var _thisYear = new Date().getFullYear();
            if (parseInt(target_rate) > _thisYear || parseInt(target_rate) < 1900)
            {
            $("#cuserror14").html("Invalid Format");

            i = 1;
            }
            else

            {

                $("#cuserror14").html("");

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



            if (i == 1)

            {

                return false;

            } else
            {
               
                $('#sales_man_form').submit();
                return true;

            }


        });

        $("#mail").on('blur', function ()

        {

            mail = $("#mail").val();

            id = $('.id').val();

            $.ajax(

                    {

                        url: BASE_URL + "masters/sales_man/update_duplicate_email",

                        type: 'POST',

                        data: {value1: mail, value2: id},

                        success: function (result)

                        {

                            $("#upduplica").html(result);

                        }

                    });

        });

    });

</script>