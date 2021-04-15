<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
        <h4>Update Product</h4>
    </div>
    <div class="contentpanel">
        <div class="panel-body">
            <div class="tabs">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="update-field">
                        <!-- <h4 align="center" class="sup-align">Update Product</h4>-->
                        <form action="<?php echo $this->config->item('base_url') . 'product/update_products'; ?>" enctype="multipart/form-data" name="form" method="post"> 
                            <table class="table table-striped responsive no-footer dtr-inline">
                                <tr>
                                    <?php
                                    if (isset($product) && !empty($product)) {
                                        $i = 0;
                                        foreach ($product as $val) {
                                            //print_r($val);
                                            $i++
                                            ?>
                                            <td width="12%">Model Number</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="hidden" name="id" class="id id_dup form-control" value="<?php echo $val['id']; ?>" id="model_id"/>
                                                    <input type="text" name="model_no" org_name="<?php echo $val['model_no']; ?>" class="form-control form-align" value="<?php echo $val['model_no']; ?>" id="model_no"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <span id="model" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                <span id="dup" class="dup" style="color:#F00; font-style:italic;"></span>
                                            </td>
                                            <td width="12%">Product Name</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="text" name="product_name" class=" form-control form-align" id="name" value="<?php echo $val['product_name']; ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>                      
                                        </tr>
                                        <tr>
                                            <td width="12%">Type</td>
                                            <td width="18%">
                                                <input type="radio" name="type" class="" value="product" <?php if ($val['type'] == 'product') echo 'checked="checked"'; ?> >Product
                                                <input type="radio" name="type" class="" value="service"  <?php if ($val['type'] == 'service') echo 'checked="checked"'; ?> >Others                       
                                                <span id="type1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>   

                                            <td width="12%">Product image</td>
                                            <td width="18%" rowspan="1" colspan="2">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <img id="blah" class="add_staff_thumbnail" width="32px" height="32px"
                                                             src="<?= $this->config->item("base_url") . 'attachement/product/' . $val['product_image']; ?>"/>                         </div>
                                                    <div class="col-md-11 ">
                                                        <input type='file' name="admin_image" class="imgInp productmargin-40" autocomplete="off"/><span id="profileerror9" class="val" style="color:#F00;" id="img"></span>
                                                        <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span> 
                                                    </div>
                                                </div></td>                 
                                        </tr>
                                        <tr>
                                            <td width="12%">Cost Price</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="text" name="cost_price" class=" form-control form-align" id="cost_price" value="<?php echo $val['cost_price']; ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fw fa-money"></i>
                                                    </div>
                                                </div>
                                                <span id="cost" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td width="12%">Minimum Quantity</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="text" name="min_qty" class=" form-control form-align" id="min_qty" value="<?php echo $val['min_qty']; ?>"/>
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <span id="min_qty1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>  
                                        <tr>
                                           <!-- <td width="12%">Minimum Selling Price</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="text" name="selling_price" class="form-control form-align" id="sell_price" value="<?php //echo $val['selling_price']; ?>"/> 
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-fw fa-money"></i>
                                                    </div>
                                                </div>
                                                <span id="sell" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td> -->
                                              <td width="12%">Reorder Quantity</td>
                                            <td width="18%">
                                                <div class="input-group">
                                                    <input type="text" name="reorder_quantity" class="form-control form-align" id="reorder_quantity" value="<?php echo $val['reorder_quantity']; ?>" /> 
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <span id="reorder_quantity1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>  
                                            <td width="12%">Product Description</td>
                                            <td width="18%">
                                                <textarea name="product_description" class=" form-control form-align"  id="description"><?php echo $val['product_description']; ?></textarea>                           
                                                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>   
                                        </tr>
                                        <tr>
                                  <td width="12%">Cash Customer Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="cash_cus_price" class="form-control form-align" id="cash_cus_price" value="<?php echo $val['cash_cus_price']; ?>"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="cash_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Credit Customer Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="credit_cus_price" class="form-control form-align" id="credit_cus_price" value="<?php echo $val['credit_cus_price']; ?>"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                   
                                        <span id="credit_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                </tr>
                                <tr>
                                  <td width="12%">Cash Contractor Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="cash_con_price" class="form-control form-align" id="cash_con_price" value="<?php echo $val['cash_con_price']; ?>"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="cash_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Credit Contractor Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="credit_con_price" class="form-control form-align" id="credit_con_price" value="<?php echo $val['credit_con_price']; ?>"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                     
                                        <span id="credit_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                </tr>
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
                                    <td><a href="<?php echo $this->config->item('base_url') . 'product/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
                                </table>  
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function()
            {
               $('#min_qty').on('keyup',function()
               {
                 var min_qty_val  = $(this).val(); 
                 var per = 20;
                 var per_val = (per / 100) * min_qty_val;
                 var per_val = parseInt(per_val) + parseInt(min_qty_val);
                 $('#reorder_quantity').val(per_val);
               });
            });
            function readURL(input) {
                console.log(input);
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);
                        $(input).closest('div').find('#blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".imgInp").live('change', function () {
                readURL(this);
            });
            $("#name").live('blur', function ()
            {
                var name = $("#name").val();
                if (name == "" || name == null || name.trim().length == 0)
                {
                    $("#cuserror2").html("Required Field");
                } else
                {
                    $("#cuserror2").html("");
                }
            });
            $("#description").live('blur', function ()
            {
                var name = $("#description").val();
                if (name == "" || name == null || name.trim().length == 0)
                {
                    $("#cuserror3").html("Required Field");
                } else
                {
                    $("#cuserror3").html("");
                }
            });
            //$("#img").live('blur',function()
            //{
            //	var store=$("#img").val();
            //	if(store=="" || store==null || store.trim().length==0)
            //	{
            //		$("#cuserror1").html("Required Field");
            //	}
            //	else
            //	{
            //		$("#cuserror1").html("");
            //	}
            //});
            $("#model_no").live('blur', function ()
            {
                var model_no = $("#model_no").val();
                if (model_no == "" || model_no == null || model_no.trim().length == 0)
                {
                    $("#model").html("Required Field");
                } else
                {
                    $("#model").html("");
                }
            });
           /* $("#sell_price").live('blur', function ()
            {
                var sell_price = $("#sell_price").val();
                if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)
                {
                    $("#sell").html("Required Field");
                } else
                {
                    $("#sell").html("");
                }
            }); */
            $("#cost_price").live('blur', function ()
            {
                var cost_price = $("#cost_price").val();
                if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)
                {
                    $("#cost").html("Required Field");
                } else
                {
                    $("#cost").html("");
                }
            });
            $("#cash_cus_price").live('blur', function ()
        {
            var cash_cus_price = $("#cash_cus_price").val();
            if (cash_cus_price == "" || cash_cus_price == null || cash_cus_price.trim().length == 0)
            {
                $("#cash_cus_price1").html("Required Field");
            } else
            {
                $("#cash_cus_price1").html("");
            }
        });
         $("#credit_cus_price").live('blur', function ()
        {
            var credit_cus_price = $("#credit_cus_price").val();
            if (credit_cus_price == "" || credit_cus_price == null || credit_cus_price.trim().length == 0)
            {
                $("#credit_cus_price1").html("Required Field");
            } else
            {
                $("#credit_cus_price1").html("");
            }
        });
         $("#cash_con_price").live('blur', function ()
        {
            var cash_con_price = $("#cash_con_price").val();
            if (cash_con_price == "" || cash_con_price == null || cash_con_price.trim().length == 0)
            {
                $("#cash_con_price1").html("Required Field");
            } else
            {
                $("#cash_con_price").html("");
            }
        });
        $("#credit_con_price").live('blur', function ()
        {
            var credit_con_price = $("#credit_con_price").val();
            if (credit_con_price == "" || credit_con_price == null || credit_con_price.trim().length == 0)
            {
                $("#credit_con_price1").html("Required Field");
            } else
            {
                $("#credit_con_price1").html("");
            }
        });

            $('#reset').live('click', function ()
            {
                $('.val').html("");
            });
        </script>
        <script type="text/javascript">
            $('#submit').live('click', function ()
            {
                email = $.trim($("#model_no").val());
                id = $('#model_id').val();
                $.ajax(
                        {
                            url: BASE_URL + "product/update_duplicate_product",
                            type: 'get',
                            async: false,
                            data: {value1: email, value2: id},
                            success: function (result)
                            {
                                if ($('#model_no').attr('org_name') != email)
                                    $("#dup").html(result);
                            }
                        });
                var i = 0;
                var name = $("#name").val();
                if (name == "" || name == null || name.trim().length == 0)
                {
                    $("#cuserror2").html("Required Field");
                    i = 1;
                } else
                {
                    $("#cuserror2").html("");
                }


                var city = $('#description').val();
                if (city == "")
                {
                    $('#cuserror3').html("Required Field");
                    i = 1;
                } else
                {
                    $('#cuserror3').html("");
                }
                var model_no = $("#model_no").val();
                if (model_no == "" || model_no == null || model_no.trim().length == 0)
                {
                    $("#model").html("Required Field");
                    i = 1;
                } else
                {
                    $("#model").html("");
                }


                var cost_price = $("#cost_price").val();
                if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)
                {
                    $("#cost").html("Required Field");
                    i = 1;
                } else
                {
                    $("#cost").html("");
                }
                var cash_cus_price = $("#cash_cus_price").val();
            if (cash_cus_price == "" || cash_cus_price == null || cash_cus_price.trim().length == 0)
            {
                $("#cash_cus_price1").html("Required Field");
                i = 1;
            } else
            {
                $("#cash_cus_price1").html("");
            }
            var credit_cus_price = $("#credit_cus_price").val();
            if (credit_cus_price == "" || credit_cus_price == null || credit_cus_price.trim().length == 0)
            {
                $("#credit_cus_price1").html("Required Field");
                i = 1;
            } else
            {
                $("#credit_cus_price1").html("");
            }
            var cash_con_price = $("#cash_con_price").val();
            if (cash_con_price == "" || cash_con_price == null || cash_con_price.trim().length == 0)
            {
                $("#cash_con_price1").html("Required Field");
                i = 1;
            } else
            {
                $("#cash_con_price1").html("");
            }
            var credit_con_price = $("#credit_con_price").val();
            if (credit_con_price == "" || credit_con_price == null || credit_con_price.trim().length == 0)
            {
                $("#credit_con_price1").html("Required Field");
                i = 1;
            } else
            {
                $("#credit_con_price1").html("");
            }
                var min_qty = $("#min_qty").val();
                if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)
                {
                    $("#min_qty1").html("Required Field");
                    i = 1;
                } else
                {
                    $("#min_qty1").html("");
                }
               
               /* var sell_price = $("#sell_price").val();
                if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)
                {
                    $("#sell").html("Required Field");
                    i = 1;
                } else
                {
                    $("#sell").html("");
                } */
                if ($('input[name=type]:checked').length <= 0)
                {
                    $("#type1").html("Required Field");
                    i = 1;
                } else
                {
                    $("#type1").html("");
                }
                if ($('#dup').html() == 'Model Number Already Exist')
                {
                    i = 1;
                } else
                {
                    $('#dup').html('');
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
            $("#model_no").live('blur', function ()
            {
                email = $.trim($("#model_no").val());
                id = $('#model_id').val();
                $.ajax(
                        {
                            url: BASE_URL + "product/update_duplicate_product",
                            type: 'get',
                            data: {value1: email, value2: id},
                            success: function (result)
                            {
                                if ($('#model_no').attr('org_name') != email)
                                    $("#dup").html(result);
                            }
                        });
            });
        </script>
