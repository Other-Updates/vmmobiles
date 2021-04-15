<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="Billing Software">
        <meta name="author" content="Billing Software">
        <?php
        $sesion_data = $this->user_auth->get_all_session();
        $logged_in = $this->user_auth->get_from_session('user_info');
        $this->load->model('admin/admin_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('purchase_order/purchase_order_model');
        $data["admin"] = $this->admin_model->get_admin();
        ?>
        <title>
            <?= $this->config->item('site_title'); ?> |
            <?= $this->config->item('site_powered'); ?></title>
        <?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
        <?php
        $cur_class = $this->router->class;
        $cur_method = $this->router->method;
        ?>
        <link href="<?= $theme_path; ?>/images/logo-fav.png" rel="shortcut icon">
        <link href="<?= $theme_path; ?>/css/style.default.css" rel="stylesheet">
        <link href="<?= $theme_path; ?>/css/morris.css" rel="stylesheet">
        <link href="<?= $theme_path; ?>/css/select2.css" rel="stylesheet" />
        <link href="<?= $theme_path; ?>/css/media_print.css" rel="stylesheet" />
        <link href="<?= $theme_path ?>/css/style.datatables.css" rel="stylesheet">
		<link href="<?= $theme_path ?>/css/bootstrap-tagsinput.css" rel="stylesheet">
        <link href="<?= $theme_path ?>/css/dataTables.responsive.css" rel="stylesheet">
        <link href="<?= $theme_path ?>/css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- Sidemenu -->
      	<link rel="stylesheet" href="<?= $theme_path ?>/sidemenu/fontawesome-free/css/all.min.css">
      	<link rel="stylesheet" href="<?= $theme_path ?>/sidemenu/overlayScrollbars/css/OverlayScrollbars.min.css">
      	<link rel="stylesheet" href="<?= $theme_path ?>/sidemenu/adminlte.min.css">
        
        
        <script src="<?= $theme_path; ?>/js/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/js//sweetalert.css">
        <script src="<?php echo $theme_path; ?>/js/sweetalert.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            // var BASE_URL = "<?php // $this->config->item('base_url');           ?>";
            // var MIGRATE_URL = "<?php // $this->config->item('migrate_url');           ?>";
            var ct_class = "<?= $this->router->class; ?>";
            var ct_method = "<?= $this->router->method; ?>";
            // var theme_path = "<?php // $theme_path;           ?>";
        </script>
        <link href="<?php echo $theme_path; ?>/css/components.css" rel="stylesheet" type="text/css">
        <?php
        $user_info = $this->user_auth->get_from_session('user_info');
        if (empty($user_info[0]['id'])) {
            redirect($this->config->item('base_url') . 'admin');
        }
        ?>
    </head>

    <?php
    $data['company_details'] = $this->admin_model->get_company_details();
    $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
    $data['todays_sales'] = $this->project_cost_model->get_the_total_sales_count();
    $data['todays_purchases'] = $this->purchase_order_model->get_the_total_po_count();
    $total_sales = 0;
    $total_purchases = 0;
    if (!empty($data['todays_sales']) && count($data['todays_sales']) > 0) {
        foreach ($data['todays_sales'] as $val) {
            $total_sales += $val['net_total'];
        }
    }
    if (!empty($data['todays_purchases']) && count($data['todays_purchases']) > 0) {
        foreach ($data['todays_purchases'] as $value) {
            $total_purchases += $value['net_total'];
        }
    }
    ?>
    <style>
        .menu li {
            padding: 0px;
        }
        .auto-asset-search ul
        {
            position:absolute !important;
            z-index: 4;
            height: 200px;
            overflow-y: scroll;
            overflow-x:hidden;
        }
        .menu li.active a span,.menu li.active a i{
            color: #2196F3 !important;
        }
        .sub-menu li.active a, .sub-menu li.active i{
            color: #2196F3 !important;
        }
        <!--.footer_print {
            width: 100%;
            position: fixed;
            bottom: 0;
        }-->


        /*        .footer_print:after {
                    float: right;
                    width: 100%;
                    counter-increment: page;
                    content: counter(page);
                    left: 0;
                    top: 100%;
                    white-space: nowrap;
                    z-index: 20px;
                    -moz-border-radius: 5px;
                    -moz-box-shadow: 0px 0px 4px #222;
                    background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
                    background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);
                }*/
        .print_footer {
            display:none;
        }
    </style>
    <body id="fullscreen" class="hold-transition sidebar-mini layout-fixed">
        <!--        <div class="print_header">
                    <table width="100%">
                        <tr>
                            <td width="15%" style="vertical-align:middle;">
                                <div class="print_header_logo" ><img src="<?= $theme_path; ?>/images/logo.png" /></div>
                            </td>
                            <td width="85%">
                                <div class="print_header_tit" >
                                    <h3>The Total</h3>
                                    <p>
        <?= $data['company_details'][0]['address1'] ?>,
        <?= $data['company_details'][0]['address2'] ?>,
                                    </p>
                                    <p></p>
                                    <p><?= $data['company_details'][0]['city'] ?>-
        <?= $data['company_details'][0]['pin'] ?>,
        <?= $data['company_details'][0]['state'] ?></p>
                                    <p></p>
                                    <p>Ph:
        <?= $data['company_details'][0]['phone_no'] ?>, Email:
        <?= $data['company_details'][0]['email'] ?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>-->
                
                
        <div class="wrapper">
        <!-- Navbar -->
          <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <header>
            <div class="headerwrapper">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
            </ul>
                  
        
                <div class="container">
                    
                    <div class="header-table-today">
                        <!--<a href="#" class="menu-collapse">
                            <i class="fa fa-bars"></i>
                        </a>-->
                        <div class="header-table mar-left15">

                        </div>
                        <div class="header-table">

                        </div>
                    </div>

                    <!-- header-left -->
                    <div class="header-right">
                        <!-- profile -->
                        <div class="mdiv">
                        </div>
                        <div class="pull-right">
                            <div class="btn-group btn-group-option">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">

                                    <li><a href="<?php echo $this->config->item('base_url') . 'admin/update_profile' ?>"><i class="glyphicon glyphicon-user"></i> My Profile</a>
                                    </li>

                                    <li><a href="<?php echo $this->config->item('base_url') . 'admin/logout' ?>"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- btn-group -->

                        </div>
                        <!-- end -->
                        <!--<div class="pull-left ims"><img src="<?= $theme_path; ?>/images/ims_logo.png" alt="" /> </div>-->


                        <!-- pull-right -->
                        <div class="pull-right mnone">
                            <div class="btn-group btn-group-option">
                                <?php if ($this->user_auth->is_module_allowed('dashboard')): ?>
                                    <a href="<?php echo $this->config->item('base_url') . 'admin/dashboard' ?>" class="btn btn-default btn-group" style="color:white;">Dashboard</a>
                                <?php endif; ?>

                            </div>
                            <!-- btn-group -->

                        </div>
                        <!-- General notification -->


                        <?php if ($this->user_auth->is_section_allowed('notification', 'general_notification') || $this->user_auth->is_section_allowed('purchase', 'purchase_request')) { ?>
                            <div class="receivable-notification">
                                <div class="pull-right">

                                    <?php //if (($user_info[0]['role'] == 1 || $user_info[0]['role'] == 2)) {   ?>
                                    <div class="btn-group btn-group-option">
                                        <?php
                                        $this->load->model('api/notification_model');
                                        $notification = $this->notification_model->all_notification();
                                        ?>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bell"></i>
                                            <span class="label label-primary pull-xs-right label-pad noti-align noti-position <?php echo (count($notification) != 0) ? 'notify_count' : ''; ?>">
                                                <?php
                                                echo (($notification['total_count']) != 0) ? $notification['total_count'] : '';
                                                ?></span>
                                           <!-- <span class="noti-icon-badge"></span>-->
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg pb0 orange-notify" role="menu">
                                            <div class="notification-head">
                                                <h4>
                                                    <small>
                                                        Notification
                                                    </small>
                                                </h4>
                                            </div>
                                            <div class="user-scroll">

                                                <?php
                                                if (isset($notification) && !empty($notification)) {
                                                    //print_r($notification);
                                                    // exit;
                                                    foreach ($notification as $noty) {
                                                        ?>
                                                        <div class="notification-user">
                                                            <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                                                                <div class="notify-icon bg-success"><i class="icon-bubble"></i></div>-->

                                                            <p class="notify-details">
                                                                <?php if ($noty['type'] != 'invoice') { ?>
                                                                    <a href="<?php echo $this->config->item('base_url') . $noty['link'] . '?notification=' . $noty['id']; ?>">
                                                                        <?php
                                                                        if ($noty['type'] == 'payment')
                                                                            echo 'Payment';
                                                                        else if ($noty['type'] == 'purchase_payment')
                                                                            echo 'Purchase Payment';
                                                                        else if ($noty['type'] == 'min_qty')
                                                                            echo 'Quantity Shortage';
                                                                        else if ($noty['type'] == 'quotation')
                                                                            echo 'Quotation';
                                                                        else if ($noty['type'] == 'credit_days_exceeded')
                                                                            echo 'Due Date Exceeded';
                                                                        else if ($noty['type'] == 'credit_limit_exceeded')
                                                                            echo 'Credit Limit Exceeded';

                                                                        else if ($noty['type'] == 'purchase_request')
                                                                            echo 'Purchase Request';
                                                                        ?>
                                                                    </a>
                                                                    <br>
                                                                    <small class="text-muted"><?php echo $noty['Message']; ?></small>
                                                                <?php } ?>
                                                                <?php if ($noty['type'] == 'invoice' && $user_info[0]['role'] == 1) { ?>
                                                                    <a href="<?php echo $this->config->item('base_url') . $noty['link'] . '?notification=' . $noty['id']; ?>">
                                                                        <?php
                                                                        echo 'Invoice';
                                                                        ?> </a><br>
                                                                    <small class="text-muted"><?php echo $noty['Message']; 
																	
																	?></small>
																
                                                                <?php } ?>
                                                            </p>
                                                            </a>
                                                        </div>

                                                        <?php
                                                    }
                                                } else {
													
                                                    echo '<div class="notification-user no-data" >No data found...</div>';

                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php // }    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Stable notification -->
                        
                        

                        <?php if ($this->user_auth->is_section_allowed('notification', 'today_notification')) { ?>
                            <div class="pull-right">
                                <div class="btn-group btn-group-option">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        &nbsp;<i class="fa fa-inr"></i>&nbsp;
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg pb0 purple-notify table-notify" role="menu">
                                        <div class="user-scroll today-table">
                                            <table cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr class="today-th">
                                                        <th>&nbsp;</th>
                                                        <th colspan="2">Today's&nbsp;Purchase</th>
                                                        <th colspan="2">Today's&nbsp;Sale</th>
                                                    </tr>
                                                    <tr class="today-th1">
                                                        <th width="20%">Firm</th>
                                                        <th width="20%">Cash</th>
                                                        <th width="20%">Credit</th>
                                                        <th width="20%">Cash</th>
                                                        <th width="20%">Credit</th>
                                                    </tr>
                                                    <?php
                                                    $data['today_po'] = $this->admin_model->get_cash_credit_po();
                                                    $data['today_sales'] = $this->admin_model->get_cash_credit_sales();
                                                    ?>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($data['today_po'])) {
                                                        foreach ($data['today_po'] as $val) {
                                                            ?>
                                                            <tr>
                                                                <td align="left"><?php echo $val['prefix']; ?></td>
                                                                <td align="center"><?php echo ($val['po_cash'][0]['po_cash'] != '') ? number_format($val['po_cash'][0]['po_cash'], 2) : '0.00'; ?></td>
                                                                <td align="center"><?php echo ($val['po_credit'][0]['po_credit'] != 0) ? number_format($val['po_credit'][0]['po_credit'], 2) : '0.00'; ?></td>
                                                                <td align="center"><?php echo ($val['inv_cash'][0]['inv_cash'] != '') ? number_format($val['inv_cash'][0]['inv_cash'], 2) : '0.00'; ?></td>
                                                                <td align="center"><?php echo ($val['inv_credit'][0]['inv_credit'] != 0) ? number_format($val['inv_credit'][0]['inv_credit'], 2) : '0.00'; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($logged_in[0]['role'] == 1): ?>
                            <div class="pull-right">
                                <!--                                <div class="btn-group btn-group-option but-new-inv">
                                                                    <input type="button" id="download" class="btn btn-success migrateion" style="float:right; margin-top:0px;" title="cron" value="Download">
                                                                </div>-->
                            </div>
                        <?php endif; ?>
                        <?php if ($this->user_auth->is_action_allowed('sales', 'invoice', 'add')): ?>
                            <div class="pull-right">
                                <div class="btn-group btn-group-option but-new-inv">
                                    <a href="<?php echo $this->config->item('base_url') . 'sales/new_direct_invoice' ?>" class="btn btn-success">Invoice</a>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </header>
        </nav>
        <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<div class="header-left">
        <a href="<?php echo $this->config->item('base_url') . 'admin/dashboard' ?>" class="logo">
            <img src="<?= $theme_path; ?>/images/logo.png" alt="" width="130" >
        </a>
    </div>
  
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php if ($this->user_auth->is_module_allowed('masters')): ?>
                                <li class="nav-item has-treeview masters_tab1 <?php echo ($cur_class == 'suppliers' || $cur_class == 'customers' || $cur_class == 'firms' || $cur_class == 'user_roles' || $cur_class == 'users' || $cur_class == 'products' || $cur_class == 'categories' || $cur_class == 'brands' || $cur_class == 'reference_groups' || $cur_class == 'email_settings') ? 'menu-open' : '' ?>"><a href="javascript: void(0)" class="nav-link" ><i class="fa fa-tachometer-alt fa-fw" aria-hidden="true"></i> Masters <i class="right fas fa-angle-left"></i></a>
                                    <ul class="nav nav-treeview">
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'suppliers')): ?>
                                            <li class="nav-item supplierss <?= ($cur_class == 'suppliers') ? 'active' : '' ?>" >
                                                <a class="nav-link key_tab1" href="<?php echo $this->config->item('base_url') . 'masters/suppliers' ?>"><i class="far fa-circle nav-icon"></i> Suppliers</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'customers')): ?>
                                            <li class="nav-item <?= ($cur_class == 'customers') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab2" href="<?php echo $this->config->item('base_url') . 'masters/customers' ?>"><i class="far fa-circle nav-icon"></i> Customers</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'firms')): ?>
                                            <li class="nav-item <?= ($cur_class == 'firms') ? 'active' : '' ?>" >
                                                <a class="nav-link key_tab3" href="<?php echo $this->config->item('base_url') . 'masters/firms' ?>"><i class="far fa-circle nav-icon"></i> Shops</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'user_roles')): ?>
                                            <li class="nav-item <?= ($cur_class == 'user_roles') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab4" href="<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>"><i class="far fa-circle nav-icon"></i> User Role</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'users')): ?>
                                            <li class="nav-item <?= ($cur_class == 'users') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab5" href="<?php echo $this->config->item('base_url') . 'masters/users' ?>"><i class="far fa-circle nav-icon"></i> Users</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'products')): ?>
                                            <li class="nav-item <?= ($cur_class == 'products') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab6" href="<?php echo $this->config->item('base_url') . 'masters/products' ?>"><i class="far fa-circle nav-icon"></i> Products</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'categories')): ?>
                                            <li class="nav-item <?= ($cur_class == 'categories') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab7" href="<?php echo $this->config->item('base_url') . 'masters/categories' ?>"><i class="far fa-circle nav-icon"></i> Categories</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'brands')): ?>
                                            <li class="nav-item <?= ($cur_class == 'brands') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab8" href="<?php echo $this->config->item('base_url') . 'masters/brands' ?>"><i class="far fa-circle nav-icon"></i> Models</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php // if ($this->user_auth->is_section_allowed('masters', 'reference_groups')): ?>
                            <!-- <li class="<?php //= ($cur_class == 'reference_groups') ? 'active' : ''     ?>" >
                                <a class="key_tab9" href="<?php //echo $this->config->item('base_url') . 'masters/reference_groups'     ?>"><i class="far fa-circle nav-icon"></i> Reference Groups</a>
                            </li> -->
                                        <?php //endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'sales_man')): ?>

                                            <li class="nav-item <?php echo ($cur_class == 'sales_man') ? 'active' : '' ?>" >
                                                <a class="nav-link key_tab10" href="<?php echo $this->config->item('base_url') . 'masters/sales_man' ?>"><i class="far fa-circle nav-icon"></i> Sales Man</a>

                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('masters', 'email_settings')): ?>
                                            <li class="nav-item <?= ($cur_class == 'email_settings') ? 'active' : '' ?>">
                                                <a class="nav-link key_tab11" href="<?php echo $this->config->item('base_url') . 'masters/email_settings' ?>"><i class="far fa-circle nav-icon"></i> Email Settings</a>
                                            </li>
                                        <?php endif; ?>

                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->user_auth->is_module_allowed('purchase')): ?>
                                <li class="nav-item has-treeview masters_tab3 po_tab<?= ($cur_class == 'purchase_order' || $cur_class == 'purchase_return' || $cur_class == 'purchase_receipt' ) ? ' menu-open' : '' ?>"><a href="javascript: void(0)" class="nav-link"></i><i class="fa fa-fw fa-tasks" aria-hidden="true"></i> Purchase <i class="right fas fa-angle-left"></i></a>
                                    <ul class="nav nav-treeview">
                                        <?php if ($this->user_auth->is_module_allowed('purchase')): ?>
                                            <li class="nav-item <?= ($cur_class == 'purchase_order' && $cur_method == 'purchase_order_list') ? 'active' : '' ?>" >
                                                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list' ?>" class="nav-link"><i class="far fa-circle nav-icon"></i> Purchase List</a>
                                            </li>
                                        <?php endif; ?> 
                                        <!--<li class="nav-item <?= ($cur_class == 'purchase_order' && $cur_method == 'fresh_purchase') ? 'active' : '' ?>" >
                                                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/fresh_purchase' ?>" class="nav-link"><i class="far fa-circle nav-icon"></i> Add Fresh Purchase</a>
                                        </li>
                                        <li class="nav-item <?= ($cur_class == 'purchase_order' && $cur_method == 'used_purchase') ? 'active' : '' ?>" >
                                                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/used_purchase' ?>" class="nav-link"><i class="far fa-circle nav-icon"></i> Add Used Purchase</a>
                                        </li>
                                        <li class="nav-item <?= ($cur_class == 'purchase_order' && $cur_method == 'accessories_purchase') ? 'active' : '' ?>" >
                                                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/accessories_purchase' ?>" class="nav-link"><i class="far fa-circle nav-icon"></i> Accessories Purchase</a>
                                        </li>-->
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->user_auth->is_module_allowed('stock')): ?>
                                    <li class="nav-item has-treeview masters_tab4 inventory_tab <?= (($cur_class == 'stock' || $cur_class == 'sku_management' || $cur_class == 'physical_report') && $cur_method == 'index') ? ' menu-open' : '' ?>"><a href="javascript: void(0)" class="nav-link" ><!--<i class="fa fa-suitcase"></i>--> <i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i> Inventory <i class="right fas fa-angle-left"></i></a>
                                    <ul class="nav nav-treeview">
                                        <li class="<?= ($cur_class == 'stock' && $cur_method =='index') ? 'active' : '' ?>" >
                                            <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'stock/' ?>"><i class="far fa-circle nav-icon"></i> Stock</a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->user_auth->is_module_allowed('sales')): ?>
                                <li class="nav-item has-treeview masters_tab5 sales_tab <?php echo (($cur_class == 'sales' )) ? ' menu-open' : '' ?>">
                                    <a href="javascript: void(0)" class="nav-link" >
                                        <i class="fa fa-fw fa-rupee" aria-hidden="true"></i>
                                         Sales <i class="right fas fa-angle-left"></i>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php if ($this->user_auth->is_module_allowed('sales')): ?>
                                            <li class="<?= ($cur_class == 'sales' && $cur_method == 'invoice_list') ? 'active' : '' ?>">
                                                <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'sales/invoice_list' ?>">
                                                    <i class="far fa-circle nav-icon"></i> Invoice List
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                           <!-- <li class="<?= ($cur_class == 'sales' && $cur_method == 'fresh_mobile_sale') ? 'active' : '' ?>">
                                                    <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'sales/fresh_mobile_sale' ?>">
                                                        <i class="far fa-circle nav-icon"></i> Fresh Mobiles Sale
                                                    </a>
                                            </li>
                                            <li class="<?= ($cur_class == 'sales' && $cur_method == 'used_mobile_sale') ? 'active' : '' ?>">
                                                    <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'sales/used_mobile_sale' ?>">
                                                        <i class="far fa-circle nav-icon"></i> Used Mobiles Sale
                                                    </a>
                                            </li>
                                            <li class="<?= ($cur_class == 'sales' && $cur_method == 'accesories_sale') ? 'active' : '' ?>">
                                                    <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'sales/accessories_sale' ?>">
                                                        <i class="far fa-circle nav-icon"></i> Accessories Sale
                                                    </a>
                                            </li>-->
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <?php if ($this->user_auth->is_module_allowed('reports')): ?>
                                <li class="nav-item has-treeview masters_tab9 reports_tab <?php echo (($cur_class == 'report' ) && $cur_method == 'purchase_report'  || $cur_method == 'customer_based_report' || $cur_method == 'stock_report' || $cur_method == 'stock_list_report' || $cur_method == 'invoice_report' ||  $cur_method == 'profit_list') ? ' menu-open' : '' ?>"><a class="nav-link" href="javascript: void(0)" ><i class="fa fa-fw fa-bar-chart-o"></i> Reports <i class="right fas fa-angle-left"></i></a>
                                    <ul class="nav nav-treeview report-menu">
									<?php if ($this->user_auth->is_section_allowed('reports', 'gst_report')): ?>
                                            <li class="<?= ($cur_method == 'gst_report') ? 'active' : '' ?>">
                                                <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/gst_report' ?>"><i class="far fa-circle nav-icon"></i> GST Report</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('reports', 'customer_based_report')): ?>
                                            <li class="<?= ($cur_method == 'customer_based_report') ? 'active' : '' ?>"><a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/customer_based_report' ?>"><i class="far fa-circle nav-icon"></i> Customer Based Report</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($this->user_auth->is_section_allowed('reports', 'stock_report')): ?>
                                            <li class="<?= ($cur_method == 'stock_report') ? 'active' : '' ?>"><a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/stock_report' ?>"><i class="far fa-circle nav-icon"></i> Stock Report</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('reports', 'stock_list_report')): ?>
                                            <li class="<?= ($cur_method == 'stock_list_report') ? 'active' : '' ?>"><a class="nav-link" href="<?php echo $this->config->item('base_url') . 'stock/stock_list_report' ?>"><i class="far fa-circle nav-icon"></i> Stock Based Report</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('reports', 'purchase_report')): ?>
                                            <li class="<?= ($cur_method == 'purchase_report') ? 'active' : '' ?>"><a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/purchase_report' ?>"><i class="far fa-circle nav-icon"></i> Purchase Report</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('reports', 'invoice_report')): ?>
                                            <li class="<?= ($cur_method == 'invoice_report') ? 'active' : '' ?>"><a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/invoice_report' ?>"><i class="far fa-circle nav-icon"></i> Sales Invoice Report</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->user_auth->is_section_allowed('reports', 'profit_list')): ?>
                                            <li class="<?= ($cur_method == 'profit_list') ? 'active' : '' ?>">
                                                <a class="nav-link" href="<?php echo $this->config->item('base_url') . 'report/profit_list' ?>"><i class="far fa-circle nav-icon"></i> Profit and Loss Report</a>
                                            </li>
                                        <?php endif; ?>
										
                                        
                                    </ul>
                                </li>
                            <?php endif; ?>
                        </ul>
      </nav>
    </div>
  </aside>
        
        
        <div class="content-wrapper">
            <div class="container">

                <!-- leftpanel -->
                <!--AJAX LOADING AND NOTIFICATIONS STARTS HERE-->
                <script type="text/javascript">
                    function for_loading() {
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD STARTS, CODE STARTS HERE
                        $('#main_load_div').css('display', 'block');
                        $('#dyna_div').addClass('my_alert-info').removeClass('my_alert-success');
                        $('#info_txt').html('Loading...');
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD STARTS, CODE ENDS HERE
                    }

                    function for_response(txt) {
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD RESPONSE CAME CODE STARTS HERE
                        $('#dyna_div').addClass('my_alert-success').removeClass('my_alert-info');
                        $('#info_txt').html('Success...');
                        setTimeout(function () {
                            $('#main_load_div').css('display', 'none');
                        }, 100);
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD RESPONSE CAME CODE ENDS HERE
                    }
                    function for_loading1() {
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD STARTS, CODE STARTS HERE
                        $('#main_load_div').css('display', 'block');
                        $('body').css('overflow', 'hidden');
                        $('#dyna_div').addClass('my_alert-info').removeClass('my_alert-success');
                        $('#info_txt').html('Loading...');
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD STARTS, CODE ENDS HERE
                    }

                    function for_response1(txt) {
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD RESPONSE CAME CODE STARTS HERE
                        $('#dyna_div').addClass('my_alert-success').removeClass('my_alert-info');
                        $('#info_txt').html('Success...');
                        $('body').css('overflow', '');
                        setTimeout(function () {
                            $('#main_load_div').css('display', 'none');
                        }, 100);
                        //THIS IS FOR NOTIFICATION WHEN AJAX LOAD RESPONSE CAME CODE ENDS HERE
                    }
                    var my_check = '<?php echo $this->config->item('base_url'); ?>';
                    $(document).ready(function () {

                        $('#cls_inf_bt').click(function () {
                            $('#main_load_div').css('display', 'none');
                        });
                    });
                </script>
                <input name="" type="hidden" value="1000" id="aja_notf_time">
                <!--AJAX LOADING AND NOTIFICATIONS ENDS HERE-->

                <div class="alert_img" id="main_load_div" style="display:none;">
                    <div class=" my_alert my_alert-dismissable my_alert-info" id="dyna_div">
                        <div class="fa" id="load_img_div"><img src="<?= $theme_path; ?>/images/loader7.gif" style="position:relative; top:-2px;" />
                        </div>

                        <div id="info_txt" class=""></div>
                        <button id="cls_inf_bt" type="button" class=" my_close" data-dismiss="alert" aria-hidden="true">X</button>
                    </div>
                </div>
                <?php echo $content; ?>
            </div>
        </div>
        </div>

        <!--<div class="print_footer">
                        <p style="text-align:center;">This Software Designed and Developed by F2F Solutions</p>
                        </div>-->
        <!-- mainwrapper -->
        <!--footer-->
        <footer class="main-footer">
            <div class="container">
                <div class="copyright" id="bot_copyright">
                    <div class="nvqc-show-hide-log  mt-foot">Copyright <?php echo date('Y'); ?> &COPY; Mobi-Point. <span class="pull-right">Powered By <a href="http://f2fsolutions.co.in/" target="_blank">F2F Solutions</a></span></div>
                </div>
            </div>

        </footer>

        <script type="text/javascript">

            $(document).ready(function () {
                $(document).keydown(function (e) {
                    var keycode = e.keyCode;
                    //  alert(keycode);
                    /*   if (keycode == 18) {
                     // (alt key)
                     var tab = ".masters_tab1";
                     var tab_sub = ".masters_tab1 ul.nav nav-treeview";
                     $(".masters_tab1").hover(
                     function () {
                     $(tab).addClass("active");
                     $(tab_sub).css({opacity: 1, visibility: "visible", 'margin-top': "0px"});
                     }, function () {
                     $(tab).removeClass("active");
                     $(tab_sub).css({opacity: 0, visibility: "hidden"});
                     }
                     );
                     if ($('.masters_tab1').hasClass('active')) {
                     $(tab).removeClass("active");
                     $(tab_sub).css({opacity: 0, visibility: "hidden"});
                     } else {
                     $(tab).addClass("active");
                     $(tab_sub).css({opacity: 1, visibility: "visible", 'margin-top': "-20px"});
                     }
                     return false;
                     }*/
                    if (e.keyCode == 40) {
                        //(down arrow)
                        if ($('.masters_tab1').hasClass('active')) {
                            var tab = ".masters_tab1";
                            var tab_sub = ".masters_tab1 ul.nav nav-treeview";
                            $(tab).addClass("active");
                            $(tab_sub).css({opacity: 1, visibility: "visible"});
                            var focus_inc = $('#focus_inc').val();
                            if (focus_inc == "")
                            {
                                var focus_inc = 0;
                            }
                            var inc_val = parseInt(focus_inc) + parseInt("1");
                            var i = inc_val;
                            var tab_sub = ".key_tab" + i;
                            {
                                var j = parseInt($('#focus_inc').val());
                                var tab_subs = ".key_tab" + j;
                                $(tab_subs).removeClass("active");
                                $(tab_subs).css({background: "", color: ""});
                            }
                            $(tab_sub).addClass("active");
                            $(tab_sub).css({opacity: 1, visibility: "visible"});
                            $(tab_sub).css({background: "#1e9ff2", color: "#fff"});
                            if (i <= 12)
                            {
                                $('#focus_inc').val(i);
                            }
                            return false;
                        }
                    }
                    if (e.keyCode == 38) {
                        //(up arrow)
                        if ($('.masters_tab1').hasClass('active')) {
                            var tab = ".masters_tab1";
                            var tab_sub = ".masters_tab1 ul.nav nav-treeview";
                            $(tab).addClass("active");
                            $(tab_sub).css({opacity: 1, visibility: "visible"});
                            var focus_inc = $('#focus_inc').val();
                            if (focus_inc == "")
                            {
                                var focus_inc = 13;
                            }
                            var inc_val = parseInt(focus_inc) - parseInt("1");
                            //  }
                            var i = inc_val;
                            var tab_sub = ".key_tab" + i;
                            {
                                var j = parseInt($('#focus_inc').val());
                                var tabs = ".key_tab" + j;
                                var tab_subs = ".key_tab" + j;
                                $(tabs).removeClass("active");
                                $(tab_subs).css({background: "", color: ""});
                            }
                            $(tab_sub).addClass("active");
                            $(tab_sub).css({opacity: 1, visibility: "visible"});
                            $(tab_sub).css({background: "#1e9ff2", color: "#fff"});
                            // alert(i);
                            if (i >= 1)
                            {
                                $('#focus_inc').val(i);
                            }
                            return false;
                        }
                    }
                    if (e.keyCode == 13) {
                        var focus_inc = $('#focus_inc').val();
                        if (focus_inc == 1)
                        {
                            document.location.href = '<?php echo base_url() . "masters/suppliers/"; ?>';
                        }
                        if (focus_inc == 2)
                        {
                            document.location.href = '<?php echo base_url() . "masters/customers/"; ?>';
                        }
                        if (focus_inc == 3)
                        {
                            document.location.href = '<?php echo base_url() . "masters/firms/"; ?>';
                        }
                        if (focus_inc == 4)
                        {
                            document.location.href = '<?php echo base_url() . "masters/user_roles/"; ?>';
                        }
                        if (focus_inc == 5)
                        {
                            document.location.href = '<?php echo base_url() . "masters/users/"; ?>';
                        }
                        if (focus_inc == 6)
                        {
                            document.location.href = '<?php echo base_url() . "masters/products/"; ?>';
                        }
                        if (focus_inc == 7)
                        {
                            document.location.href = '<?php echo base_url() . "masters/categories/"; ?>';
                        }
                        if (focus_inc == 8)
                        {
                            document.location.href = '<?php echo base_url() . "masters/brands/"; ?>';
                        }
                        if (focus_inc == 9)
                        {
                            document.location.href = '<?php echo base_url() . "masters/reference_groups/"; ?>';
                        }
                        if (focus_inc == 10)
                        {
                            document.location.href = '<?php echo base_url() . "masters/sales_man/"; ?>';
                        }
                        if (focus_inc == 11)
                        {
                            document.location.href = '<?php echo base_url() . "masters/email_settings/"; ?>';
                        }
                        if (focus_inc == 12)
                        {
                            document.location.href = '<?php echo base_url() . "masters/biometric/settings/"; ?>';
                        }


                    }


                    if (e.ctrlKey && keycode == 81) {
                        // (ctrl+ q )
                        document.location.href = '<?php echo base_url() . "quotation/"; ?>';
                    }
                    if (e.ctrlKey && keycode == 82) {
                        // (ctrl+ r )
                        document.location.href = '<?php echo base_url() . "sales_return/"; ?>';
                    }
                    if (e.ctrlKey && keycode == 73) {
                        e.preventDefault();
                        // (ctrl+ i )
                        document.location.href = '<?php echo base_url() . "sales/new_direct_invoice/"; ?>';
                    }
                    if (e.ctrlKey && keycode == 79) {
                        e.preventDefault();
                        // (ctrl+ o )
                        document.location.href = '<?php echo base_url() . "purchase_order/"; ?>';
                    }
                    if (e.ctrlKey && keycode == 90) {
                        e.preventDefault();
                        // (ctrl+ z )
                        document.location.href = '<?php echo base_url() . "purchase_return/index/"; ?>';
                    }

                });
                $('input,.form-control').attr('autocomplete', 'off');
                $('.mail').live('keyup', function () {
                    $(this).val($(this).val().toLowerCase());
                });
                $('form').submit(function () {


                    //$('input:submit').attr("disabled", true);

                    //   $('input:submit').attr("disabled", true);

                    $('input:submit').val('Please wait Processing');
                });
            });
            var BASE_URL = '<?php echo $this->config->item('base_url'); ?>';

        </script>


        <script src="<?= $theme_path; ?>/js/jquery-migrate-1.2.1.min.js"></script>

        <script src="<?= $theme_path; ?>/js/bootstrap.min.js"></script>
        <script src="<?= $theme_path; ?>/js/modernizr.min.js"></script>
        <script src="<?= $theme_path; ?>/js/pace.min.js"></script>
        <!-- <script src="<?= $theme_path; ?>/js/retina.min.js"></script> -->
        <script src="<?= $theme_path; ?>/js/jquery.cookies.js"></script>
        <script src="<?= $theme_path; ?>/js/flot/jquery.flot.min.js"></script>
        <script src="<?= $theme_path; ?>/js/flot/jquery.flot.resize.min.js"></script>
        <script src="<?= $theme_path; ?>/js/flot/jquery.flot.spline.min.js"></script>
        <script src="<?= $theme_path; ?>/js/jquery.sparkline.min.js"></script>
        <script src="<?= $theme_path; ?>/js/morris.min.js"></script>
        <script src="<?= $theme_path; ?>/js/raphael-2.1.0.min.js"></script>
        <script src="<?= $theme_path; ?>/js/bootstrap-wizard.min.js"></script>
		 <script src="<?= $theme_path; ?>/js/bootstrap-tagsinput.min.js"></script>
        <script src="<?= $theme_path; ?>/js/custom.js"></script>
        <script src="<?= $theme_path; ?>/js/dashboard.js"></script>
        <script src="<?= $theme_path; ?>/js/jquery.dataTables.min.js"></script>
        <script src="<?= $theme_path; ?>/js/dataTables.bootstrap.js"></script>
        <script src="<?= $theme_path; ?>/js/dataTables.responsive.js"></script>
        <script src="<?= $theme_path; ?>/js/fixedheader/dataTables.fixedHeader.min.js"></script>

        <script src="<?= $theme_path; ?>/js/select2.min.js"></script>
        <script type="text/javascript">
        var cur_class="<?php echo $cur_class;?>";
        if(cur_class == 'report' || cur_class == 'purchase_order' || cur_class == 'sales'){
            $('body').addClass('sidebar-collapse');
        }
            $('.dot_val').live('keypress', function (eve) {
                if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0)) {
                    if (eve.which != 8)
                        eve.preventDefault();
                }

                // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
                $('.filterme').keyup(function (eve) {
                    if ($(this).val().indexOf('.') == 0) {
                        $(this).val($(this).val().substring(1));
                    }
                });
            });
            $(".int_val").live('keypress', function (event) {
                var characterCode = (event.charCode) ? event.charCode : event.which;
                var browser;
                if ($.browser.mozilla)
                {
                    if ((characterCode > 47 && characterCode < 58) || characterCode == 8 || event.keyCode == 39 || event.keyCode == 37 || characterCode == 97 || characterCode == 118)
                    {

                        return true;
                    }
                    return false;
                }
                if ($.browser.chrome)
                {
                    if (event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57)) {
                        //display error message

                        return false;
                    }
                }


            });
        </script>
        <script>

            jQuery(document).ready(function () {

                jQuery('#basicTable').DataTable({
                    responsive: true,
                    columnDefs: [
                        {responsivePriority: 1, targets: 0},
                        {responsivePriority: 2, targets: -2}
                    ]
                });
                var shTable = jQuery('#shTable').DataTable({
                    "fnDrawCallback": function (oSettings) {
                        jQuery('#shTable_paginate ul').addClass('pagination-active-dark');
                    },
                    responsive: true
                });
                // Show/Hide Columns Dropdown
                jQuery('#shCol').click(function (event) {
                    event.stopPropagation();
                });
                jQuery('#shCol input').on('click', function () {

                    /** Notification JSON coding **/
                    // Get the column API object
                    var column = shTable.column($(this).val());
                    // Toggle the visibility
                    if ($(this).is(':checked'))
                        column.visible(true);
                    else
                        column.visible(false);
                });
                var exRowTable = jQuery('#exRowTable').DataTable({
                    responsive: true,
                    "fnDrawCallback": function (oSettings) {
                        jQuery('#exRowTable_paginate ul').addClass('pagination-active-success');
                    },
                    "ajax": "ajax/objects.txt",
                    "columns": [{
                            "class": 'details-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        }, {
                            "data": "name"
                        }, {
                            "data": "position"
                        }, {
                            "data": "office"
                        }, {
                            "data": "salary"
                        }],
                    "order": [
                        [1, 'asc']
                    ]
                });
                // Add event listener for opening and closing details
                jQuery('#exRowTable tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = exRowTable.row(tr);
                    if (row.child.isShown()) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        // Open this row
                        row.child(format(row.data())).show();
                        tr.addClass('shown');
                    }
                });
                // DataTables Length to Select2
                jQuery('div.dataTables_length select').removeClass('form-control input-sm');
                jQuery('div.dataTables_length select').css({
                    width: '60px'
                });
                jQuery('div.dataTables_length select').select2({
                    minimumResultsForSearch: -1
                });
            });
            function format(d) {
                // `d` is the original data object for the row
                return '<table class="table table-bordered nomargin">' +
                        '<tr>' +
                        '<td>Full name:</td>' +
                        '<td>' + d.name + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Extension number:</td>' +
                        '<td>' + d.extn + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td>Extra info:</td>' +
                        '<td>And any further details here (images etc)...</td>' +
                        '</tr>' +
                        '</table>';
            }
            var UP_ARROW = 38,
                    DOWN_ARROW = 40;


        </script>
        <style type="text/css">
            .text_right {
                text-align: right;
            }
        </style>
        <script>
            $('.excel_btn').live('click', function () {
                $('#basicTable').find('.hide_class').remove();
                fnExcelReport();
                window.reload();
            });
        </script>
        <script>
            function fnExcelReport()
            {
                var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
                var textRange;
                var j = 0;


                tab = document.getElementById('basicTable'); // id of table
                for (j = 0; j < tab.rows.length; j++)
                {
                    tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                    //tab_text=tab_text+"</tr>";
                }
                tab_text = tab_text + "</table>";
                tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
                tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
                tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
                var ua = window.navigator.userAgent;
                var msie = ua.indexOf("MSIE ");
                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
                {
                    txtArea1.document.open("txt/html", "replace");
                    txtArea1.document.write(tab_text);
                    txtArea1.document.close();
                    txtArea1.focus();
                    sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
                } else                 //other browser not tested on IE 11
                    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                return (sa);
            }
        </script>
        <!-- start responsive menu -->
        <script>
            $(document).ready(function () {
                var touch = $('#resp-menu');
                var menu = $('.menu');
                $(touch).on('click', function (e) {
                    e.preventDefault();
                    menu.slideToggle();
                });
                $(window).resize(function () {
                    var w = $(window).width();
                    if (w > 768 && menu.is(':hidden')) {
                        menu.removeAttr('style');
                    }
                });

                $('form').submit(function () {

                    //$('input:submit').attr("disabled", true);

                    //   $('input:submit').attr("disabled", true);

                    $('input:submit').val('Please wait Processing');
                });


                $('.migrateion').on('click', function () {
                    for_loading();
//  alert(date);
                    $.ajax({
                        url: BASE_URL + "attendance/epushserver_run",
                        type: "POST",
                        // data: {last_logdate: date},
                        success: function (result)
                        {
                            for_response(result);
                            if (result == 0)
                            {
                                alert('no data');
                            } else {
                                location.reload(true);
                                alert('success');
                            }


                        }
                    });

                });
            });
        </script>
        <script type="text/javascript" src="<?= $theme_path; ?>/js/jquery.fullscreen.js"></script>
        <script type="text/javascript">
            $(function () {
                // check native support
                $('#support').text($.fullscreen.isNativelySupported() ? 'supports' : 'doesn\'t support');

                // open in fullscreen
                $('#fullscreen .requestfullscreen').click(function () {
                    $('#fullscreen').fullscreen();
                    return false;
                });

                // exit fullscreen
                $('#fullscreen .exitfullscreen').click(function () {
                    $.fullscreen.exit();
                    return false;
                });

                // document's event
                $(document).bind('fscreenchange', function (e, state, elem) {
                    // if we currently in fullscreen mode
                    if ($.fullscreen.isFullScreen()) {
                        $('#fullscreen .requestfullscreen').hide();
                        $('#fullscreen .exitfullscreen').show();
                    } else {
                        $('#fullscreen .requestfullscreen').show();
                        $('#fullscreen .exitfullscreen').hide();
                    }

                    $('#state').text($.fullscreen.isFullScreen() ? '' : 'not');
                });
            });
        </script>
        
        <!-- Sidebar Menu -->
		<script src="<?= $theme_path; ?>/sidemenu/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <script src="<?= $theme_path; ?>/sidemenu/adminlte.min.js"></script>
        
    </body>
</html>