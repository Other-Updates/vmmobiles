
<?php
$theme_path = $this->config->item('theme_locations') . $this->config->item('active_template');
$data['company_details'] = $this->admin_model->get_company_details();
?>

<table>
    <tr>
        <td aligen="left" width="20%">
            <img src="<?= $theme_path; ?>/images/logo-login2.png" style="margin-top:5px;" />
        </td>
        <td width="80%" align="right">
            <!--<font size="15px"><b>Billing Software</b></font><br />-->
            <font size="10px">
            <?= $data['company_details'][0]['address1'] ?>,
            <?= $data['company_details'][0]['address2'] ?>,
            <?= $data['company_details'][0]['city'] ?>,
            <?= $data['company_details'][0]['state'] ?>-
            <?= $data['company_details'][0]['pin'] ?>
            Ph:<?= $data['company_details'][0]['phone_no'] ?>,
            Email:<?= $data['company_details'][0]['email'] ?>
            </font>
        </td>
    </tr>
</table>

