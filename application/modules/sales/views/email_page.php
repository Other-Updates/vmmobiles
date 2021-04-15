<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style>
    .pdf-f{font-weight:bold}
</style>
<?php
if (isset($quotation) && !empty($quotation)) {
    foreach ($quotation as $val) {
        ?>
        <table border="1" style="padding: 5px 5px;" row-style="page-break-inside:avoid;">
            <tr>
                <td align="left" width="215"><span class="pdf-f">TO,</span>
                    <div><?php echo $val['address1']; ?> </div>
                </td>
                <td colspan="2" class="action-btn-align" align="center" width="318"> <img src="<?= $theme_path; ?>/images/logo(3).png" alt="Chain Logo" ></td>
            </tr>
            <tr>
                <td align="left" width="215"><span class="pdf-f">Reference Name : </span><?php echo $val['nick_name']; ?></td>
                <td align="left"  colspan="2" width="318"><span class="pdf-f">Quotation NO : </span><?php echo $val['q_no']; ?></td>
            </tr>
            <tr>
                <td align="left" width="215"><span class="pdf-f">Company Name : </span> <?php echo $val['store_name']; ?></td>
                <td align="left" colspan="2" width="318"><span class="pdf-f">Customer Mobile No : </span> <?php echo $val['mobil_number']; ?></td>
            </tr>
            <tr>
                <td align="left" width="215"><span class="pdf-f">Customer Email ID : </span><?php echo $val['email_id']; ?></td>
                <td align="left"><span class="pdf-f">Tin No : </span><?= $company_details[0]['tin_no'] ?></td>
                <td align="left" width="158.8"><span class="pdf-f" > Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
            </tr>
        </table>

        <table border="1" style="padding: 5px 5px;" row-style="page-break-inside:avoid;">
            <tr>
                <td colspan="7" align="center"><b>COMERCIAL INVOICE</b></td>
            </tr>      
            <tr>
                <td colspan="12" style="background-color:#ddd;"></td>
            </tr>
            <tr align="center" style="background-color:#e6e6ff;">
                <td width="5%"><b>S.No</b></td>                    	
                <td width="34%" ><b>Product Description</b></td>  
                <td width="11%"><b>Product</b></td>  
                <td width ="10%"><b>QTY</b></td>
                <td width ="15%"><b>Cost/QTY</b></td>
                <td width ="10%"><b>Tax</b></td>
                <td width ="15%"><b>Net Value</b></td> 
            </tr>
            <?php
            $i = 1;
            if (isset($quotation_details) && !empty($quotation_details)) {
                foreach ($quotation_details as $vals) {
                    ?>
                    <tr>
                        <td align="center" width="8%">
                            <?php echo $i; ?>
                        </td>                          
                        <td align="center" width="32%">
                            <?php echo $vals['product_description'] ?>
                        </td>
                        <td align="center" width="11%">
                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $vals['product_image']; ?>"/> 
                        </td>
                        <td align="center" width="10%"><?php echo $vals['quantity'] ?> </td>
                        <td align="right" width="14%">
                            <?php echo number_format($vals['per_cost'], 2); ?>
                        </td>
                        <td align="center" width="10%">
                            <?php echo $vals['tax'] ?>
                        </td>
                        <td align="right" width="15%">
                            <?php echo number_format($vals['sub_total'], 2); ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
            <tr>
                <td colspan="3" align="right" ><b>Total</b></td>
                <td align="center"><?php echo $val['total_qty']; ?></td>
                <td colspan="2" align="right"><b>Sub Total</b></td>
                <td align="right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>
            </tr>
            <tr>                           
                <td colspan="6" align="right"><b><?php echo $val['tax_label']; ?> </b></td>
                <td align="right">
                    <?php echo number_format($val['tax'], 2); ?>
                </td>
            </tr>
            <?php  
            foreach($val['other_cost'] as $key)
            {
                    ?> 
            <tr>                           
                <td colspan="6" align="right"><b><?php echo $key['item_name']; ?> </b></td>
                <td align="right">
                    <?php echo number_format($key['amount'], 2); ?>
                </td>
            </tr>
            <?php } ?>
            <tr>                           
                <td colspan="6" align="right"><b>Net Total</b></td>
                <td align="right"><b><?php echo number_format($val['net_total'], 2); ?></b></td>
            </tr>
            <tr>
                <td colspan="7" align="left">
                    <span class="pdf-f">Remarks : </span>
                    <?php echo $val['remarks']; ?>
                </td>
            </tr>
        </table>
        </br></br></br>
    <?php }
}
?>

