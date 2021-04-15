<?php
$filename = "system_stock_report.xls";
header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Pragma: no-cache');
header('Expires: 0');
?>
<style type="text/css">
    table { border:1px #848484 solid; border-collapse:collapse; }
    table th,td { border:1px #848484 solid; text-align:center; padding: 15px }
</style>



<table class="table">
    <thead>
	<tr>
	    <td width='20%'>Firm Name</td>
	    <td width='15%'>Category</td>
	    <td width='15%'>Product Name</td>
	    <td width='5%'>Brand</td>
	    <td width='10%'>System Quantity</td>
	    <td width='10%'>Physical Quantity</td>

	</tr>
    </thead>
    <tbody id='result_div'>
	<?php
	if (isset($stock) && !empty($stock)) {

	    foreach ($stock as $val) {
		?>
		<tr>

		    <td><?php echo $val['firm_name']; ?></td>
		    <td><?php echo $val['categoryName']; ?></td>
		    <td><?php echo $val['product_name']; ?></td>
		    <td><?php echo $val['brands']; ?></td>
		   <!--  <td><?= $val['model_no']; ?></td> -->

		    <td class="action-btn-align"><?php echo $val['quantity']; ?></td>
		    <td></td>
		</tr>

		<?php
	    }
	}
	?>
    </tbody>
</table>

