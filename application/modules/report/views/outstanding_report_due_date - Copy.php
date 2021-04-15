<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<script type='text/javascript' src='<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/js/auto_com/jquery.autocomplete.css" />
<style>
    .text_right { text-align:right !important;}
</style>
<script src="<?php echo $theme_path; ?>/js/angular.min.js"></script>
<div class="mainpanel">
    <div class="media mt--20">
        <h4>Outstanding Report - Due Date Wise</h4>
    </div>
    <div class="panel-body">
        <div class="row search_table_hide search-area">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Firm</label>
                    <select id='firm' class="form-control">
                        <option value="">Select</option>
			<?php
			if (isset($firms) && !empty($firms)) {
			    foreach ($firms as $val) {
				?>
				<option value='<?= $val['firm_id'] ?>'><?= $val['firm_name'] ?></option>
				<?php
			    }
			}
			?>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Customer Type</label>
                    <select id='cust_type' class="form-control">
                        <option value="">Select</option>
			<option value="1">T1</option>
			<option value="2">T2</option>
			<option value="3">T3</option>
			<option value="4">T4</option>
			<option value="5">T5</option>
			<option value="6">T6</option>
			<option value="7">H1</option>
			<option value="8">H2</option>
			<option value="9">All</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Customer Region</label>
                    <select id='cust_reg'  class="form-control">
                        <option value="">Select</option>
			<option value="local">Local Customers</option>
			<option value="non-local">Non-Local Customers</option>
			<option value="both">Both</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group mcenter">
                    <label class="control-label col-md-12 mnone">&nbsp;</label>
                    <a id='search' class="btn btn-success  mtop4"><span class="glyphicon glyphicon-search"></span> Search</a>
                    <a class="btn btn-danger1  mtop4" id="clear"><span class="fa fa-close"></span> Clear</a>
                </div>
            </div>
        </div>
    </div>

    <div class="contentpanel mt-10">
        <div  class="panel-body">
            <div class="" ng-app="multiLanguageApp" ng-controller="multiLanguageController">
                <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline result_div">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td>Customer Name</td>
                            <td class="action-btn-align">Mobile</td>
                            <td class="action-btn-align">0 to 7 days</td>
                            <td class="action-btn-align">> 7 to 30 days</td>
                            <td class="action-btn-align">> 30 to 90 days</td>
                            <td class="action-btn-align">> 90 days</td>
                            <td class="action-btn-align">Net Balance</td>
                        </tr>
                    </thead>
                    <tbody>
			<?php
			?>
			<tr ng-repeat="customer in customers">
			    <td class="action-btn-align">{{$index + 1}}</td>
			    <td>{{customer.name}}</td>
			    <td class="action-btn-align">{{customer.mobil_number}}</td>
			    <td class="action-btn-align 7days">{{customer.days}}</td>
			    <td class="action-btn-align 7to30days">{{customer.sevendays}}</td>
			    <td class="action-btn-align 30to90days">{{customer.thirtydays}}</td>
			    <td class="action-btn-align 90days">{{customer.nintydays}}</td>
			    <td class="text_right net_balance">{{customer.net_amount}}</td>
			</tr>
			<?php
			?>
                    </tbody>
                </table>
            </div>
            <div class="action-btn-align mt-top15">
                <button class="btn btn-defaultprint6 print_btn"><span class="glyphicon glyphicon-print"></span> Print</button>
                <button class="btn btn-success excel_btn" id="excel-prt"><span class="glyphicon glyphicon-print"></span> Excel</button>
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
    </div>
</div>
<script type="text/javascript">
    report();
    function report() {
	var languageApp = angular.module("multiLanguageApp", []);
	languageApp.controller('multiLanguageController', function ($scope, $http) {
	    var url = BASE_URL + 'report/outstanding_report_due_date_result';
	    var request_data = {firm: $('#firm').val(),
		cust_type: $('#cust_type').val(),
		cust_reg: $('#cust_reg').val()}
	    $http.post(url, request_data).then(function (response) {
		console.log(response)
		$scope.customers = response.data;
	    });
	});
    }
    $('#search').live('click', function () {
	$.ajax({
	    url: BASE_URL + "report/outstanding_report_due_date_search_result",
	    type: 'POST',
	    data: {
		firm: $('#firm').val(),
		cust_type: $('#cust_type').val(),
		cust_reg: $('#cust_reg').val()
	    },
	    success: function (result) {
		for_response();
		$('.result_div').html('');
		//$('.result_tfoot').html('');
		$('.result_div').html(result);
	    }
	});
    });

</script>