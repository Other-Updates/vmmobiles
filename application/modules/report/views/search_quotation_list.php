
<?php
if (isset($quotation) && !empty($quotation)) {
    $i = 1;
    foreach ($quotation as $val) {
        ?>
        <tr>
            <td class='first_td action-btn-align'><?= $i ?></td>
            <td><?= $val['q_no'] ?></td>
            <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>
            <td class="action-btn-align"><?= $val['total_qty'] ?></td>
            <!--<td><?= number_format($val['tax_details'][0]['tot_tax'], 2); ?></td>-->
            <!--<td><?= number_format($val['subtotal_qty'], 2); ?></td>-->
            <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
            <td class="action-btn-align"><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : ''; ?></td>
            <!--<td><?= ($val['notification_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['notification_date'])) : ''; ?></td>-->
            <!--<td><?= $val['mode_of_payment'] ?></td>-->
            <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
            <td class="action-btn-align">
                <?php
                if ($val['estatus'] == 1) {
                    ?>
                    <span class=" badge bg-red"> <?php echo 'Pending'; ?></span>

                    <?php
                }
                if ($val['estatus'] == 2) {
                    ?>
                    <span class=" badge bg-green"> <?php echo 'Completed'; ?></span>
                    <?php
                }
                if ($val['estatus'] == 4) {
                    ?>
                    <span class=" badge bg-green"> <?php echo 'Order Approved'; ?></span>
                    <?php
                }
                if ($val['estatus'] == 5) {
                    ?>
                    <span class="badge bg-yellow"> <?php echo 'Order Reject'; ?></span>
                    <?php
                }
                ?>
            </td>

            <td class="action-btn-align">  <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
            </td>

        </tr>
        <?php
        $i++;
    }
}
?>