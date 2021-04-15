<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?php echo $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<link href="<?php echo $theme_path; ?>/plugin/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/css/fSelect.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">
<script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
<style>
    .bg-red {
        background-color: #dd4b39 !important;
    }
    .bg-green {
        background-color:#09a20e !important;
    }
    .bg-yellow
    {
        background-color:orange !important;
    }
</style>
<div class="mainpanel">
    <div class="media mt--20">
        <h4>Stock List</h4>
    </div>
    <div class="panel-body pnone">
        <div class="row search_table_hide mb-0">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Category</label>
                    <div class="col-sm-8">
                        <select id='category' class="form-control">
                            <option value="">Select</option>
                            <?php
                            if (isset($cat) && !empty($cat)) {
                                foreach ($cat as $val) {
                                    ?>
                                    <option value='<?= $val['cat_id'] ?>'><?= $val['categoryName'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Product</label>
                    <div class="col-sm-8 wid100-div">
                        <select id='product' name="product[]" class="form-control multi_select wid100" multiple="multiple">
                            <option>Select</option>
                            <?php
                            if (isset($product) && !empty($product)) {
                                foreach ($product as $val) {
                                    ?>
                                    <option value='<?= $val['id'] ?>'><?= $val['product_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4"><a id='search' class="btn btn-success"><span class="glyphicon glyphicon-search "></span> Search</a></div>
        </div>
    </div>
    <div class="contentpanel mb-50">
        <div  class="panel-body mt-top5">
            <table id="example1" class="display dataTable table table-striped table-bordered responsive dataTable dtr-inline no-footer " cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>inv_id</th>
                        <th>q_id</th>
                        <th>customer</th>
                        <th>sales_man</th>
                        <th>total_qty</th>
                        <th>subtotal_qty</th>
                    </tr>
                </thead>
                <tbody id="result_div">

                </tbody>
                <tfoot class="hide_class">
                    <tr>
                        <td width='5%'></td>
                        <td width='20%'></td>
                        <td width='15%'></td>
                        <td width='15%'></td>
                        <td width='10%' class="total-bg action-btn-align"></td>
                        <td width='10%' class="total-bg action-btn-align"></td>
                    </tr>
                </tfoot>
            </table>

            <div class="action-btn-align">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <button class="btn btn-success excel" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/plugin/datatables/js/buttons.print.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/fSelect.js'></script>
<script type="text/javascript">
    var table;
    jQuery(document).ready(function () {
        //datatables
        var product = $('#product').val();
        var category = $('#category').val();
        var inventory = 1;
        table = jQuery('#example1').DataTable({
            // "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('stock/ajaxtestList/'); ?>",
                "type": "POST",
                //"data": {"product": product, "category": $('#category').val(), "inventory": 1}
            },
            //Set column definition initialisation properties.

            "columnDefs": [
                {
                    "targets": [0, 5], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                // Total over all pages
                var cols = [4, 5];
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    // Update footer
                    $(api.column(cols[x]).footer()).html(pageTotal);
                }

            },
        });


    });
</script>

<script>
    $(document).ready(function ()
    {
        //$('.purchase_link').text('');
        $('.multi_select').fSelect();
        var arr = [];
        $('#excel-prt').on('click', function ()
        {

            arr.push({'category': $('#category').val()});
            arr.push({'product': $('#product').val()});
            var arrStr = JSON.stringify(arr);
            window.location.replace('<?php echo $this->config->item('base_url') . 'stock/excel_report?search=' ?>' + arrStr);
        });
    });</script>
<script>
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });

    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').on('click', function () {
        // alert(1);
        for_loading();
        $.ajax({
            url: BASE_URL + "stock/stock_search_result",
            type: 'GET',
            data: {
                product: $('#product').val(),
                category: $('#category').val(),
                inventory: 1,
            },
            success: function (result) {
                //alert(result);
                for_response();
                $('#result_div').html('');
                $('#result_div').html(result);
            }
        });
    });


    jQuery(document).on('click', "#example1 .fa.fa-edit", function () {

        $(this).removeClass().addClass("fa fa-check");
        var value = $(this).closest('tr').find('td:last').prev().html();

        $(this).closest('tr').find('td:last').prev().html('<form id="new"><input class="thVal form-control"  name="quantity" type="text" value="' + value.replace(/,/g, '') + '" onkeypress="return isNumber(event, this)" style="width:70px;" /></form>');
        // shrinkage_id = $(this).closest('tr').find('td:first input.shrinkage_id').val();

        //updateVal(stock_id);
    });

    jQuery(document).on('click', "#example1 .fa.fa-check", function () {

        $this_ = $(this);
        $(this).removeClass().addClass("fa fa-edit");
        var stock_id = $(this).closest('a').attr('stock_id');
        var qty = $(this).closest('tr').find('td:last').prev().find('input').val();

        $.ajax({
            url: BASE_URL + "stock/stock_update",
            type: 'POST',
            data: {
                quantity: qty,
                id: stock_id
            },
            success: function (result) {

                $this_.closest('tr').find('td:last').prev().html('' + qty + '');

            }
        });
    });


    function isNumber(evt, this_ele) {
        this_val = $(this_ele).val();
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.which == 13) {//Enter key pressed
            $(".thVal").blur();
            return false;
        }
        if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {
            return false;
        } else {
            return true;
        }

    }
</script>

