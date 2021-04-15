

<?php

if (isset($po) && !empty($po)) {

    $i = 1;

    foreach ($po as $val) {

        ?>

        <tr>

            <td class='first_td action-btn-align'><?= $i ?></td>

            <td><?= $val['po_no'] ?></td>

            <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>

            <td class="action-btn-align"><?= $val['total_qty'] ?></td>

        <!--                                    <td><?= $val['tax'] ?></td> -->

            <!--<td><?= number_format($val['subtotal_qty'], 2); ?></td>-->

            <td class="text-right"><?= number_format($val['net_total'], 2); ?></td>

         <!--   <td class="action-btn-align"><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : '-'; ?></td>-->

            <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '-'; ?></td>

            <td class='hide_class  action-btn-align'>

                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/po_view/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>

            </td>

        </tr>

        <?php

        $i++;

    }

} 

?>