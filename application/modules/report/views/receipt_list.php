<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>



<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>



<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>



<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>



<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />



<script type='text/javascript' src='<?= $theme_path; ?>/js/jquery.table2excel.min.js'></script>



<style>



    .ui-datepicker td.ui-datepicker-today a {background:#999999;}



    .btn-group > .btn, .btn-group-vertical > .btn { border-width: 0px!important;}

    table tbody tr td:last-child {

        border: 0px !important;

    }

</style>



<?php

$this->load->model('admin/admin_model');



$data['company_details'] = $this->admin_model->get_company_details();

?>



<div class="print_header">



    <table width="100%">



        <tr>



            <td width="15%" style="vertical-align:middle;">



                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>



            </td>



            <td width="85%">



                <div class="print_header_tit" >



                      <h3><?= $data['company_details'][0]['company_name'] ?></h3>



                    <p>



                        <?= $data['company_details'][0]['address1'] ?>,



                        <?= $data['company_details'][0]['address2'] ?>,



                    </p>



                    <p></p>



                    <p><?= $data['company_details'][0]['city'] ?>-



                        <?= $data['company_details'][0]['pin'] ?>,



                        <?= $data['company_details'][0]['state'] ?></p>



                    <p></p>



                    <p>Ph:



                        <?= $data['company_details'][0]['phone_no'] ?>, Email:



                        <?= $data['company_details'][0]['email'] ?>



                    </p>



                </div>



            </td>



        </tr>



    </table>



</div>



<div class="mainpanel">



    <div class="media mt--20">



        <h4>Purchase Payment List </h4>



    </div>



    <div class="panel-body">



        <div class="row search_table_hide search-area">



            <div class="col-md-2">



                <div class="form-group">



                    <label class="control-label">PO NO</label>



                    <select id='q_no' class="form-control">



                        <option>Select</option>



                        <?php

                        if (isset($all_style) && !empty($all_style)) {



                            foreach ($all_style as $val) {

                                ?>



                                <option value='<?= $val['po_no'] ?>'><?= $val['po_no'] ?></option>



                                <?php

                            }

                        }

                        ?>



                    </select>



                </div>



            </div>



            <div class="col-md-2">



                <div class="form-group">



                    <label class="control-label">Customer Name</label>



                    <select id='customer'  class="form-control">



                        <option>Select</option>



                        <?php

                        if (isset($all_supplier) && !empty($all_supplier)) {



                            foreach ($all_supplier as $val) {

                                ?>



                                <option value='<?= $val['id'] ?>'><?= $val['store_name'] ?></option>



                                <?php

                            }

                        }

                        ?>



                    </select>



                </div>



            </div>



            <div class="col-md-2">



                <div class="form-group">



                    <label class="control-label">From Date</label>



                    <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">



                </div>



            </div>



            <div class="col-md-2">



                <div class="form-group">



                    <label class="control-label">To Date</label>



                    <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy">



                </div>



            </div>



            <div class="col-md-2">



                <div class="form-group mcenter">



                    <label class="control-label col-md-12 mnone">&nbsp;</label>



                    <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search"></span> Search</a>



                    <a class="btn btn-danger1  mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>



                </div>



            </div>



        </div>



    </div>



    <div class="contentpanel">



        <div  class="panel-body mt-top5">



            <div class="">



                <table id="myTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline result_div



                       purinvamount-right purpaidamt-right purdisamt-right purbalance-right purduedate-cntr purcreatedate-cntr pursatatus-cntr">



                    <thead>



                        <tr>



                            <td class="action-btn-align">S.No</td>



                            <td class="action-btn-align">PO #</td>



                            <td>Customer Name</td>



                            <td>Invoice Amount</td>



                            <td>Paid Amount</td>



                            <td>Discount Amount</td>



                            <td>Balance</td>



                            <td class="action-btn-align">Due Date</td>



                            <td class="action-btn-align">Created Date</td>



                            <td class=" action-btn-align noExl">Payment Status</td>



                            <td class="hide_class action-btn-align noExl">Action</td>



                        </tr>



                    </thead>



                    <tbody>



                        <?php

                        $paid = $bal = $inv = 0;







                        if (isset($all_receipt) && !empty($all_receipt)) {



                            $i = 1;

                            $over_all_net_total = 0;

                            foreach ($all_receipt as $val) {



                                $inv = $inv + $val['net_total'];



                                $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];



                                $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));



                                $deliver_qty = $val['delivery_qty'];



                                $per_cost = $val['per_cost'];



                                $gst = $val['tax'];



                                $cgst = $val['gst'];



                                $net_total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst / 100) + (($deliver_qty * $per_cost) * $cgst / 100) - $val['discount'] + $val['transport'];



                                $over_all_net_total += $net_total;

                                ?>



                                <tr>



                                    <td class='first_td action-btn-align'><?= $i ?></td>



                                    <td class="action-btn-align"><?= $val['po_no'] ?></td>



                                    <td><?= $val['store_name'] ?></td>



                                    <td  class="text_right"><?= number_format($val['net_total'], 2, '.', ',') ?></td>



                                    <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',') ?></td>



                                    <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',') ?></td>



                                    <td  class="text_right"><?= number_format(($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',') ?></td>



                                    <td class="action-btn-align"><?= ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-'; ?></td>



                                    <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>



                                    <td class="hide_class action-btn-align payment_data">



                                        <?php

                                        if ($val['payment_status'] == 'Pending') {



                                            echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';

                                        } else {



                                            echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';

                                        }

                                        ?>



                                    </td>



                                    <td  class="hide_class action-btn-align noExl">



                                        <a href="<?php echo $this->config->item('base_url') . 'purchase_receipt/view_receipt/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>



                                    </td>



                                </tr>



                                <?php

                                $i++;

                            }

                            ?>



                        </tbody>



                        <tfoot class="result_tfoot">



                            <tr>



                                <td></td>



                                <td></td>



                                <td></td>



                                <td class="text_right total-bg"><?= number_format($inv, 2, '.', ',') ?></td>



                                <td class="text_right total-bg"><?= number_format($paid, 2, '.', ',') ?></td>



                                <td></td>



                                <td class="text_right total-bg"><?= number_format($bal, 2, '.', ',') ?></td>



                                <td></td>



                                <td></td>



                                <td class="hide_class"></td>



                                <td class="hide_class noExl"></td>



                            </tr>



                        </tfoot>



                    <?php }

                    ?>







                </table>



            </div>



            <div class="action-btn-align mt-top15">



                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>



                <!--<button class="btn btn-success excel_btn1" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>-->



                <div class="btn-group">



                    <button type="button" class=" btn btn-success dropdown-toggle" data-toggle="dropdown">



                        <span class="glyphicon glyphicon-print"></span> Excel



                    </button>



                    <ul class="dropdown-menu" role="menu">



                        <li><a href="#" class="excel_btn1">Current Entries</a></li>



                        <li><a href="#" id="excel-prt">Entire Entries</a></li>



                    </ul>



                </div>



            </div>







        </div>











    </div><!-- contentpanel -->







