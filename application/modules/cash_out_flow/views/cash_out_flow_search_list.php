<?php
if (isset($cash_out) && !empty($cash_out)) {
    $i = 1;
    foreach ($cash_out as $val) {
        ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $val['firm_name']; ?></td>
            <td><?php echo ($val['user_name'] == 'Others') ? $val['other_name'] : $val['user_name']; ?></td>
            <td><?php echo $val['sender'][0]['sender_firm_name']; ?></td>
            <td><?php echo ($val['sender_name'] == 'Others') ? $val['sender_other_name'] : $val['sender_name']; ?></td>
            <td class="text_right"><?php echo $val['cash_out']; ?></td>
            <td class="text_right"><?php echo $val['cash_in']; ?></td>
            <td class="text_right"><?php echo number_format(($val['cash_out'] - $val['cash_in']), 2); ?></td>
            <td class="hide_class action-btn-align">
                <?php
                if ($val['payment_status'] == 'pending') {
                    echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
                } else {
                    echo '<a href="#" data-toggle="modal" class="tooltips ahref border0" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
                }
                ?>
            </td>
            <td class='hide_class action-btn-align'>
                <?php
                if ($val['payment_status'] == 'pending') {
                    ?>
                    <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'edit')): ?><?php echo $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_edit/' . $val['id'] ?><?php endif ?>"data-toggle="tooltip" class="tooltips btn btn-info btn-xs <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'edit')): ?>alerts<?php endif ?>" title="" data-original-title="Quick pay"><span class="fa fa-edit "></span></a>
                    <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')): ?><?php echo $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                    <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete')): ?>alerts<?php endif ?>" title="Delete"><span class="fa fa-ban"></span></a>

                    <?php
                } else {
                    ?>
                    <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')): ?><?php echo $this->config->item('base_url') . 'cash_out_flow/cash_out_flow_view/' . $val['id'] ?><?php endif ?>" data-toggle="tooltip" class="tooltips btn btn-default btn-xs <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'view')): ?>alerts<?php endif ?>" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
                    <a href="<?php if ($this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs <?php if (!$this->user_auth->is_action_allowed('cash_out_flow', 'cash_out_flow', 'delete')): ?>alerts<?php endif ?>" title="Delete"><span class="fa fa-ban"></span></a>
                    <?php }
                    ?>
            </td>
        </tr>
        <?php
        $i++;
    }
} else {
    echo '<tr><td colspan="8">Data not found...</td></tr>';
}
?>