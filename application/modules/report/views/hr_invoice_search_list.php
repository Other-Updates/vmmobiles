<thead>
    <tr>
        <td class="action-btn-align">S.No</td>
        <td class="action-btn-align">Invoice ID</td>
        <td class="action-btn-align">Customer Name</td>
        <td class="action-btn-align">Total Quantity</td>
        <!--<td class="action-btn-align">Total Tax</td>-->
        <!--<td>Sub Total Quantity</td>-->
        <td class="action-btn-align">Invoice Amount</td>
        <td class="action-btn-align">Invoice Date</td>
        <td class="action-btn-align">Credit Days</td>
        <td class="action-btn-align">Due Date</td>
        <td class="action-btn-align">Credit Limit</td>
        <td class="action-btn-align">Exceeded Credit Limit</td>
    </tr>
</thead>
<tbody>


</tbody>
<tfoot>
    <tr>
        <td colspan="3"></td>
        <td class="action-btn-align total-bg"><?= number_format($tot1); ?></td>
        <td class="text_right total-bg"><?= number_format($tot, 2); ?></td>
        <td colspan="5"></td>
    </tr>
</tfoot>

