<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//Get DB instance. function is defined in config.php
$db = getDbInstance();

//Get Dashboard information
if($_SESSION['admin_type'] != 'super')
    $db->where('created_by', $_SESSION['admin_user_id']);
$numCustomers = $db->getValue("customers", "count(*)");

if($_SESSION['admin_type'] != 'super')
    $db->where('created_by', $_SESSION['admin_user_id']);
$numBranches = $db->getValue("branches", "count(*)");

if($_SESSION['admin_type'] != 'super')
    $db->where('created_by', $_SESSION['admin_user_id']);
$numMortgages = $db->getValue("customer_mortgages", "count(*)");

if($_SESSION['admin_type'] != 'super')
    $db->where('created_by', $_SESSION['admin_user_id']);
$numOrnaments = $db->getValue("ornaments", "count(*)");

$adminUsers = $db->getValue("admin_accounts", "count(*)");

$numCarat = $db->getValue("bank_list", "count(*)");

$numBanks = $db->getValue("banks", "count(*)");

$title = 'Loan Mortgage';
include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= __("Dashboard") ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

        <?php
        include_once('includes/flash_messages.php');
        ?>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numCustomers; ?></div>
                            <div><?= __("Customers") ?></div>
                        </div>
                    </div>
                </div>
                <a href="customers.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bank fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numBranches; ?></div>
                            <div><?= __("Branches") ?></div>
                        </div>
                    </div>
                </div>
                <a href="branches.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-balance-scale fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numMortgages; ?></div>
                            <div><?= __("Mortgages") ?></div>
                        </div>
                    </div>
                </div>
                <a href="mortgages.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <!-- /.row -->
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-id-card fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $numOrnaments; ?></div>
                                <div><?= __("Ornaments") ?></div>
                            </div>
                        </div>
                    </div>
                    <a href="ornaments.php">
                        <div class="panel-footer">
                            <span class="pull-left"><?= __("View Details") ?></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <div class="row">
        <?php if($_SESSION['admin_type'] == 'super') { ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-id-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $adminUsers; ?></div>
                            <div><?= __("Admin Accounts"); ?></div>
                        </div>
                    </div>
                </div>
                <a href="admin_users.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-bank fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numBanks; ?></div>
                            <div><?= __("Banks") ?></div>
                        </div>
                    </div>
                </div>
                <a href="banks.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-id-card fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numCarat; ?></div>
                            <div><?= __("Bank Options") ?></div>
                        </div>
                    </div>
                </div>
                <a href="bank_options.php">
                    <div class="panel-footer">
                        <span class="pull-left"><?= __("View Details") ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
