<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
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
                    <h3> <?= $company_details[0]['firm_name'] ?></h3>
                    <p></p>
                    <p class="pf">  <?= $company_details[0]['address'] ?>,
                    </p>
                    <p></p>
                    <p class="pf"> Pin Code : <?= $company_details[0]['pincode'] ?>,</p>
                    <p></p>
                </div>
            </td>
        </tr>
    </table>
</div>
<!--<div class="print_header">
    <table width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
            </td>
            <td width="85%">
                <div class="print_header_tit" >
                    <h3>The Total</h3>
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
</div>-->
<div class="mainpanel">
    <div class="media mt--20">
        <h4>Sales Receipt List </h4>
    </div>
    <div class="contentpanel mb-45">

        <table class="table table-striped table-bordered responsive no-footer dtr-inline search_table_hide" style="display:none;">

            <tr>


                <td>Supplier
                    <input type="hidden" name="po_no" id="po_no" autocomplete="off" style="width:150px"/>
                    <select id='state' style="width: 170px;">
                        <option>Select</option>
                        <?php
                        if (isset($all_state) && !empty($all_state)) {
                            foreach ($all_state as $val) {
                                ?>
                                <option value='<?= $val['id'] ?>'><?= $val['state'] ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select id='supplier'  class="form-control" style="width: 170px;">
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
                </td>
                <td>From Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td>To Date</td>
                <td>
                    <div class="input-group" style="width:70%;">
                        <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >

                    </div>
                </td>
                <td><a style="float:right;" id='search' class="btn btn-default">Search</a></td>
            </tr>
        </table>
        <div id='result_div' class="panel-body">
            <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline invamt-right paidamt-right disamt-right balnce-right duedate-cntr paystatus-cntr paiddate-cntr">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td class='action-btn-align'>Invoice #</td>
                        <td class="action-btn-align">Customer Name</td>
                        <td class="action-btn-align">Invoice Amount</td>
                        <td class="action-btn-align">Paid Amount</td>
                        <td class="action-btn-align">Discount Amount</td>
                        <td >Balance</td>
                        <td >Invoice Date</td>
                        <td >Paid Date</td>
                        <td >Due Date</td>
                        <td >Payment Status</td>
                        <td >Action</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text_right total-bg"><?= number_format($inv, 2, '.', ',') ?></td>
 <!--<td class="text_right total-bg"><?= number_format($advance, 2, '.', ',') ?></td>-->
                        <td class="text_right total-bg"><?= number_format(($paid + $advance), 2, '.', ',') ?></td>
                        <td></td>
                        <td class="text_right total-bg"><?= number_format($bal, 2, '.', ',') ?></td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class="hide_class"></td>
                        <td class="hide_class"></td>
                        <td class="hide_class"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
            </div>

        </div>

        <script>
            $(document).on('click', '.alerts', function () {
                sweetAlert("Oops...", "This Access is blocked!", "error");
                return false;
            });
            $('.print_btn').click(function () {
                window.print();
            });
        </script>
    </div><!-- contentpanel -->

</div><!-- mainpanel -->

<?php
if (isset($all_gen) && !empty($all_gen)) {
    foreach ($all_gen as $val) {
        ?>
        <form method="post" action="<?= $this->config->item('base_url') . 'po/force_to_complete/1' ?>">
            <div id="com_<?= $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header"><a class="close" data-dismiss="modal">×</a>
                            <h4 style="color:#06F">Force to Complete</h4>
                            <h3 id="myModalLabel">
                        </div>
                        <div class="modal-body">

                            <strong>
                                Are You Sure You Want to Complete This PO ?
                            </strong>
                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                <tr>
                                    <td width="40%" style="text-align:right;" class="first_td1">Remarks&nbsp;</td>
                                    <td>
                                        <input type="text" style="width:220px;" class="form-control" name='complete_remarks' />
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="update_id" value="<?= $val['id'] ?>"  />

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary delete_yes yesin" id="yesin">Yes</button>
                            <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no"> No</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery('.datepicker').datepicker();


        var table;
        table = jQuery('#basicTable_call_back').DataTable({
            "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('sales_receipt/ajaxList/'); ?>",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 11], //first column / numbering column
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

                    console.log("success : " + total);

                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
                        pageTotal = pageTotal;

                    } else {
                        pageTotal = pageTotal.toFixed(2);/* float */

                    }
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

    });
    $().ready(function () {
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
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                state: $('#state').val(),
                supplier: $('#supplier').val(),
                supplier_name: $('#supplier').find('option:selected').text(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_div').html('').html(result);
            }
        });
    });



</script>
<script src="<?= $theme_path; ?>/js/fixedheader/jquery.dataTables.min.js"></script>