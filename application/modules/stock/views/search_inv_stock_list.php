<?phpif (isset($stock) && !empty($stock)) {    $i = 1;    foreach ($stock as $val) {        ?>        <tr>            <td class='first_td action-btn-align'><?= $i ?></td>            <td><?= $val['firm_name'] ?></td>            <td><?= $val['categoryName'] ?></td>            <td><?= $val['product_name'] ?><br> <?php                if (isset($purchase_link) && !empty($purchase_link)) {                    $link = '';                    foreach ($purchase_link as $p_link) {                        $link = base_url() . 'purchase_order/po_view/' . $p_link['id'];                        echo '<a href="' . $link . '">' . $p_link['po_no'] . '</a><br>';                    }                }                ?></td>            <td><?= $val['brands']; ?></td>            <td class="action-btn-align"><?= $val['quantity']; ?></td>         <!--   <?php            $user_info = $this->user_auth->get_from_session('user_info');            if ($user_info[0]['role'] == 1) {                ?>                <td><a href="javascript:void(0)" stock_id="<?php echo $val['id']; ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a></td>            <?php } else { ?>                <td><a href="javascript:void(0)" stock_id="<?php echo $val['id']; ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs edit" title="" data-original-title="Edit"><span class="fa fa-ban alerts"></span></a></td>                    <?php } ?>-->        </tr>        <?php        $i++;    }} else {    echo '<tr><td colspan="7">Data not found...</td></tr>';}?>