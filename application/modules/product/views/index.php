<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
</style>
<div class="mainpanel">
    <div class="media">
        <h4>Product Details</h4>
    </div>
    <div class="contentpanel mb-40">
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#field-agent-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Product List</a></li>
                    <li role="presentation" class=""><a href="#field-agent" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">Add Product</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="field-agent">
                        <!-- <h4 align="center" class="sup-align">Add Product</h4>-->
                        <form action="<?php echo $this->config->item('base_url'); ?>product/insert_product" enctype="multipart/form-data" name="form" method="post"> 
                            <table class="table table-striped responsive no-footer dtr-inline">
                                <tr>
                                    <td width="12%">Model Number</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="model_no" class="form-control form-align model_no"  id="model_no" /> 
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
                                            <input type="text" name="product_name" class=" form-control form-align" id="name" />
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
                                        <input type="radio" name="type" class="" value="1" id="service_item">Product
                                        <input type="radio" name="type" class="" value="2" id="service_item">Others <br >                     
                                        <span id="type1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  

                                    <td width="12%">Product image</td>
                                    <td width="18%" rowspan="1" colspan="2">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img id="blah" class="add_staff_thumbnail" width="33px" height="33px" 
                                                     src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>                        
                                            </div>
                                            <div class="col-md-11">
                                                <input type='file' name="admin_image" class="imgInp productmargin-40" /><span id="profileerror9" class="val" style="color:#F00;" id="img"></span>
                                                <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </div>
                                        </div></td>                 
                                </tr>
                                <tr>
                                    <td width="12%">Cost Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="cost_price" class=" form-control form-align" id="cost_price" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-fw fa-money"></i>
                                            </div>
                                        </div>
                                        <span id="cost" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>   
                                    <td width="12%">Minimum Quantity</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="min_qty" class=" form-control form-align" id="min_qty" />
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <span id="min_qty1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>   
                                </tr>
                                <tr>
                                    <!-- <td width="12%">Minimum Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="selling_price" class="form-control form-align" id="sell_price"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-fw fa-money"></i>
                                            </div>
                                        </div>
                                        <span id="sell" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td> -->
                                        <td width="12%">Reorder Quantity</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="reorder_quantity" class="form-control form-align" id="reorder_quantity"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="reorder_quantity1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Product Description</td>
                                    <td width="18%">
                                        <textarea name="product_description"  class=" form-control form-align" id="description"></textarea>                           
                                        <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td> 
                                </tr>
                                <tr>
                                  <td width="12%">Cash Customer Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="cash_cus_price" class="form-control form-align" id="cash_cus_price"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="cash_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Credit Customer Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="credit_cus_price" class="form-control form-align" id="credit_cus_price"/> 
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
                                            <input type="text" name="cash_con_price" class="form-control form-align" id="cash_con_price"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                           
                                        <span id="cash_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                    <td width="12%">Credit Contractor Selling Price</td>
                                    <td width="18%">
                                        <div class="input-group">
                                            <input type="text" name="credit_con_price" class="form-control form-align" id="credit_con_price"/> 
                                            <div class="input-group-addon">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>                     
                                        <span id="credit_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                    </td>  
                                </tr>
                            </table>
                            <div class="frameset_table action-btn-align">
                                <table>
                                    <td width="540">&nbsp;</td>
                                    <td><input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" /></td>
                                    <td>&nbsp;</td>
                                    <td><input type="reset" value="Clear" class=" btn btn-danger1" id="reset" /></td><td>&nbsp;</td>
                                    <td><a href="<?php echo $this->config->item('base_url') . 'product/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a></td>
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
                                <th>Model Number</th>
                                <th>Product Name</th>
                                <th>Product Description</th>
                                <th>Product Image</th> 
                                <th>Type</th> 
                                <th>Minimum Quantity</th> 
                                <th>Reorder Quantity</th> 
                                <!-- <th>Minimum Selling Price</th> -->
                                <th>Cost price</th> 
                                <th class="action-btn-align">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($product) && !empty($product)) {
                                        $i = 0;
                                        foreach ($product as $val) {
                                            $i++
                                            ?>
                                            <tr>
                                                <td class="first_td action-btn-align"><?php echo "$i"; ?></td>
                                                <td><?= $val['model_no'] ?></td>
                                                <td><?= $val['product_name'] ?></td>
                                                <td><?= $val['product_description'] ?></td>
                                                <td> <img id="blah" class="add_staff_thumbnail" width="50px" height="50px"
                                                          alt=""accesskey="" src="<?= $this->config->item("base_url") . 'attachement/product/' . $val['product_image']; ?>"/>  </td>
                                                <td><?= $val['type'] ?></td>
                                                <td><?= $val['min_qty'] ?></td>
                                                <td><?= $val['reorder_quantity'] ?></td>
                                                <td><?= $val['cost_price'] ?></td>
                                                <td class="action-btn-align">
                                                    <a href="<?= $this->config->item('base_url') . 'product/edit_product/' . $val['id'] ?>" class="tooltips btn btn-info btn-xs" title="Edit">
                                                        <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active">
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
      /*  $("#sell_price").live('blur', function ()
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
        //$("#type").live('blur',function()
        //{
        //	var type=$("#type").val();	
        //	if(type=="" || type==null || type.trim().length==0)
        //	{
        //		$("#type1").html("Required Field");
        //	}
        //	else
        //	{
        //		$("#type1").html("");
        //	}
        //});
        $("#min_qty").live('blur', function ()
        {
            var min_qty = $("#min_qty").val();
            if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)
            {
                $("#min_qty1").html("Required Field");
            } else
            {
                $("#min_qty1").html("");
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
            $.ajax(
                    {
                        url: BASE_URL + "product/add_duplicate_product",
                        type: 'get',
                        async: false,
                        data: {value1: email},
                        success: function (result)
                        {
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

            var model_no = $("#model_no").val();
            if ($('#dup').html() == 'Model Number Already Exist')
            {
                i = 1;
            } else if (model_no == "" || model_no == null || model_no.trim().length == 0)
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

            var city = $('#description').val();
            if (city == "")
            {
                $('#cuserror3').html("Required Field");
                i = 1;
            } else
            {
                $('#cuserror3').html("");
            }


            if ($('input[name=type]:checked').length <= 0)
            {
                $("#type1").html("Required Field");
                i = 1;
            } else
            {
                $("#type1").html("");
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
            $.ajax(
                    {
                        url: BASE_URL + "product/add_duplicate_product",
                        type: 'get',
                        data: {value1: email},
                        success: function (result)
                        {
                            $("#dup").html(result);
                        }
                    });
        });
    </script>





<?php
if (isset($product) && !empty($product)) {
    foreach ($product as $val) {
        ?>   
            <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                <div class="modal-dialog">
                    <div class="modal-content modalcontent-top">
                        <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            <h3 id="myModalLabel" class="inactivepop">In-Active Product</h3>
                        </div>
                        <div class="modal-body">
                            Do You Want In-Active This Product?<strong><?= $val['model_no']; ?></strong>
                            <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
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
                url: BASE_URL + "product/delete_product",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "agent/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>