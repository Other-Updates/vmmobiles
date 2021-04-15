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