</div><!-- mainpanel -->



<div id="export_excel"></div>



<script>



    $('.print_btn').click(function () {



        window.print();



    });



    $('#clear').live('click', function ()



    {



        window.location.reload();



    });



</script>







<script type="text/javascript">



    $(document).ready(function () {



        jQuery('.datepicker').datepicker();







        var table;



        //datatables



        table = jQuery('#myTable').DataTable({

            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],

            "pageLength": 50,

            "processing": false, //Feature control the processing indicator.



            "serverSide": true, //Feature control DataTables' server-side processing mode.



            "retrieve": true,

            "order": [], //Initial no order.



            //dom: 'Bfrtip',



            // Load data for the table's content from an Ajax source



            "ajax": {

                "url": "<?php echo site_url('report/purchase_receipt_ajaxList/'); ?>",

                "type": "POST",

            },

            //Set column definition initialisation properties.



            "columnDefs": [

                {

                    "targets": [0, 10], //first column / numbering column



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



                var cols = [3, 4, 6];



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



        new $.fn.dataTable.FixedHeader(table);



        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {

            width: 260,

            autoFocus: true,

            matchContains: true,

            selectFirst: false



        });



    });



    $('#search').live('click', function () {



        for_loading();



        $.ajax({

            url: BASE_URL + "report/purchase_receipt_search_result",

            type: 'GET',

            data: {

                q_no: $('#q_no').val(),

                customer: $('#customer').val(),

                from_date: $('#from_date').val(),

                to_date: $('#to_date').val()



            },

            success: function (result) {



                for_response();



                var table = $('#myTable').DataTable();



                table.destroy();



                $('.result_div').html('');



                $('.result_div').html(result);



                datatable();







            }



        });



    });



</script>



<script>



    function datatable()



    {







        $('#myTable').DataTable({

            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],

            "pageLength": 50,

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



                var cols = [3, 4, 6];



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

            responsive: true,

            columnDefs: [

                {responsivePriority: 1, targets: 0},

                {responsivePriority: 2, targets: -2}



            ]



        });



        new $.fn.dataTable.FixedHeader(table);



    }



</script>



<script>



    $('.excel_btn1').live('click', function () {



        fnExcelReport2();



    });</script>



<script>



    function fnExcelReport2()



    {



        var tab_text = "<table id='custom_export' border='5px'><tr width='100px' bgcolor='#87AFC6'>";



        var textRange;



        var j = 0;



        tab = document.getElementById('myTable'); // id of table



        for (j = 0; j < tab.rows.length; j++)



        {



            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";



        }







        // return false;



        tab_text = tab_text + "</table>";



        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table



        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table



        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params



        $('#export_excel').show();



        $('#export_excel').html('').html(tab_text);



        $('#export_excel').hide();



        $("#custom_export").table2excel({

            exclude: ".noExl",

            name: "Purchase Receipt Report",

            filename: "Purchase Receipt Report",

            fileext: ".xls",

            exclude_img: false,

            exclude_links: false,

            exclude_inputs: false



        });











    }



    $('#excel-prt').on('click', function ()



    {



        var arr = [];



        arr.push({'q_no': $('#q_no').val()});



        arr.push({'customer': $('#customer').val()});



        arr.push({'from': $('#from_date').val()});



        arr.push({'to': $('#to_date').val()});



        var arrStr = JSON.stringify(arr);







        window.location.replace('<?php echo $this->config->item('base_url') . 'report/pr_excel_report?search=' ?>' + arrStr);



    });



</script>



<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>



<script src="<?= $theme_path; ?>/js/fixedheader/dataTables.fixedHeader.min.js"></script>



