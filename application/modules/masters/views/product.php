<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<!--<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script> -->
<script src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">


<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/toastr.min.css"/>
<script type='text/javascript' src='<?= $theme_path; ?>/js/toastr.min.js'></script>
<style>
    .input-group-addon .fa { width:10px !important; }
    .modal-dialog {
        width: 600px;
        margin: 168px auto;
    }

    #toast-container.toast-top-center>div {
        width: 300px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 60px;
    }
    .text-center {
        text-align: left;
    }
    table tr td:nth-child(5) {text-align:left !important;}
    .aln-right tr td:nth-child(6) {
        text-align: right !important;
    }
    .aln-right tr td:nth-child(7) {
        text-align: right !important;
    }
</style>
<script>
    $(document).ready(function ()
    {
        $('#excel_report').on('click', function ()
        {
            window.location.replace('<?php echo $this->config->item('base_url') . 'masters/products/excel_report' ?>');
        });
    });
</script>
<?php
$model_numbers_json = array();
if (!empty($products)) {
    foreach ($products as $list) {
        $model_numbers_json[] = '{ id: "' . $list['id'] . '", value: "' . $list['product_name'] . '"}';
    }
}

$model_numbers_extra = array();
if (!empty($products)) {
    foreach ($products as $list) {
        if (!empty($list['model_no'])) {
            $model_numbers_extra[] = '{ id: "' . $list['id'] . '", value: "' . $list['model_no'] . '"}';
        }
    }
}
$brand_json = array();
if (!empty($brand)) {
    foreach ($brand as $list) {
        $brand_json[] = '{ id: "' . $list['id'] . '", value: "' . $list['store_name'] . '"}';
    }
}
?>
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
                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'products', 'add')): ?>#field-agent<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'products', 'add')): ?>alerts<?php endif ?>">Add Product</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="field-agent">
                        <form name="form" id="add_defect" action="<?php echo $this->config->item('base_url'); ?>masters/products/insert_product" method="post"  enctype="multipart/form-data">
                            <div class="inner-sub-tit">Product Details</div>
                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Shop Name&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select onchange="Firm(this.value)" name="firm_id"  class="form-control  mandatory form-align " id="firm">
                                                <option value="">Select Shop</option>
                                                <?php
                                                if (isset($firms) && !empty($firms)) {
                                                    foreach ($firms as $key => $firm) {
                                                        $select = '';
                                                        if ($key == 0) {
                                                            $select = "selected=selected";
                                                        }
                                                        ?>
                                                        <option <?php echo $select; ?> value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="firmerr"   style="color:#F00; font-style:oblique;"></span>
                                            <span id="caterr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Category&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="category_id"  class="form-control form-align mandatory" id="category" disabled="" >
                                                <option value="">Select</option>
                                            </select>
                                            <span id="caterr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg category_id_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Model&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="brand_id"  class="form-control form-align mandatory" id="brand" disabled="" >
                                                <option value="">Select</option>
                                            </select>
                                            <span id="branderr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="product_name" class=" form-align required mandatory"  id="pname" maxlength="20" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>

                                            <span id="dublicate" class="val product_error"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>

                                            <!--<span id="cuserror2" class="val"  style="color:#F00; font-style:oblique;"></span>-->
                                        </div>
                                    </div>




                                    <!--<div class="form-group">
                                        <label class="col-sm-4 control-label">Model Number</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="model_no" class="form-align model_no"  id="model_no" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <!--<span id="model" class="val"  style="color:#F00; font-style:oblique;"></span>-->
                                           <!-- <span id="dup" class="dup" style="color:#F00; font-style:italic;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>-->





                                </div>
                                <div class="col-md-4">
                                    <!-- <div class="form-group">
                                         <label class="col-sm-4 control-label">Brand&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>
                                         <div class="col-sm-8">
                                             <select name="brand_id"  class="form-control   form-align" id="brand" disabled="">
                                                 <option value="">Select</option>
                                             </select>
                                             <span id="branderr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                             <span class="error_msg"></span>
                                         </div>
                                     </div>-->
                                    <input type="hidden" name="type" class="" value="1" id="service_item">
                                    <!--<div class="form-group">
                                        <label class="col-sm-4 control-label">Type <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="radio" name="type" class="" value="1" id="service_item">Product
                                            <input type="radio" name="type" class="" value="2" id="service_item">Others <br >
                                            <span id="type1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">HSN Number</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="hsn_sac" class=" form-align " id="hsn_number" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                            <span id="hsn_number1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Product image</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img id="blah" class="add_staff_thumbnail" width="33px" height="33px"
                                                         src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type='file' name="admin_image" class="imgInp form-control margin0" /><span id="profileerror9" style="color:#F00;" id="img"></span>
                                                    <span id="cuserror1"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Minimum Quantity&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="min_qty" class=" form-align" id="min_qty" maxlength="20"/>
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
                                                <input type="text" name="reorder_quantity" class="form-align" id="reorder_quantity" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                            <span id="reorder_quantity1"   style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="unit" class="form-align" id="unit" maxlength="20" value=""/>
                                    <!-- <div class="form-group">
                                         <label class="col-sm-4 control-label">Unit <span style="color:#F00; font-style:oblique;">*</span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="unit" class="form-align mandatory" id="unit" maxlength="20"/>
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
                                        <label class="col-sm-4 control-label">Product Description</label>
                                        <div class="col-sm-8">
                                            <textarea name="product_description"  class=" form-control form-align" id="description"></textarea>
                                            <!--<span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>-->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">UPC <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="barcode" class="mandatory form-align" id="barcode" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fw fa-barcode"></i>
                                                </div>
                                            </div>
                                            <span id="barcode1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Discount</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="discount" class="form-align" id="discount" maxlength="10">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                            <span id="discount1"   style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Expires in</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="expires_in" class="form-align" id="expires_in" placeholder="Days" maxlength="20"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                            <span id="expires_in1"   style="color:#F00; font-style:oblique;"></span>
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
                                                <input type="text" name="cost_price" class=" mandatory form-align" id="cost_price" maxlength="10"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fw fa-money"></i>
                                                </div>
                                            </div>

                                            <span id="cost" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                         <label class="col-sm-4 control-label">T1 Selling Price <span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="cash_cus_price" class=" form-align" id="cash_cus_price"maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="cash_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">T3 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="cash_con_price" class=" form-align" id="cash_con_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="cash_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">T5 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="vip_price" class=" form-align" id="vip_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="vip_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">H1 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="h1_price" class=" form-align" id="h1_price" maxlength="10"/>
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
                                        <label class="col-sm-4 control-label">Sales Price&nbsp;<span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="sales_price" class="mandatory  form-align" id="sales_price" maxlength="10"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-money"></i>
                                                </div>
                                            </div>
                                            <span id="sales_price_err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>


                                    <!--<div class="form-group">
                                         <label class="col-sm-4 control-label">T2 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="credit_cus_price" class="  form-align" id="credit_cus_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="credit_cus_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>

                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">T4 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="credit_con_price" class=" form-align" id="credit_con_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="credit_con_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">T6 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="vvip_price" class=" form-align" id="vvip_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="vvip_price1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label class="col-sm-4 control-label">H2 Selling Price&nbsp;<span style="color:#F00; font-style:oblique;"></span></label>
                                         <div class="col-sm-8">
                                             <div class="input-group">
                                                 <input type="text" name="h2_price" class=" form-align" id="h2_price" maxlength="10"/>
                                                 <div class="input-group-addon">
                                                     <i class="fa fa-money"></i>
                                                 </div>
                                             </div>
                                             <span id="h2_priceerr" class="val"  style="color:#F00; font-style:oblique;"></span>
                                         </div>
                                     </div>-->
                                </div>
                            </div>
                            <input type="hidden" name="CategoryId" value="" id="CategoryId"/>
                            <input type="hidden" name="BrandId" value="" id="BrandId"/>
                            <div class="inner-sub-tit">Tax Details</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">CGST % <span style="color:#F00; font-style:oblique;"></span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="cgst" class=" form-align" id="cgst"/>
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
                                                <input type="text" name="sgst" class=" form-align" id="sgst"/>
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
                                                <input type="text" name="igst" class=" form-align" id="igst"/>
                                                <div class="input-group-addon">
                                                    <i class="fa fa-tag"></i>
                                                </div>
                                            </div>
                                            <span id="igst1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="frameset_table action-btn-align">
                                <input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" />
                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" />
                                <a href="<?php echo $this->config->item('base_url') . 'masters/products/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="field-agent-details">
                        <div class="frameset_big1">
                            <table id="example" class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer aln-right sale_right" cellspacing="0" width="100%">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th width="5%" class='action-btn-align'>S.No</th>
                                        <th width="20%" style="text-align:center;">Shop Name</th>
                                        <th width="15%" style="text-align:center;">Product Name</th>
                                        <th width="12%" style="text-align:center;">Category Name</th>
                                        <th width="12%" style="text-align:center;">Model Name</th>
                                       <!-- <th width="7%">Type</th> -->
                                       <!-- <th width="10%">Quantity</th> -->
                                        <th width="10%" style="text-align:center;">Cost price</th>
                                        <th width="10%" style="text-align:center;">Sale price</th>
                                        <th width="10%" class="action-btn-align" style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="action-btn-align">
                <button class="btn btn-success excel" id="excel_report"><span class="glyphicon glyphicon-print"></span> Excel</button>
                <button type="button" class="btn btn-primary add_bluk_import"> Import Products</button>
                <!--<button type="button" class="btn btn-success " style="float:right; margin-right: 15px;"> Export Barcode</button>-->
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">Import Products</h6>
            </div>
            <form action="<?php echo $this->config->item('base_url'); ?>masters/products/import_products" enctype="multipart/form-data" name="import_products" method="post" id="import_form">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Attachment:</strong></label>
                                    <input type="file" name="product_data" id="product_data" class="form-control product_data_csv" onchange="return fileValidation()">
                                    <span class="error_msg"></span>
                                    <a href="<?php echo $this->config->item('base_url') . 'attachement/csv/sample_product.csv'; ?>" download><i class="fa fa-download"></i>&nbsp; Sample File</a>


                                    <span style="color:red;    margin-left: 117px;" class=" csv_error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Skip Rows:</strong></label>
                                    <input type="text" name="skip_rows" id="skip_rows" class="form-control" value="0">
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="import" class="btn btn-success">Submit</button>
                    <button type="button" name="cancel" id="cancel" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div id="barcode_ex" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title">Export Barcode</h6>
            </div>
            <form action="<?php echo base_url(); ?>masters/products/barcode_pdf" enctype="multipart/form-data" name="export_bar" method="post" id="export_bar">

                <input type="hidden" name="ime_code_id" value="" name="ime_codes" />
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Type:</strong></label>
                                    <select id="barcode_type" name="barcode_type" class="form-control">
                                        <option value="0">Select Type</option>
                                        <option value="1">Product</option>
                                        <option value="2">IMIE </option>
                                    </select>
                                    <span class="error_msg"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>How Many Product Barcods:</strong></label>
                                    <input type="text" name="count" id="no_of_number" class="form-control" value="0">
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name=""  onclick="data_exports()" class="btn btn-success">Submit</button>
                    <button type="button" name="cancel" id="cancel" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br />

<?php
//if (isset($product) && !empty($product)) {
//foreach ($product as $val) {
?>
<div id="test" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
    <div class="modal-dialog">
        <div class="modal-content modalcontent-top">
            <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                <h3 id="myModalLabel" class="inactivepop">In-Active Product</h3>
            </div>
            <div class="modal-body">
                Do You Want In-Active This Product?<p id="pro_name" style="font-weight: bold;"><?php echo $val['product_name']; ?></p>
                <input type="hidden" id="pro_id" value="" class="id" />
            </div>
            <div class="modal-footer action-btn-align">
                <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
            </div>
        </div>
    </div>
</div>
<?php
// }
//}
?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
                        var table;

                        jQuery(document).ready(function () {

                            //datatables
                            table = jQuery('#example').DataTable({
                                "processing": true, //Feature control the processing indicator.
                                "serverSide": true, //Feature control DataTables' server-side processing mode.
                                "order": [], //Initial no order.
                                //dom: 'Bfrtip',
                                // Load data for the table's content from an Ajax source
                                "ajax": {
                                    "url": "<?php echo site_url('masters/products/ajaxList/'); ?>",
                                    "type": "POST",
                                },
                                //Set column definition initialisation properties.
                                "columnDefs": [
                                    {
                                        "targets": [0, 7], //first column / numbering column
                                        "orderable": false, //set not orderable
                                    },
                                    {className: 'text-center', targets: [1, 2, 3, 4, 5, 6, 7]},
                                ],
                            });

                        });


                        function check(p_id)
                        {

                            $('#pro_id').val(p_id);
                            $('#pro_name').text($('#delete_' + p_id).attr('pro_name'));
                            $('#test').modal('show');
                        }

</script>
<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('.add_bluk_import').click(function () {
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#myModal').modal('show');
    });

    $('#import').click(function () {
        $('#import_products').submit();
    });

    $("#import_form").submit(function (event) {

        var data = $('.product_data_csv').val();
        if (data == "") {
            $('.csv_error').text('Please Upload File');
            return false;
        } else {
            var valid_csv = $('.csv_error').text();
            if (valid_csv == "Invalid File Format") {
                $('.csv_error').text('Invalid File Format');
                return false;
            } else {
                $('.csv_error').text(' ');

                return true;
            }



        }



    });


    function fileValidation() {
        var fileInput = document.getElementById('product_data');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.csv)$/i;
        if (!allowedExtensions.exec(filePath)) {
            $('.csv_error').text('Invalid File Format');

            return false;
        } else {
            $('.csv_error').text(' ');

        }
    }

    $(document).on('click', '.export_barcode', function () {

        barcode_id = $(this).attr('barcode_id');
        product_id = $(this).attr('product_id');
        product_name = $(this).attr('product_name');


        $('#barcode_ex').modal({
            backdrop: 'static',
            keyboard: false

        });

        $('#barcode_ex').modal('show');
        $('#no_of_number').append('<input type="hidden" name="barcode_id" value="' + barcode_id + '"/>');
        $('#no_of_number').append('<input type="hidden" id="product_id" name="product_id" value="' + product_id + '"/>');
        $('#no_of_number').append('<input type="hidden" id="product_name" name="product_name" value="' + product_name + '"/>');


    });






    /*  $.ajax({
     type: 'POST',
     data: {product_id: product_id},
     url: '<?php echo base_url(); ?>masters/products/check_imie_code_available',
     success: function (result) {

     if(result==1){
     $('#barcode_ex').modal({
     backdrop: 'static',
     keyboard: false
     });
     $('#barcode_ex').modal('show');
     $('#no_of_number').append('<input type="hidden" name="barcode_id" value="' + barcode_id + '"/>');
     $('#no_of_number').append('<input type="hidden" id="product_id" name="product_id" value="' + product_id + '"/>');

     }else{
     toastr.clear();
     toastr.error("Sorry!! IMIE Code Not Available..Please Purchase Products",'Warning Message.!');
     }
     }
     });*/
    /* if ($.trim(barcode_id) != '') {
     $('#barcode_ex').modal({
     backdrop: 'static',
     keyboard: false
     });
     $('#barcode_ex').modal('show');

     // $('#ime_code_id').val(product_id);
     $('#no_of_number').append('<input type="hidden" name="barcode_id" value="' + barcode_id + '"/>');
     $('#no_of_number').append('<input type="hidden" name="product_id" value="' + product_id + '"/>');
     } else {
     alert("No barcode available for this product. Please add(UPC) it in Edit products page.")
     }*/


    //$('#export').click(function () {
//        barcode_id = $('#barcode_ex').attr('barcode');
//        count = $('#no_of_number').val();
//        alert(barcode_id);
//        $.ajax({
//            type: 'POST',
//            data: {barcode: barcode_id, count: count},
//            url: '<?php echo base_url(); ?>masters/products/barcode_pdf',
//            success: function (filename) {
//            }
//        });








    // });

    $(document).on('click', '.barcode', function () {

        $.ajax({
            type: 'POST',
            data: {barcode: barcode_id},
            url: '<?php echo base_url(); ?>masters/products/save_barcode/',
            success: function (filename) {
                if (filename != '') {
                    var a = document.createElement('a');
                    a.href = '<?php echo base_url(); ?>attachement/barcode/' + filename;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }
            }
        });
    });

    $(document).ready(function ()
    {
        $('#category').select2();
        $('#brand').select2();
        var firm = $("#firm").val();
        Firm(firm);

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
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);
                $(input).closest('div').find('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function data_exports() {
        var product_id = $('#product_id').val();
        var count = $('#no_of_number').val();
        var barcode_type = $('#barcode_type').val();
        var product_name = $('#product_name').val();

        if (barcode_type == 0) {
            toastr.clear();
            toastr.error("Please Select Barcode Type", 'Warning Message.!', {
                positionClass: "toast-top-center"
            });
        } else if (count == 0 || count == "") {
            toastr.clear();
            toastr.error("Plese add number of bardcode you want to generate", 'Warning Message.!', {
                positionClass: "toast-top-center"
            });
        } else {

            if (barcode_type == 1) {
                $('#export_bar').submit();
            } else {
                $.ajax({
                    type: 'POST',
                    data: {product_id: product_id, count: count, product_name: product_name},
                    url: '<?php echo base_url(); ?>masters/products/check_imiecode_availability',
                    success: function (result) {

                        if (result == 1) {
                            $('#export_bar').submit();
                        } else {
                            toastr.clear();
                            toastr.error(result, 'Warning Message.!', {
                                positionClass: "toast-top-center"
                            });
                        }

                    }
                });
            }

        }
    }


    $(".imgInp").on('change', function () {
        readURL(this);
    });
    $("#pname").on('blur', function ()
    {
        var name = $("#pname").val();
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#perror").html("Required Field");
            return false;
        } else
        {
            $("#perror").html("");
        }
    });

    $("#hsn_number").on('blur', function ()
    {
        var hsn_number = $("#hsn_number").val();

        if (hsn_number == "" || hsn_number == null || hsn_number.trim().length == 0)
        {
            // $("#hsn_number1").html("Required Field");
            return false;
        } else
        {
            $("#hsn_number1").html("");
        }
    });


    $("#unit").on('blur', function ()
    {
        var unit = $("#unit").val();
        if (unit == "" || unit == null || unit.trim().length == 0)
        {
            // $("#unit1").html("Required Field");
            return false;
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
            return false;
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
            // $("#cgst1").html("Required Field");
            // i = 1;
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
        if (sgst == "")
        {
            // $("#sgst1").html("Required Field");
            // i = 1;
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
            // i = 1;
        } else if (!nfilter.test(sgst))
        {
            $("#igst1").html("Enter Valid Amount");
            i = 1;
        } else
        {
            $("#igst1").html("");
        }
    });


    $("#cash_cus_price").on('blur', function ()
    {
        var cash_cus_price = $("#cash_cus_price").val();
        var nfilter = /^[0-9]*\.?[0-9]*$/;
        if (cash_cus_price == "" || cash_cus_price == null || cash_cus_price.trim().length == 0)
        {
            //$("#cash_cus_price1").html("Required Field");
            // i = 1;
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
            // $("#credit_cus_price1").html("Required Field");
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
            // $("#cash_con_price1").html("Enter Valid Price");
            // i = 1;
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
            // $("#vip_price1").html("Required Field");
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
            //  $("#vvip_price1").html("Required Field");
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
            //$("#h1_priceerr").html("Required Field");
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
            // $("#h2_priceerr").html("Required Field");
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
    $(document).ready(function () {



        $('#category').on('change', function () {

            $('#CategoryId').val(this.value);
        });

        $('#brand').on('change', function () {

            $('#BrandId').val(this.value);
        });


        $("#submit").on('click', function () {
            var cat_id = $('#category').val();
            //alert(cat_id);
            var pname = $.trim($("#pname").val());
            var firm_id = $.trim($("#firm").val());

            m = 0;

            if (m == 0)
            {
                $('.mandatory').each(function (i) {
                    this_val = $.trim($(this).val());
                    this_id = $(this).attr('id');
                    this_id_first = "";
                    if (i == 0) {
                        this_id_first = $(this).attr('id');
                    }

                    if (this_id != 's2id_category' && this_id != 's2id_brand')
                    {
                        if (this_val.length == 0) {
                            console.log(this_id);


                            $(this).closest('div.form-group').find('span.val').text('Required Field').css('display', 'inline-block');

                            m++;

                            $('#' + this_id_first + '').focus();
                        } else {

                            $(this).closest('div.form-group').find('span.val').text('').css('display', 'none');
                        }
                    }

                });
            }

            if (pname == "" || pname == null || pname.trim().length == 0)
            {
                $(".product_error").html("Required Field");
                m++;
                $('#pname').focus();
            } else
            {
                $(".product_error").html("");
            }

            if ($.trim(pname) != '') {
                $.ajax(
                        {
                            url: BASE_URL + "masters/products/add_duplicate_product",
                            type: 'POST',
                            async: false,
                            data: {pname: pname, firm_id: firm_id},
                            success: function (result)
                            {
//                                alert(result);
                                if (result == 0)
                                {
                                    //alert(result);
                                    //$('.error_msg').html() == 'Product Name already Exist';
                                    $('.product_error').css('display', 'inline-block');
                                    $('.product_error').html('Product Name already Exist');
                                    m++;
                                }

                            }
                        });
            }



            if (m > 0) {
                return false;
            } else {

                //  alert(m);
                return true;


            }
        });
    });</script>
<!--<script>
    $("#model_no").on('blur', function ()
    {
        email = $.trim($("#model_no").val());
        if (email != '') {
            $.ajax(
                    {
                        url: BASE_URL + "masters/products/add_duplicate_product",
                        type: 'get',
                        data: {value1: email},
                        success: function (result)
                        {
                            $("#dup").html(result);
                        }
                    });
        }
    });
</script>-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "masters/products/delete_product",
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
<style>
    .error_msg{
        color:#F00; font-style:oblique;
    }
</style>
