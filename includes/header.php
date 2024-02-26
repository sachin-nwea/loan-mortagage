<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/x-icon" href="assets/images/favicon1.ico">
        <!--<meta http-equiv="refresh" content="1200;url=logout.php" />-->

        <title><?= $title ?></title>

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
        <link  rel="stylesheet" href="assets/css/styles.css" type="text/css" />
        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin-2.css" rel="stylesheet" type="text/css">
        <!-- Custom Fonts -->
        <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" >
        <script src="assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/common.js" type="text/javascript"></script>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php
            if (isset($_SESSION['user_logged_in'])): ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only"><?= __('Toggle Navigation')?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php"><?= __('Loan Mortgage')?></a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="change_password.php?admin_user_id=<?php echo $_SESSION['admin_user_id']; ?>"><i class="fa fa-chain fa-fw"></i><?= __("Change Password") ?></a>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i><?= __("Logout") ?></a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> <?= __('Dashboard') ?></a>
                                </li>

                                <li <?php echo (CURRENT_PAGE == "customers.php" || CURRENT_PAGE == "add_customer.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-user-circle fa-fw"></i> <?= __('Customers') ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="customers.php"><i class="fa fa-list fa-fw"></i><?= __('List all Customers') ?></a>
                                        </li>
                                    <li>
                                        <a href="add_customer.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Customer') ?></a>
                                    </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "branches.php" || CURRENT_PAGE == "add_branches.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-bandcamp fa-fw"></i> <?= __('Branches') ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="branches.php"><i class="fa fa-list fa-fw"></i><?= __('List all Branches') ?></a>
                                        </li>
                                        <li>
                                            <a href="add_branches.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Branch') ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "ornaments.php" || CURRENT_PAGE == "add_ornament.php") ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-dollar fa-fw"></i> <?= __('Ornaments') ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="ornaments.php"><i class="fa fa-list fa-fw"></i><?= __('List all Ornaments') ?></a>
                                        </li>
                                        <li>
                                            <a href="add_ornament.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Ornaments') ?></a>
                                        </li>
                                    </ul>
                                </li>

                                <li <?php echo (in_array(CURRENT_PAGE, array("mortgages.php", "add_mortgage.php", "send_email.php")) ? 'class="active"' : ''); ?>>
                                    <a href="#"><i class="fa fa-balance-scale fa-fw"></i> <?= __('Mortgages') ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="mortgages.php"><i class="fa fa-list fa-fw"></i><?= __('List all Mortgages') ?></a>
                                        </li>
                                        <li>
                                            <a href="add_mortgage.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Mortgage') ?></a>
                                        </li>
                                        <li>
                                            <a href="send_emails.php"><i class="fa fa-envelope fa-fw"></i><?= __('Send Email') ?></a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php echo (CURRENT_PAGE == "contact_us.php" || CURRENT_PAGE == "store_details.php" ) ? 'class="active"' : ''; ?>>
                                    <a href="#"><i class="fa fa-envelope fa-fw"></i> <?= __('Store Connect') ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="contact_us.php"><i class="fa fa-user-circle fa-fw"></i><?= __('Contact Main Store') ?></a>
                                        </li>
                                        <li>
                                            <?php
                                            $db = getDbInstance();
                                            $db->pageLimit= 1;

                                            if($_SESSION['admin_type'] != 'super')
                                                $db->where('created_by', $_SESSION['admin_user_id']);
                                            $storeDetails = $db->get("store_details");
                                            if(isset($storeDetails) && $storeDetails[0]['id']) {
                                                echo '<a href="store_details.php?store_id='.$storeDetails[0]['id'].'"><i class="fa fa-bank fa-fw"></i>'. __("Store Details").'</a>';
                                            } else {
                                                echo '<a href="store_details.php"><i class="fa fa-bank fa-fw"></i>'. __("Store Details").'</a>';
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </li>
                                <?php if($_SESSION['admin_type'] == 'super') { ?>
                                    <li <?php echo (CURRENT_PAGE == "banks.php" || CURRENT_PAGE == "add_bank.php") ? 'class="active"' : ''; ?>>
                                        <a href="#"><i class="fa fa-bank fa-fw"></i> <?= __('Banks') ?><span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="banks.php"><i class="fa fa-list fa-fw"></i><?= __('List all Banks') ?></a>
                                            </li>
                                            <li>
                                                <a href="add_bank.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Bank') ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li <?php echo (CURRENT_PAGE == "bank_options.php" || CURRENT_PAGE == "add_bank_options.php") ? 'class="active"' : ''; ?>>
                                        <a href="#"><i class="fa fa-bars fa-fw"></i> <?= __('Bank Options') ?><span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="bank_options.php"><i class="fa fa-list fa-fw"></i><?= __('List all Bank Options') ?></a>
                                            </li>
                                            <li>
                                                <a href="add_bank_options.php"><i class="fa fa-plus fa-fw"></i><?= __('Add Bank Option') ?></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li <?php echo (CURRENT_PAGE == "admin_users.php" || CURRENT_PAGE == "add_admin.php") ? 'class="active"' : ''; ?>>
                                        <a href="#"><i class="fa fa-user-circle fa-fw"></i> <?= __('Admins') ?><span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="admin_users.php"><i class="fa fa-list fa-fw"></i><?= __('List all Admins') ?></a>
                                            </li>
                                            <li>
                                                <a href="add_admin.php"><i class="fa fa-plus fa-fw"></i><?= __('Add New Admin') ?></a>
                                            </li>
                                        </ul>
                                    </li>

                               <?php } ?>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
            <?php endif;?>
            <!-- The End of the Header -->