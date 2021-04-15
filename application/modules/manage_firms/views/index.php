<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
        <h4>Firms / Company  Details</h4>
    </div>
    <div class="contentpanel mb-40">
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#field-agent-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Firms List</a></li>
                    <li role="presentation" class=""><a href="#field-agent" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Firm</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="field-agent">
                        <!-- <h4 align="center" class="sup-align">Add Product</h4>-->
                        <form action="<?php echo $this->config->item('base_url'); ?>manage_firms/insert_firms" enctype="multipart/form-data" name="form" method="post"> 
                            <table class="table table-striped responsive no-footer dtr-inline">
                                <tr>
                                    <td width="12%">Firm/Company Name</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="firm_name" class="form-control form-align frim_name"  id="frim_name" /> 
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
                                            <input type="text" name="contact_person" class=" form-control form-align" id="contact_persson" />
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
                                            <input type="text" name="mobile_number" class=" form-control form-align" id="mobile_number" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-fw fa-money"></i>
                                            </div>
                                        </div>
                                        <span id="mobile_number_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>   
                                    <td width="12%">Email_id</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="email_id" class=" form-control form-align" id="email_id" />
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
                                            <input type="text" name="pincode" class="form-control form-align" id="pin_code"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="pin_code_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Address</td>
                                    <td width="18%">
                                        <textarea name="address"  class=" form-control form-align" id="address"></textarea>                           
                                        <span id="address_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td> 
                                </tr>
                            
                            </table>
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <td width="540">&nbsp;</td>
                                    <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>
                                    <td>&nbsp;</td>
                                    <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td><td>&nbsp;</td>
                                    <td><a href="<?php echo $this->config->item('base_url') . 'manage_firms/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="field-agent-details">
                        <div class="frameset_big1">

                            <!-- <h4 align="center" class="sup-align">Products Details</h4>-->
                            <table id="basicTable"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="list">
                                <thead>
                                <th class='action-btn-align'>S.No</th>
                                <th>Firm/Company Name</th>
                                <th>Contact Person</th>
                                <th>Mobile Number</th>
                                <th>Email ID</th> 
                                <th>Pin Code</th> 
                                <th>Address</th> 
                                <th class="action-btn-align">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($firms) && !empty($firms)) {
                                        $i = 0;
                                        foreach ($firms as $val) {
                                            $i++
                                            ?>
                                            <tr>
                                                <td class="first_td action-btn-align"><?php echo "$i"; ?></td>
                                                <td><?= $val['firm_name'] ?></td>
                                                <td><?= $val['contact_person'] ?></td>
                                                <td><?= $val['mobile_number'] ?></td>                                              
                                                <td><?= $val['email_id'] ?></td>
                                                <td><?= $val['pincode'] ?></td>
                                                <td><?= $val['address'] ?></td>
                                                <td class="action-btn-align">
                                                    <a href="<?= $this->config->item('base_url') . 'manage_firms/edit_firm/' . $val['firm_id'] ?>" class="tooltips btn btn-info btn-xs" title="Edit">
                                                        <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $val['firm_id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active">
                                                        <span class="fa fa-ban"></span></a>
                                                </td>
                                            </tr>   
    <?php }
} ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <br />
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
            $.ajax(
                    {
                        url: BASE_URL + "manage_firms/add_duplicate_firm",
                        type: 'get',
                        async: false,
                        data: {value1: frim_name},
                        success: function (result)
                        {
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
            firm_name = $.trim($("#frim_name").val());
          
            $.ajax(
                    {
                        url: BASE_URL + "manage_firms/add_duplicate_firm",
                        type: 'get',
                        data: {value1: firm_name},
                        success: function (result)
                        {
                            $("#dup").html(result);
                        }
                    });
        });
    </script>





<?php
if (isset($firms) && !empty($firms)) {
    foreach ($firms as $val) {
        ?>   
            <div id="test3_<?php echo $val['firm_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                <div class="modal-dialog">
                    <div class="modal-content modalcontent-top">
                        <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            <h3 id="myModalLabel" class="inactivepop">In-Active Product</h3>
                        </div>
                        <div class="modal-body">
                            Do You Want In-Active This Product?<strong><?= $val['firm_name']; ?></strong>
                            <input type="hidden" value="<?php echo $val['firm_id']; ?>" class="id" />
                        </div>
                        <div class="modal-footer action-btn-align">
                            <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                            <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
                        </div>
                    </div>
                </div>  
            </div>
        <?php }
    } ?>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "manage_firms/delete_firm",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "manage_firms");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>