<?php



if (isset($stock) && !empty($stock)) {



    $i = 1;



    foreach ($stock as $val) {



        ?>



        <tr>



            <td class='first_td'><?= $i ?></td>



            <td><?= $val['firm_name'] ?></td>



            <td><?= $val['categoryName'] ?></td>



            <td><?= $val['brands'] ?></td>



            <td><?= $val['product_name'] ?></td>



            <td><?php echo $val['cost_price']; ?></td>



            <td class="action-btn-align"><?= round($val['quantity']) ?></td>



            <td><?php echo $val['quantity'] * $val['cost_price']; ?></td>



            <td><?php echo round(($val['quantity'] * $val['cost_price'] * $val['cgst']) / 100, 2); ?></td>



            <td><?php echo round(($val['quantity'] * $val['cost_price'] * $val['sgst']) / 100, 2); ?></td>



            <td><?php echo ($val['quantity'] * $val['cost_price']) + (($val['quantity'] * $val['cost_price'] * $val['cgst']) / 100) + (($val['quantity'] * $val['cost_price'] * $val['sgst']) / 100); ?></td>







        </tr>



        <?php



        $i++;



    }



} 



?>