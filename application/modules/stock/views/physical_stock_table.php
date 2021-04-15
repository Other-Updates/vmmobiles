<table id="basicTable" class="display dataTable table table-striped table-bordered responsive dtr-inline no-footer " cellspacing="0" width="100%">
    <thead>
	<tr>
	    <td width='5%' class="action-btn-align">S.No</td>
	    <td width='20%'>Entry Date</td>
	    <td width='15%'>Entry Document</td>
	    <td width='10%'>Shrinkage value</td>
	    <td width='10%'>Shrinkage Rate</td>
	    <td width='10%'>Action</td>

	</tr>
    </thead>
    <tbody id='result_div'>
	<?php
	if (isset($shrinkage) && !empty($shrinkage)) {
	    $i = 1;
	    foreach ($shrinkage as $val) {
		if (isset($val['stock']) && !empty($val['stock'])) {
		    foreach ($val['stock'] as $val1) {
			$shrinkage_value += $val1['system_quantity'] - $val1['physical_quantity'];
			$total_cost += $shrinkage_value * $val1['cost_price'];
		    }
		}
		?>
		<tr>
		    <td><?php echo $i; ?></td>
		    <td><?php echo $val['entry_date']; ?></td>
		    <td><?php echo $val['document_name']; ?></td>
		    <td>
			<?php
			echo $shrinkage_value;
			?>
		    </td>
		    <td>
			<?php
			echo $total_cost;
			?>
		    </td>
		    <td>
			<a href="<?php echo $this->config->item('base_url') . 'stock/physical_report/view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View"><span class="fa fa-eye"></span></a>
		    </td>
		</tr>

		<?php
		$i++;
	    }
	} else {
	    ?>
    	<tr><td colspan="9" style="text-align:center;">NO DATA FOUND</td></tr>
	<?php } ?>
    </tbody>

</table>