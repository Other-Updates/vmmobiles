
<?php
if (isset($stock) && !empty($stock)) {
    $i = 1;
    foreach ($stock as $val) {
        ?>
        <tr>
            <td class='first_td'><?= $i ?></td>
            <td><?= $val['categoryName'] ?></td>
            <td><?= $val['brands'] ?></td>
            <!-- <td><?= $val['model_no'] ?></td> -->
            <td><?= $val['product_name'] ?></td>
            <td class="action-btn-align"><?= $val['quantity'] ?></td>
        </tr>
        <?php
        $i++;
    }
}
?>