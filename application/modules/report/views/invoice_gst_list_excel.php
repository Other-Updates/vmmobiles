<?php
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . All_entries . date('d-m-Y') . '.xls');
header('Pragma: no-cache');
header('Expires: 0');
?>

<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<head>

    </head>
    <body>
        <table class="table table-bordered table-striped "width="100%" cellpadding="0" cellspacing="0" style="text-align:center;border:1px solid #ccc;" >
            <tr tyle="text-align:center;border:1px solid #ccc;">
                <th style="border:1px solid #ccc;">S.No</th>
                <th style="border:1px solid #ccc;">Invoice ID</th>
                <th style="border:1px solid #ccc;">Firm Name</th>
                <th style="border:1px solid #ccc;">Firm GSTIN</th>
                <th style="border:1px solid #ccc;">Customer name</th>
                <th style="border:1px solid #ccc;">Customer GSTIN</th>
                <th style="border:1px solid #ccc;">Total QTY</th>
                <th style="border:1px solid #ccc;">CGST</br><span><?php echo ($search_data['gst'] && $search_data['gst'] != 'Select') ? $search_data['gst'] . '%' : ''; ?></span></th>
                <th style="border:1px solid #ccc;">SGST</br><span><?php echo ($search_data['gst'] && $search_data['gst'] != 'Select') ? $search_data['gst'] . '%' : ''; ?></span></th>
                <th style="border:1px solid #ccc;">Sub Total</th>
                <th style="border:1px solid #ccc;">Inv Amt</th>
                <th style="border:1px solid #ccc;">INV Date</th>
                
            </tr>
            <?php
            $quotation = array_filter($quotation);
            if (isset($quotation) && !empty($quotation)) {
             $count = count($quotation);
              

                $i = 1;
                $tot = 0;
                $cnt = 0;   
                foreach ($quotation as $key => $val) {
                   //echo "<pre>";print_r($val);exit;
                    $url='<a href="' . $this->config->item('base_url') . 'sales/invoice_views/' . $val['inv_id'] . '" target="_blank">' . $val['inv_id'] . '</a>';
                ?>
          <tr style="text-align:center;border:1px solid #ccc;">
                <td style="vertical-align:top; text-align:center;border:1px solid #ccc; ">
                     <?= $key+1 ?></td>
                <td style="border:1px solid #ccc;"><?php echo $url ?></td>
                <td style="border:1px solid #ccc;"><?php echo $val['firm_name']; ?></td>
                <td style="border:1px solid #ccc;"><?php echo ($val['gstin']) ? $val['gstin'] : ''; ?></td>
                <td style="border:1px solid #ccc;"><?php
                                    echo ($val['store_name']) ? $val['store_name'] : $val['name'];
                                    ?></td>
                <td style="border:1px solid #ccc;"><?php
                                    echo ($val['tin']) ? $val['tin'] : '';
                                    ?></td>
                <td style="border:1px solid #ccc;"><?php echo $val['total_qty'];?></td>
                <td style="border:1px solid #ccc;"><?php echo number_format(($val['erp_invoice_details'][0]['cgst']), 2) ?></td>
                <td style="border:1px solid #ccc;"><?php echo number_format(($val['erp_invoice_details'][0]['sgst']), 2) ?></td>
                <td style="border:1px solid #ccc;"><?php echo number_format($val['subtotal_qty'], 2) ?></td>
                <td style="border:1px solid #ccc;"><?php echo number_format($val['net_total'], 2)?></td>
                <td style="border:1px solid #ccc;"><?php echo ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '' ?></td>
            </tr>
        <?php }} else { ?>
            <tr><td style="border:1px solid #ccc;"><center>No data found</center></td></tr>
        <?php } ?>


            
        </table>
    </body>

</html>
