<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
        <h4>Update Firm</h4>
    </div>
    <div class="contentpanel">
        <div class="panel-body">
            <div class="tabs">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="update-field">
                        <!-- <h4 align="center" class="sup-align">Update Product</h4>-->
                        <form action="<?php echo $this->config->item('base_url') . 'manage_firms/update_firm/'.$firms[0]['firm_id']?>" enctype="multipart/form-data" name="form" method="post"> 
                            <table class="table table-striped responsive no-footer dtr-inline">                                
                            <?php
                            if (isset($firms) && !empty($firms)) {
                                $i = 0;
                                foreach ($firms as $val) {                                   
                                    $i++
                                    ?>
                                <tr>
                                <td width="12%">Firm/Company Name</td>
                                <td width="18%">
                                    <div class="input-group">
                                        <input type="text" name="firm_name" class="form-control form-align frim_name"  id="frim_name" value="<?php echo $val['firm_name'];?>" org_name="<?php echo $val['firm_name']; ?>"/> 
                                        <input type="hidden" id='firm_id' value="<?php echo $val['firm_id'];?>"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="frim_name_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    <span id="dup" class="dup" style="color:#F00; font-style:oblique;"></span>
                                </td>
                                <td width="12%">Contact Person</td>
                                <td width="18%">
                                    <div class="input-group">
                                        <input type="text" name="contact_person" class=" form-control form-align" id="contact_persson"  value="<?php echo $val['contact_person'];?>"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <span id="contact_persson_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>                      
                            </tr>                                
                            <tr>
                                <td width="12%">Mobile Number</td>
                                <td width="18%">
                                    <div class="input-group">
                                        <input type="text" name="mobile_number" class=" form-control form-align" id="mobile_number" value="<?php echo $val['mobile_number'];?>"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-fw fa-money"></i>
                                        </div>
                                    </div>
                                    <span id="mobile_number_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>   
                                <td width="12%">Email_id</td>
                                <td width="18%">
                                    <div class="input-group">
                                        <input type="text" name="email_id" class=" form-control form-align" id="email_id" value="<?php echo $val['email_id'];?>"/>
                                        <div class="input-group-addon">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <span id="email_id_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>   
                            </tr>
                            <tr>
                                <td width="12%">Pin Code</td>
                                <td width="18%">
                                    <div class="input-group">
                                        <input type="text" name="pincode" class="form-control form-align" id="pin_code" value="<?php echo $val['pincode'];?>"/> 
                                        <div class="input-group-addon">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>                           
                                    <span id="pin_code_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td>  
                                <td width="12%">Address</td>
                                <td width="18%">
                                    <textarea name="address"  class=" form-control form-align" id="address"><?php echo $val['address'];?></textarea> 
                                    <span id="address_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                </td> 
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            </table>
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <td width="540">&nbsp;</td>
                                    <td><input type="submit" name="submit" class="btn btn-success" value="Update" id="submit" /></td>
                                    <td>&nbsp;</td>
                                    <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td><td>&nbsp;</td> 
                                    <td><a href="<?php echo $this->config->item('base_url') . 'manage_firms/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                </table>  
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
            
        $("#frim_name").live('blur', function ()
        {
            var name = $("#frim_name").val();
            if (name == "" || name == null || name.trim().length == 0)
            {
                $("#frim_name_err").html("Required Field");
            } else
            {
                $("#frim_name_err").html("");
            }
        });
        $("#contact_persson").live('blur', function ()
        {
            var contact_persson = $("#contact_persson").val();
            if (contact_persson == "" || contact_persson == null || contact_persson.trim().length == 0)
            {
                $("#contact_persson_err").html("Required Field");
            } else
            {
                $("#contact_persson_err").html("");
            }
        });
    
        $("#mobile_number").live('blur', function ()
        {
            var mobile_number = $("#mobile_number").val();
            if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)
            {
                $("#mobile_number_err").html("Required Field");
            } else
            {
                $("#mobile_number_err").html("");
            }
        });

        $("#email_id").live('blur', function ()
        {
            var email_id = $("#email_id").val();
            if (email_id == "" || email_id == null || email_id.trim().length == 0)
            {
                $("#email_id_err").html("Required Field");
            } else
            {
                $("#email_id_err").html("");
            }
        });
        
        $("#pin_code").live('blur', function ()
        {
            var pin_code = $("#pin_code").val();
            if (pin_code == "" || pin_code == null || pin_code.trim().length == 0)
            {
                $("#pin_code_err").html("Required Field");
            } else
            {
                $("#pin_code_err").html("");
            }
        });
        
        $("#address").live('blur', function ()
        {
            var address = $("#address").val();
            if (address == "" || address == null || address.trim().length == 0)
            {
                $("#address_err").html("Required Field");
            } else
            {
                $("#address_err").html("");
            }
        });
       
       
        $('#reset').live('click', function ()
        {
            $('.val').html("");
            $('#dup').html("");
        });
</script>
<script type="text/javascript">    
    $('#submit').live('click', function ()
        {
            frim_name = $.trim($("#frim_name").val());
            id = $('#firm_id').val();
            $.ajax(
                    {
                        url: BASE_URL + "manage_firms/update_duplicate_firm",
                        type: 'get',
                        async: false,
                        data: {value1: frim_name,value2:id},
                        success: function (result)
                        {
                            if ($('#frim_name').attr('org_name') != frim_name)
                            $("#dup").html(result);
                        }
                    });
            var i = 0;
            var contact_persson = $("#contact_persson").val();
            if (contact_persson == "" || contact_persson == null || contact_persson.trim().length == 0)
            {
                $("#contact_persson_err").html("Required Field");
                i = 1;
            } else
            {
                $("#contact_persson_err").html("");
            }

            var name = $("#frim_name").val();
            if ($('#dup').html() == 'Firm Name Already Exist')
            {
                i = 1;
            } else if (name == "" || name == null || name.trim().length == 0)
            {
                $("#frim_name_err").html("Required Field");
                i = 1;
            } else
            {
                $("#frim_name_err").html("");
            }


            var mobile_number = $("#mobile_number").val();
            if (mobile_number == "" || mobile_number == null || mobile_number.trim().length == 0)
            {
                $("#mobile_number_err").html("Required Field");
                i = 1;
            } else
            {
                $("#mobile_number_err").html("");
            }
            var email_id = $("#email_id").val();
            if (email_id == "" || email_id == null || email_id.trim().length == 0)
            {
                $("#email_id_err").html("Required Field");
                i = 1;
            } else
            {
                $("#email_id_err").html("");
            }
         
            var pin_code = $('#pin_code').val();
            if (pin_code == "")
            {
                $('#pin_code_err').html("Required Field");
                i = 1;
            } else
            {
                $('#pin_code_err').html("");
            }

            var address = $('#address').val();
            if (address == "")
            {
                $('#address_err').html("Required Field");
                i = 1;
            } else
            {
                $('#address_err').html("");
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
        $("#frim_name").live('blur', function ()
        {
            frim_name = $.trim($("#frim_name").val());
            id = $('#firm_id').val();
            $.ajax(
            {
                url: BASE_URL + "manage_firms/update_duplicate_firm",
                type: 'get',
                async: false,
                data: {value1: frim_name,value2:id},
                success: function (result)
                {
                    if ($('#frim_name').attr('org_name') != frim_name)
                        $("#dup").html(result);
                }
            });
        });
    </script>            
