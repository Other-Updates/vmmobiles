<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>

<!-- <script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->

<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>

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

                        <form action="<?php echo $this->config->item('base_url') . 'masters/products/update_products'; ?>" enctype="multipart/form-data" name="form" method="post">
<input type="hidden" id="producc_id" name="id" value="<?php echo $productid;?>"/>
                            <div class="inner-sub-tit">Product Details</div>

                            <?php

                            if (isset($product) && !empty($product)) {

                                $i = 0;

                                foreach ($product as $val) {

                                    if ($val['product_image'] == '') {

                                        $val['product_image'] = 'no-img.gif';

                                    }

                                    //print_r($val);

                                    $i++

                                    ?>

                                    <div class="row">

                                        <div class="col-md-4">



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Shop Name &nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <select  onchange="Firm(this.value)" name="firm_id"  class="mandatory form-control form-align" id="firm" tabindex="1">

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

                                                    <span id="firmerr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Product Category&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <select name="category_id"  class="form-control form-align mandatory" id="category" tabindex="1">

                                                        <option value="">Select</option>

                                                        <?php

                                                        if (isset($category) && !empty($category)) {

                                                            foreach ($category as $vals) {

                                                                $select = ($vals['cat_id'] == $val['category_id']) ? 'selected' : '';

                                                                ?>

                                                                <option value="<?php echo $vals['cat_id']; ?>" <?php echo $select; ?> > <?php echo $vals['categoryName']; ?> </option>

                                                                <?php

                                                            }

                                                        }

                                                        ?>

                                                    </select>

                                                    <span id="caterr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                       <!--     <div class="form-group">

                                                <label class="col-sm-4 control-label">Model Number </label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="hidden" name="id" class="id id_dup form-control" value="<?php echo $val['id']; ?>" id="model_id"/>

                                                        <input type="text" name="model_no" org_name="<?php echo $val['model_no']; ?>" class="form-align" value="<?php echo $val['model_no']; ?>" id="model_no" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-user"></i>

                                                        </div>

                                                    </div>

                                                    <!--<span id="model" class="val"  style="color:#F00; font-style:oblique;"></span>-->

                                                   <!-- <span id="dup" class="dup" style="color:#F00; font-style:italic;"></span>

                                                </div>

                                            </div>-->


                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Product Model&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <select name="brand_id"  class="form-control form-align mandatory" id="brand" tabindex="1">

                                                        <option value="">Select</option>

                                                        <?php

                                                        if (isset($brand) && !empty($brand)) {

                                                            foreach ($brand as $vals) {

                                                                $select = ($vals['id'] == $val['brand_id']) ? 'selected' : '';

                                                                ?>

                                                                <option value="<?php echo $vals['id']; ?>" <?php echo $select; ?> > <?php echo $vals['brands']; ?> </option>

                                                                <?php

                                                            }

                                                        }

                                                        ?>

                                                    </select>

                                                    <span id="branderr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Product Name <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="product_name" class=" form-align mandatory" id="name" maxlength="70" value="<?php echo $val['product_name']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                         



                                        </div>

                                        <div class="col-md-4">








                                            <!-- <div class="form-group">

                                                <label class="col-sm-4 control-label">Type <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <input type="radio" name="type" class="" value="product" <?php //if ($val['type'] == 'product') echo 'checked="checked"';                                                   ?> tabindex="1">Product

                                                    <input type="radio" name="type" class="" value="service"  <?php //if ($val['type'] == 'service') echo 'checked="checked"';                                                   ?> tabindex="1">Others

                                                    <span id="type1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div> -->

                                               <div class="form-group">

                                                <label class="col-sm-4 control-label">HSN Number <span style="color:#F00; font-style:oblique;"></span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="hsn_sac" class=" form-align" id="hsn_number" value="<?php echo $val['hsn_sac']; ?>"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="hsn_number1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Product image</label>

                                                <div class="col-sm-8">

                                                    <div class="row">

                                                        <div class="col-md-2">

                                                            <img id="blah" class="add_staff_thumbnail" width="32px" height="32px"

                                                                 src="<?= $this->config->item("base_url") . 'attachement/product/' . $val['product_image']; ?>" />    

                                                                                      </div>

                                                        <div class="col-md-10">

                                                            <input type='file' name="admin_image" class="imgInp form-control margin0" autocomplete="off"/>

                                                            <span id="profileerror9" class="val" style="color:#F00;" id="img" tabindex="1"></span>

                                                            <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Minimum Quantity&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="min_qty" class=" form-align" id="min_qty" value="<?php echo $val['min_qty']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="min_qty1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Reorder Quantity</label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="reorder_quantity" class="form-align" id="reorder_quantity" value="<?php echo $val['reorder_quantity']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="reorder_quantity1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                             <input type="hidden" name="unit" class="form-align " id="unit" value="" tabindex="1"/>

                                          <!--  <div class="form-group">

                                                <label class="col-sm-4 control-label">Unit <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="unit" class="form-align mandatory" id="unit" value="<?php echo $val['unit']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-calendar"></i>

                                                        </div>

                                                    </div>

                                                    <span id="unit1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>-->



                                        </div>

                                        <div class="col-md-4">




                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Product Description </label>

                                                <div class="col-sm-8">

                                                    <textarea name="product_description" class=" form-control form-align"  id="description" tabindex="1"><?php echo $val['product_description']; ?></textarea>

                                                    <!--<span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>-->

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">UPC<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="barcode" class=" form-align mandatory" id="barcode" value="<?php echo $val['barcode']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-barcode"></i>

                                                        </div>

                                                    </div>

                                                    <span id="barcode1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Discount</label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="discount" class="form-align" id="discount" value="<?php echo $val['discount']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="discount1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Expires In <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="expires_in" class=" form-align" id="expires_in" value="<?php echo $val['expires_in']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="inner-sub-tit">Price Details</div>

                                    <div class="row">

                                        <div class="col-md-6">



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Cost Price <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="cost_price" class="mandatory form-align" id="cost_price" value="<?php echo $val['cost_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cost" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                           <!-- <div class="form-group">

                                                <label class="col-sm-4 control-label">T1 Selling Price <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="cash_cus_price" class="form-align" id="cash_cus_price" value="<?php echo $val['cash_cus_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cash_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">T3 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="cash_con_price" class="form-align" id="cash_con_price" value="<?php echo $val['cash_con_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cash_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">T5 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="vip_price" class="form-align" id="vip_price" value="<?php echo $val['vip_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="vip_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">H1 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="h1_price" class="form-align" id="h1_price" value="<?php echo $val['h1_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="h1_priceerr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>-->

                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">Sales Price <span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="sales_price" class="mandatory form-align" id="sales_price" value="<?php echo $val['sales_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-fw fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="sales_errr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>
                                            <!--<div class="form-group">

                                                <label class="col-sm-4 control-label">T2 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="credit_cus_price" class="form-align" id="credit_cus_price" value="<?php echo $val['credit_cus_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="credit_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">T4 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="credit_con_price" class="form-align" id="credit_con_price" value="<?php echo $val['credit_con_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="credit_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">T6 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="vvip_price" class="form-align" id="vvip_price" value="<?php echo $val['vvip_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-shopping-cart"></i>

                                                        </div>

                                                    </div>

                                                    <span id="vvip_price1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">H2 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="h2_price" class="form-align" id="h2_price" value="<?php echo $val['h2_price']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-money"></i>

                                                        </div>

                                                    </div>

                                                    <span id="h2_priceerr" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>-->



                                        </div>





                                    </div>

                                    <div class="inner-sub-tit">Tax Details</div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">CGST % <span style="color:#F00; font-style:oblique;"></span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="cgst" class="form-align" id="cgst" value="<?php echo $val['cgst']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-tag"></i>

                                                        </div>

                                                    </div>

                                                    <span id="cgst1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">SGST % <span style="color:#F00; font-style:oblique;"></span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="sgst" class="form-align" id="sgst" value="<?php echo $val['sgst']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-tag"></i>

                                                        </div>

                                                    </div>

                                                    <span id="sgst1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label class="col-sm-4 control-label">IGST % <span style="color:#F00; font-style:oblique;"></span></label>

                                                <div class="col-sm-8">

                                                    <div class="input-group">

                                                        <input type="text" name="igst" class="form-align" id="igst" value="<?php echo $val['igst']; ?>" tabindex="1"/>

                                                        <div class="input-group-addon">

                                                            <i class="fa fa-tag"></i>

                                                        </div>

                                                    </div>

                                                    <span id="igst1" class="val"  style="color:#F00; font-style:oblique;"></span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <?php

                                }

                            }

                            ?>

                            <div class="frameset_table action-btn-align">

                                <input type="submit" name="submit" class="btn btn-success" value="Update" id="submit"  tabindex="1"/>

                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" tabindex="1"/>

                                <a href="<?php echo $this->config->item('base_url') . 'masters/products/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function ()

    {

        $('#min_qty').on('keyup', function ()

        {

            var min_qty_val = $(this).val();

            var nfilter = /^[0-9]+$/;

            if (!nfilter.test(min_qty_val))

            {

                $('#reorder_quantity').val('');

            } else {

                var per = 20;

                var per_val = (per / 100) * min_qty_val;

                var per_val = parseInt(per_val) + parseInt(min_qty_val);

                $('#reorder_quantity').val(per_val);

            }

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



    $(".imgInp").on('change', function () {

        readURL(this);

    });

    $("#name").on('blur', function ()

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

    $("#unit").on('blur', function ()

    {

        var unit = $("#unit").val();

        if (unit == "" || unit == null || unit.trim().length == 0)

        {

           // $("#unit1").html("Required Field");

        } else

        {

            $("#unit1").html("");

        }

    });

    $("#cost_price").on('blur', function ()

    {

        var cost_price = $("#cost_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)

        {

            $("#cost").html("Required Field");

        } else if (!nfilter.test(cost_price))

        {

            $("#cost").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#cost").html("");

        }

    });

    $("#cgst").on('blur', function ()

    {

        var cgst = $("#cgst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cgst == "" || cgst == null || cgst.trim().length == 0)

        {

          //  $("#cgst1").html("Required Field");

        } else if (!nfilter.test(cgst))

        {

            $("#cgst1").html("Enter Valid Amount");

            i = 1;

        } else

        {

            $("#cgst1").html("");

        }

    });



    $("#sgst").on('blur', function ()

    {

        var sgst = $("#sgst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (sgst == "" || sgst == null || sgst.trim().length == 0)

        {

           // $("#sgst1").html("Required Field");

        } else if (!nfilter.test(sgst))

        {

            $("#sgst1").html("Enter Valid Amount");

            i = 1;

        } else

        {

            $("#sgst1").html("");

        }

    });





    $("#igst").on('blur', function ()

    {

        var sgst = $("#igst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (sgst == "")

        {

           // $("#igst1").html("Required Field");

          //  i = 1;

        } else if (!nfilter.test(sgst))

        {

            $("#igst1").html("Enter Valid Amount");

            i = 1;

        } else

        {

            $("#igst1").html("");

        }

    });





    $("#hsn_number").on('blur', function ()

    {

        var hsn_number = $("#hsn_number").val();

        if (hsn_number == "" || hsn_number == null || hsn_number.trim().length == 0)

        {

           // $("#hsn_number1").html("Required Field");

        } else

        {

            $("#hsn_number1").html("");

        }

    });







    $("#cash_cus_price").on('blur', function ()

    {

        var cash_cus_price = $("#cash_cus_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cash_cus_price == "" || cash_cus_price == null || cash_cus_price.trim().length == 0)

        {

           // $("#cash_cus_price1").html("Required Field");

        } else if (!nfilter.test(cash_cus_price))

        {

            $("#cash_cus_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#cash_cus_price1").html("");

        }

    });

    $("#credit_cus_price").on('blur', function ()

    {

        var credit_cus_price = $("#credit_cus_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (credit_cus_price == "" || credit_cus_price == null || credit_cus_price.trim().length == 0)

        {

          //  $("#credit_cus_price1").html("Required Field");

        } else if (!nfilter.test(credit_cus_price))

        {

            $("#credit_cus_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#credit_cus_price1").html("");

        }

    });

    $("#cash_con_price").on('blur', function ()

    {

        var cash_con_price = $("#cash_con_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cash_con_price == "" || cash_con_price == null || cash_con_price.trim().length == 0)

        {

            //$("#cash_con_price1").html("Required Field");

        } else if (!nfilter.test(cash_con_price))

        {

            $("#cash_con_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#cash_con_price1").html("");

        }

    });

    $("#credit_con_price").on('blur', function ()

    {

        var credit_con_price = $("#credit_con_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (credit_con_price == "" || credit_con_price == null || credit_con_price.trim().length == 0)

        {

           // $("#credit_con_price1").html("Required Field");

        } else if (!nfilter.test(credit_con_price))

        {

            $("#credit_con_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#credit_con_price1").html("");

        }

    });

    $("#vip_price").on('blur', function ()

    {

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        var vip_price = $("#vip_price").val();

        if (vip_price == "" || vip_price == null || vip_price.trim().length == 0)

        {

          //  $("#vip_price1").html("Required Field");

        } else if (!nfilter.test(vip_price))

        {

            $("#vip_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#vip_price1").html("");

        }

    });

    $("#vvip_price").on('blur', function ()

    {

        var vvip_price = $("#vvip_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (vvip_price == "" || vvip_price == null || vvip_price.trim().length == 0)

        {

           // $("#vvip_price1").html("Required Field");

        } else if (!nfilter.test(vvip_price))

        {

            $("#vvip_price1").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#vvip_price1").html("");

        }

    });



    $("#h1_price").on('blur', function ()

    {

        var vvip_price = $("#h1_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (vvip_price == "" || vvip_price == null || vvip_price.trim().length == 0)

        {

          //  $("#h1_priceerr").html("Required Field");

        } else if (!nfilter.test(vvip_price))

        {

            $("#h1_priceerr").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#h1_priceerr").html("");

        }

    });

    $("#h2_price").on('blur', function ()

    {

        var vvip_price = $("#h2_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (vvip_price == "" || vvip_price == null || vvip_price.trim().length == 0)

        {

            //$("#h2_priceerr").html("Required Field");

        } else if (!nfilter.test(vvip_price))

        {

            $("#h2_priceerr").html("Enter Valid Price");

            i = 1;

        } else

        {

            $("#h2_priceerr").html("");

        }

    });



    $("#min_qty").on('blur', function ()

    {

        var min_qty = $("#min_qty").val();

        var nfilter = /^[0-9]+$/;

        if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)

        {

           // $("#min_qty1").html("Required Field");

        } else if (!nfilter.test(min_qty))

        {

            $("#min_qty1").html("Only Numeric Values");

            i = 1;

        } else

        {

            $("#min_qty1").html("");

        }

    });



    $('#reset').on('click', function ()

    {

        $('.val').html("");

        $('.dup').html("");

    });

</script>

<script type="text/javascript">

    $('#submit').on('click', function ()

    {

        var i = 0;

        var name = $("#name").val();

        if (name == "" || name == null || name.trim().length == 0)

        {

            $("#cuserror2").html("Required Field");

            i = 1;

            $('#name').focus();

        } else

        {

            $("#name").html("");

        }



        var cgst = $("#cgst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cgst == "" || cgst == null || cgst.trim().length == 0)

        {

           // $("#cgst1").html("Required Field");

          //  i = 1;

           // $('#cgst').focus();

        } else if (!nfilter.test(cgst))

        {

            //$("#cgst1").html("Enter Valid Amount");

          //  i = 1;

           // $('#cgst').focus();

        } else

        {

            $("#cgst1").html("");

        }



        var sgst = $("#sgst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (sgst == "" || sgst == null || sgst.trim().length == 0)

        {

           // $("#sgst1").html("Required Field");

          //  i = 1;

           // $('#sgst').focus();

        } else if (!nfilter.test(sgst))

        {

            $("#sgst1").html("Enter Valid Amount");

            i = 1;

            $('#sgst').focus();

        } else

        {

            $("#sgst1").html("");

        }



        var igst = $("#igst").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (igst == "" || igst == null || igst.trim().length == 0)

        {

            //$("#igst1").html("Required Field");

           // i = 1;

           // $('#igst').focus();

        }

        if (!nfilter.test(sgst))

        {

            $("#igst1").html("Enter Valid Amount");

            i = 1;

            $('#igst').focus();

        }



        var cost_price = $("#cost_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)

        {

           // $("#cost").html("Required Field");

           // i = 1;

           // $('#cost_price').focus();

        } else if (!nfilter.test(cost_price))

        {

            $("#cost").html("Enter Valid Amount");

            i = 1;

            $('#cost_price').focus();

        } else

        {

            $("#cost").html("");

        }

        var cash_cus_price = $("#cash_cus_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cash_cus_price == "" || cash_cus_price == null || cash_cus_price.trim().length == 0)

        {

           // $("#cash_cus_price1").html("Required Field");

           // i = 1;

           // $('#cash_cus_price').focus();

        } else if (!nfilter.test(cash_cus_price))

        {

            $("#cash_cus_price1").html("Enter Valid Price");

            i = 1;

            $('#cash_cus_price').focus();

        } else

        {

            $("#cash_cus_price1").html("");

        }

        var credit_cus_price = $("#credit_cus_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (credit_cus_price == "" || credit_cus_price == null || credit_cus_price.trim().length == 0)

        {

           // $("#credit_cus_price1").html("Required Field");

          //  i = 1;

           // $('#credit_cus_price').focus();

        } else if (!nfilter.test(credit_cus_price))

        {

            $("#credit_cus_price1").html("Enter Valid Price");

            i = 1;

            $('#credit_cus_price').focus();

        } else

        {

            $("#credit_cus_price1").html("");

        }

        var cash_con_price = $("#cash_con_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (cash_con_price == "" || cash_con_price == null || cash_con_price.trim().length == 0)

        {

          //  $("#cash_con_price1").html("Required Field");

          //  i = 1;

           // $('#cash_con_price').focus();

        } else if (!nfilter.test(cash_con_price))

        {

            $("#cash_con_price1").html("Enter Valid Price");

            i = 1;

            $('#cash_con_price').focus();

        } else

        {

            $("#cash_con_price1").html("");

        }

        var credit_con_price = $("#credit_con_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (credit_con_price == "" || credit_con_price == null || credit_con_price.trim().length == 0)

        {

           // $("#credit_con_price1").html("Required Field");

           // i = 1;

           // $('#credit_con_price').focus();

        } else if (!nfilter.test(credit_con_price))

        {

            $("#credit_con_price1").html("Enter Valid Price");

            i = 1;

            $('#credit_con_price').focus();

        } else

        {

            $("#credit_con_price1").html("");

        }

        var vip_price = $("#vip_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (vip_price == "" || vip_price == null || vip_price.trim().length == 0)

        {

           // $("#vip_price1").html("Required Field");

          //  i = 1;

          //  $('#vip_price').focus();

        } else if (!nfilter.test(vip_price))

        {

            $("#vip_price1").html("Enter Valid Price");

            i = 1;

            $('#vip_price').focus();

        } else

        {

            $("#vip_price1").html("");

        }

        var vvip_price = $("#vvip_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (vvip_price == "" || vvip_price == null || vvip_price.trim().length == 0)

        {

           // $("#vvip_price1").html("Required Field");

           // i = 1;

           // $('#vvip_price').focus();

        } else if (!nfilter.test(vvip_price))

        {

            $("#vvip_price1").html("Enter Valid Price");

            i = 1;

            $('#vvip_price').focus();

        } else

        {

            $("#vvip_price1").html("");

        }



        var h1_price = $("#h1_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (h1_price == "" || h1_price == null || h1_price.trim().length == 0)

        {

           // $("#h1_priceerr").html("Required Field");

           // i = 1;
//
           // $('#h1_price').focus();

        } else if (!nfilter.test(h1_price))

        {

            $("#h1_priceerr").html("Enter Valid Price");

            i = 1;

            $('#h1_price').focus();

        } else

        {

            $("#h1_priceerr").html("");

        }





        var h2_price = $("#h2_price").val();

        var nfilter = /^[0-9]*\.?[0-9]*$/;

        if (h2_price == "" || h2_price == null || h2_price.trim().length == 0)

        {

           // $("#h2_priceerr").html("Required Field");

           // i = 1;

            //$('#h2_price').focus();

        } else if (!nfilter.test(h2_price))

        {

            $("#h2_priceerr").html("Enter Valid Price");

            i = 1;

            $('#h2_price').focus();

        } else

        {

            $("#h2_priceerr").html("");

        }



        var min_qty = $("#min_qty").val();

        var nfilter = /^[0-9]+$/;

        if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)

        {

            //$("#min_qty1").html("Required Field");

           // i = 1;

           // $('#min_qty').focus();

        } else if (!nfilter.test(min_qty))

        {

            $("#min_qty1").html("Enter Valid Price");

            i = 1;

            $('#min_qty').focus();

        } else

        {

            $("#min_qty1").html("");

        }



        var hsn_number = $('#hsn_number').val();

        if (hsn_number == "")

        {

           // $('#hsn_number1').html("Required Field");

          //  i = 1;

          //  $('#hsn_number').focus();

        } else

        {

            $('#hsn_number1').html("");

        }



        var firm = $('#firm').val();

        if (firm == "")

        {

            $('#firmerr').html("Required Field");

            i = 1;

            $('#firm').focus();

        } else

        {

            $('#firmerr').html("");

        }



        var unit = $('#unit').val();

        if (unit == "")

        {

           // $('#unit1').html("Required Field");

           // i = 1;

           // $('#unit').focus();

        } else

        {

            $('#unit1').html("");

        }



        var category = $('#category').val();

        if (category == "")

        {

            $('#caterr').html("Required Field");

            i = 1;

            $('#category').focus();

        } else

        {

            $('#caterr').html("");

        }





        if ($('#dup').html() == 'Model Number Already Exist')

        {

           // i = 1;

        } else

        {

            $('#dup').html('');

        }

      //  alert(i);
                $('.mandatory').each(function (e) {
                    this_val = $.trim($(this).val());
                    this_id = $(this).attr('id');
                    
                    
                    if(this_id!='s2id_category' && this_id!='s2id_brand')
                    {
                        if (this_val.length == 0) {
                        console.log(this_id);

                        
                        $(this).closest('div.form-group').find('span.val').text('Required Field').css('display', 'inline-block');

                        i++;

                        //$('#' + this_id_first + '').focus();
                        } else {
                             
                            $(this).closest('div.form-group').find('span.val').text('').css('display', 'none');
                        } 
                    }
                   
                });
            

        if (i > 0)
        {

            return false;

        } else

        {

            return true;

        }



    });

</script>

<script>

    function Firm(val) {

        if (val != '') {

            $.ajax({

                type: 'POST',

                data: {firm_id: val},

                url: '<?php echo base_url(); ?>masters/products/get_category_by_frim_id',

                success: function (data) {

                    result = JSON.parse(data);

                    if (result != null && result.length > 0) {

                        option_text = '<option value="">Select Category</option>';

                        $.each(result, function (key, value) {

                            option_text += '<option value="' + value.cat_id + '">' + value.categoryName + '</option>';

                        });

                        $('#category').html(option_text);

                        $('#category').removeAttr('disabled');

                        $('#category').addClass('required');

                    } else {

                        $('#category').html('');

                        $('#category').removeClass('required');

                        $('#category').attr('disabled', 'disabled');

                    }

                }

            });

            $.ajax({

                type: 'POST',

                data: {firm_id: val},

                url: '<?php echo base_url(); ?>masters/products/get_brand_by_frim_id',

                success: function (data) {

                    result = JSON.parse(data);

                    if (result != null && result.length > 0) {

                        option_text1 = '<option value="">Select Brand</option>';

                        $.each(result, function (key, value) {

                            option_text1 += '<option value="' + value.id + '">' + value.brands + '</option>';

                        });

                        $('#brand').html(option_text1);

                        $('#brand').removeAttr('disabled');

                        $('#brand').addClass('required');

                    } else {

                        $('#brand').html('');

                        $('#brand').removeClass('required');

                        $('#brand').attr('disabled', 'disabled');

                    }

                }

            });

        } else {

            $('#category,#brand').html('');

            $('#category,#brand').removeClass('required');

            $('#category,#brand').attr('disabled', 'disabled');

        }

    }

</script>

<script>

    $("#model_no").on('blur', function ()

    {

        email = $.trim($("#model_no").val());

        id = $('#model_id').val();

        if (email != '') {

            $.ajax(

                    {

                        url: BASE_URL + "masters/products/update_duplicate_product",

                        type: 'get',

                        async: false,

                        data: {value1: email, value2: id},

                        success: function (result)

                        {

                            if ($('#model_no').attr('org_name') != email)

                            {

                                $("#dup").html(result);

                            }

                        }



                    });

        }

    });

</script>