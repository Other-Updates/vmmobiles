<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />

<style>
    .bg-red {background-color: #dd4b39 !important;}
    .bg-green { background-color:#09a20e !important;}
    .bg-yellow{background-color:orange !important;}
    .ui-datepicker td.ui-datepicker-today a { background:#999999;}
    ul.tabs{
        margin: 0px;
        padding: 0px;
        list-style: none;
    }
    ul.tabs li{
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }


    ul.tabs li.current{
        background: #777;
        color: #fcfcfc;
        border-radius:2em;
    }


    .tab-content{
        display: none;
        background: #ededed;
        padding: 15px;
    }

    .tab-content.current{
        display: inherit;
    }
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
    .ui-datepicker td.ui-datepicker-today a {
        background:#999999;
    }
</style>
<div class="mainpanel">

    <div class="media mt--20">
        <h4>Shelf Life Report</h4>
    </div>

    <div id="tabs-1" class="tab-content current">
        <div class="panel-body mt--40">
            <div class="row search_table_hide search-area">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Firm</label>
                        <select id='firm'  class="form-control" >
                            <option>Select</option>
                            <?php
                            if (isset($firms) && !empty($firms)) {
                                foreach ($firms as $firm) {
                                    ?>
                                    <option value='<?= $firm['firm_id'] ?>'><?= $firm['firm_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Product Name</label>
                        <select id='product' class="form-control">
                            <option>Select</option>
                            <?php
                            if (isset($all_product) && !empty($all_product)) {
                                foreach ($all_product as $val) {
                                    ?>
                                    <option value='<?= $val['id'] ?>'><?= $val['product_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Category</label>
                        <select id='category'  class="form-control">
                            <option>Select</option>
                            <?php
                            if (isset($category) && !empty($category)) {
                                foreach ($category as $cat) {
                                    ?>
                                    <option value='<?= $cat['cat_id'] ?>'><?= $cat['categoryName'] ?></option>

                                    <?php
                                }
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">From Date</label>
                        <input type="text" id='from_date'  class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">To Date</label>
                        <input type="text"  id='to_date' class="form-control datepicker" name="inv_date" placeholder="dd-mm-yyyy" >
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mcenter">
                        <label class="control-label col-md-12 mnone">&nbsp;</label>
                        <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search "></span> Search</a>
                        <a class="btn btn-danger1 mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contentpanel">
            <div class="panel-body mt-top5">
                <div class="">
                    <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline result_div">
                        <thead>
                            <tr>
                                <td class="action-btn-align">S.No</td>
                                <td class="action-btn-align">Firm</td>
                                <td class='action-btn-align'>Product Name</td>
                                <td class="action-btn-align">Category</td>
                                <td class="action-btn-align">Brand</td>
                                <td class="action-btn-align">Quantity</td>
                                <td class="action-btn-align">Expiration Days</td>
                                <td class="action-btn-align">Expired Date</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($all_product) && !empty($all_product)) {
                                $i = 1;
                                foreach ($all_product as $val) {
                                    ?>
                                    <tr>
                                        <td class='first_td action-btn-align'><?php echo $i ?></td>
                                        <td><?php
                                            if (isset($firms) && !empty($firms)) {
                                                foreach ($firms as $firm) {
                                                    if ($firm['firm_id'] == $val['firm_id']) {
                                                        echo $firm['firm_name'];
                                                    }
                                                }
                                            }
                                            ?></td>
                                        <td class='action-btn-align'><?php echo $val['product_name'] ?></td>
                                        <td  class="text_right"><?php
                                            if (isset($category) && !empty($category)) {
                                                foreach ($category as $cat) {
                                                    if ($cat['cat_id'] == $val['category_id']) {
                                                        echo $cat['categoryName'];
                                                    }
                                                }
                                            }
                                            ?></td>
                                        <td  class="text_right"><?php
                                            if (isset($brand) && !empty($brand)) {
                                                foreach ($brand as $brandd) {
                                                    if ($brandd['id'] == $val['brand_id']) {
                                                        echo $brandd['brands'];
                                                    }
                                                }
                                            }
                                            ?></td>
                                        <td  class="text_right"><?php echo $val['qty']; ?></td>
                                        <td  class="text_right"><?php echo $val['expires_in']; ?></td>
                                        <td  class="text_right"><?php echo (!empty($val['expired_date']) && $val['expired_date'] != '0000-00-00') ? $val['expired_date'] : '-'; ?></td>

                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text_right total-bg"></td>
                                <td class="hide_class"></td>
                                <td class="hide_class"></td>

                            </tr>
                        </tfoot>

                    </table>
                </div>
                <div class="action-btn-align mb-10">
                    <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                    <button class="btn btn-success excel_btn1" ><span class="glyphicon glyphicon-print"></span> Excel</button>
                </div>
            </div>

        </div>
    </div>

</div>


<script>
    $('.print_btn').click(function () {
        window.print();
    });
    $('#clear').live('click', function ()
    {
        window.location.reload();
    });

</script>
</div><!-- contentpanel -->

</div><!-- mainpanel -->
<script type="text/javascript">


    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
    });
    $(document).ready(function () {
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
            url: BASE_URL + "report/shelf_life_search_result",
            type: 'GET',
            data: {
                firm: $('#firm').val(),
                product: $('#product').val(),
                category: $('#category').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('.result_div').html('');
                $('.result_div').html(result);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#basicTable_call_back').DataTable({
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
                var cols = [5];
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

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
        $("#yesin").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            // alert(hidin);
            $.ajax({
                url: BASE_URL + "Project_cost_model/quotation_delete",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "Project_cost_model/quotation_list");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
<script>
    $('.excel_btn1').live('click', function () {
        fnExcelReport2();
    });
</script>
<script>
    function fnExcelReport2()
    {
        var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('basicTable_call_back'); // id of table
        for (j = 0; j < tab.rows.length; j++)
        {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            //tab_text=tab_text+"</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
        } else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        return (sa);
    }
</script>



<script>
    $(document).ready(function () {

        $('ul.tabs li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        })

    });
</script>


