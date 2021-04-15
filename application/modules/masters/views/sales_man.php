<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!-- <script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

<style>
    .input-group-addon .fa {
        width: 10px !important;
    }

    table tr td:nth-child(4) {
        text-align: center;
    }

    table tr td:nth-child(5) {
        text-align: center;
    }
</style>

<div class="mainpanel">

    <div class="media">



    </div>

    <div class="contentpanel">

        <div class="media mt--2">

            <h4>Sales Man Details</h4>

        </div>

        <div class="panel-body  mb-25">

            <div class="tabs">

                <!-- Nav tabs -->

                <ul class="list-inline tabs-nav tabsize-17" role="tablist">



                    <li role="presentation" class="active"><a href="#sales_man_list" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Sales Man List</a></li>

                    <li role="presentation" class=""><a href="#add_sales_man" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Sales Man</a></li>

                </ul>

                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane" id="add_sales_man">

                        <form action="<?php echo $this->config->item('base_url'); ?>masters/sales_man/insert_sales_man" enctype="multipart/form-data" name="form" method="post">

                            <table class="table table-striped responsive no-footer dtr-inline">

                                <tr>

                                    <td width="12%">Shop Name</td>

                                    <td width="18%">

                                        <select name="firm_id" class="form-control form-align" id="firm">

                                            <?php
                                            echo count($firms);

                                            if (count($firms) > 1)
                                                echo '<option value="">Select</option>';

                                            if (isset($firms) && !empty($firms)) {

                                                foreach ($firms as $key => $firm) {
                                                    $select = '';
                                                    if ($key == 0) {
                                                        $select = "selected";
                                                    }
                                            ?>

                                                    <option <?php echo $select; ?> value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>

                                            <?php
                                                }
                                            }
                                            ?>

                                        </select>

                                        <span id="firm_err" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>Name<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="sales_man_name" class="name form-control form-align" id="sales_man_name" maxlength="15" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-phone"></i>

                                            </div>

                                        </div>

                                        <span id="contact_personerr" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>Email Id<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="mail" class="mail form-control email_dup form-align" id="mail" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-envelope"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror5" class="val" style="color:#F00; font-style:oblique;"></span>

                                        <span id="duplica" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                                <tr>

                                    <td>Address<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <textarea name="address1" id="address" class="form-control form-align"></textarea>

                                        <span id="cuserror3" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>Mobile Number <span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="number" class="number form-control form-align" id="number" maxlength="10" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-phone"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror4" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>Bank Name<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="bank" class="form-control form-align" id="bank" maxlength="40" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-bank"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror6" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                                <tr>

                                    <td>Bank Branch<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="branch" class="form-control form-align" id="branch" maxlength="40" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-bank"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror10" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>Account No<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="acnum" class="form-control form-align" id="acnum" maxlength="20" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-user"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror11" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                    <td>IFSC Code<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="text" name="ifsc" class="form-control form-align" id="ifsc" maxlength="12" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-fax"></i>

                                            </div>

                                        </div>

                                        <span id="ifsc1" class="val" style="color:#F00; font-style:oblique;"></span>



                                    </td>

                                </tr>

                                <tr>



                                    <td>Target Rate / Year<span style="color:#F00; font-style:oblique;">*</span></td>

                                    <td>

                                        <div class="input-group">

                                            <input type="number" name="target_rate" class="store form-control form-align" id="target_rate" />

                                            <div class="input-group-addon">

                                                <i class="fa fa-bank"></i>

                                            </div>

                                        </div>

                                        <span id="cuserror14" class="val" style="color:#F00; font-style:oblique;"></span>

                                    </td>

                                </tr>

                            </table>





                            <div class="frameset_table action-btn-align">

                                <table>

                                    <tr>

                                        <td width="570">&nbsp;</td>

                                        <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>

                                        <td>&nbsp;</td>

                                        <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td>
                                        <td>&nbsp;</td>

                                        <td><a href="<?php echo $this->config->item('base_url') . 'masters/sales_man' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>

                                    </tr>

                                </table>

                            </div>

                        </form>

                    </div>

                    <div role="tabpanel" class="tab-pane active tablelist" id="sales_man_list">

                        <div class="frameset_big1">

                            <!--<h4 align="center" class="sup-align">Customer Details</h4>-->

                            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline target-cntr" id="list">

                                <thead>

                                    <th width='5%' class="action-btn-align">S.No</th>

                                    <th width='20%' class="action-btn-align">Shop Name</th>

                                    <th width='10%' class="action-btn-align">Sales Man Name</th>

                                    <th width='15%' class="action-btn-align">Email Id</th>

                                    <th width='10%' class="action-btn-align">Mobile Number</th>

                                    <th width='10%' class="action-btn-align">Target Rate</th>

                                    <th width='10%' class="action-btn-align">Action</th>

                                </thead>

                                <tbody>

                                    <?php
                                    if (isset($sales_man) && !empty($sales_man)) {

                                        $i = 0;

                                        foreach ($sales_man as $val) {



                                            $i++;
                                    ?>

                                            <tr>

                                                <td class="first_td"><?php echo "$i"; ?></td>

                                                <td><?= $val['firm_name'] ?></td>

                                                <td><?php echo $val['sales_man_name']; ?></td>

                                                <td><?php echo $val['email_id']; ?></td>

                                                <td><?php echo $val['mobil_number']; ?></td>

                                                <td><?php echo $val['target_rate']; ?></td>

                                                <td class="action-btn-align">

                                                    <a href="<?php echo $this->config->item('base_url') . 'masters/sales_man/edit_sales_man/' . $val['id']; ?>" class="tooltips btn btn-default btn-xs" title="Edit"><span class="fa fa-edit"></span></a>&nbsp;

                                                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-default btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>

                                                </td>

                                            </tr>

                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<br />

<?php $base_url = $this->config->item('base_url'); ?>

<script type="text/javascript">
    $('document').ready(function()

        {

            $("#sales_man_name").on('blur', function()

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



            $("#mail").on('blur', function()

                {

                    var mail = $("#mail").val();

                    var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

                    if (mail == "")

                    {

                        $("#cuserror5").html("Required Field");

                    } else if (!efilter.test(mail) && mail != "")

                    {

                        $("#cuserror5").html("Enter Valid Email");

                    } else

                    {

                        $("#cuserror5").html("");

                    }

                });

            $('#address').on('blur', function()

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

            $("#number").keydown(function(e) {

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 40)) {



                    return;

                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

                    e.preventDefault();

                }

            });

            $("#number").keyup(function()

                {

                    var number = $("#number").val();

                    //        $(this).val($(this).val().replace(/[^0-9\.]/g, ""));

                    var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

                    if (number == "")

                    {

                        $("#cuserror4").text("Required Field");

                    } else if (!nfilter.test(number))

                    {

                        $("#cuserror4").text("Enter Valid Mobile Number");

                    } else

                    {

                        $("#cuserror4").text("");

                    }

                });

            $("#acnum").keydown(function(e) {

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    (e.keyCode >= 35 && e.keyCode <= 40)) {



                    return;

                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

                    e.preventDefault();

                }

            });





            $('#bank').on('blur', function()

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

            $("#number").on('blur', function()

                {

                    var mobile_number = $("#number").val();

                    if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)

                    {

                        $("#cuserror4").html("Required Field");

                        i = 1;

                    } else

                    {

                        $("#cuserror4").html("");

                    }

                });

            $("#target_rate").on('blur', function()

                {

                    var target_rate = $("#target_rate").val();

                    if (target_rate == "" || target_rate == null || target_rate.trim().length == 0)

                    {

                        $("#cuserror14").html("Required Field");

                        i = 1;

                    }
                    if (target_rate.length != 4) {

                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    }
                    if (!target_rate.match(/\d{4}/)) {

                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    }
                    var _thisYear = new Date().getFullYear();
                    if (parseInt(target_rate) > _thisYear || parseInt(target_rate) < 1900) {
                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    } else

                    {

                        $("#cuserror14").html("");

                    }

                });



            $("#branch").on('blur', function()

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

            $("#acnum").on('blur', function()

                {

                    var acnum = $("#acnum").val();

                    if (acnum == "" || acnum == null || acnum.trim().length == 0)

                    {

                        $("#cuserror11").html("Required Field");

                    } else

                    {

                        $("#cuserror11").html("");

                    }

                });

            $('#reset').on('click', function()

                {

                    $('.val').html("");

                });



            $('#submit').on('click', function()

                {

                    var i = 0;

                    var mobile_number = $("#number").val();

                    var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

                    if (mobile_number == "")

                    {

                        $("#cuserror4").text("Required Field");

                        m = 1;

                    } else if (!nfilter.test(mobile_number))

                    {

                        $("#cuserror4").text("Enter Valid Mobile Number");

                        m = 1;

                    } else

                    {

                        $("#cuserror4").text("");

                    }

                    var acnum = $("#acnum").val();

                    if (acnum == "" || acnum == null || acnum.trim().length == 0)

                    {

                        $("#cuserror11").html("Required Field");

                        i = 1;

                    } else

                    {

                        $("#cuserror11").html("");

                    }

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

                    var mail = $('#mail').val();

                    var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

                    if (mail == "")

                    {

                        $("#cuserror5").text("MailID is required");

                        i = 1;

                    } else if (mail != "" && !efilter.test(mail)) {

                        $("#cuserror5").text('Enter Valid Email');

                        i = 1;

                    } else

                    {

                        $("#cuserror5").text('');

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





                    var ifsc = $('#ifsc').val();

                    var ifscformat = /[A-Z|a-z]{4}[0][a-zA-Z0-9]{6}$/;

                    if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)

                    {

                        $('#ifsc1').html("");

                        i = 1;

                    } else if (ifsc != "" && !ifscformat.test(ifsc)) {

                        $("#ifsc1").text('Enter Valid IFSC Code');

                        i = 1;

                    } else

                    {

                        $("#ifsc1").text('');

                    }





                    var bank = $('#bank').val();

                    if (bank == "" || bank == null || bank.trim().length == 0)

                    {

                        $('#cuserror6').html("Required Field");

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

                    var ifsc = $("#ifsc").val();

                    if (ifsc == "" || ifsc == null || ifsc.trim().length == 0)

                    {

                        $("#ifsc1").html("Required Field");

                        i = 1;

                    } else

                    {

                        $("#ifsc1").html("");

                    }



                    var target_rate = $("#target_rate").val();



                    if (target_rate == "")

                    {

                        $("#cuserror14").html("Required Field");

                        i = 1;

                    }
                    if (target_rate.length != 4) {

                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    }
                    if (!target_rate.match(/\d{4}/)) {

                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    }
                    var _thisYear = new Date().getFullYear();
                    if (parseInt(target_rate) > _thisYear || parseInt(target_rate) < 1900) {
                        $("#cuserror14").html("Invalid Format");

                        i = 1;
                    } else

                    {

                        $("#cuserror14").html("");

                    }

                    if (i == 1)

                    {

                        return false;

                    } else

                    {

                        return true;

                    }





                });





            $(".email_dup").on('blur', function()

                {

                    email = $("#mail").val();

                    $.ajax({
                        url: BASE_URL + "masters/sales_man/add_duplicate_email",
                        type: 'get',
                        data: {
                            value1: email
                        },
                        success: function(result)

                        {

                            //$("#duplica").html(result);

                        }

                    });

                });

        });
</script>







<?php
if (isset($sales_man) && !empty($sales_man)) {

    foreach ($sales_man as $val) {
?>

        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

            <div class="modal-dialog">

                <div class="modal-content modalcontent-top">

                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>



                        <h3 id="myModalLabel" class="inactivepop">In-Active Sales Man</h3>

                    </div>

                    <div class="modal-body">

                        Do You Want In-Active This Sales Man? </strong>

                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />

                    </div>

                    <div class="modal-footer action-btn-align">

                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>

                        <button type="button" class="btn btn-danger1 delete_all" data-dismiss="modal" id="no">No</button>

                    </div>

                </div>

            </div>

        </div>

<?php
    }
}
?>







<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">

    <div class="modal-dialog">

        <div class="modal-content">

            <a class="close1" data-dismiss="modal">×</a>

            <div class="modal-body">

                <img src="" width="50%" />

                <!-- <img src="<?php echo $this->config->item('base_url') . '/cust_image/thumb/' . $val['cus_image']; ?>" width="50%" />-->

            </div>

        </div>

    </div>

</div>





<script type="text/javascript">
    $(document).ready(function()

        {

            $("#yesin").on("click", function()

                {



                    var hidin = $(this).parent().parent().find('.id').val();

                    // alert(hidin);



                    $.ajax({
                        url: BASE_URL + "masters/sales_man/delete_sales_man",
                        type: 'POST',
                        data: {
                            value1: hidin
                        },
                        success: function(result) {



                            window.location.reload(BASE_URL + "sales_man/");

                        }

                    });



                });



            $('.modal').css("display", "none");

            $('.fade').css("display", "none");



        });
</script>