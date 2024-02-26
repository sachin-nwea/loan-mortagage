<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$users = new OrderingValues();

// Only super admin is allowed to access this page
if ($_SESSION['admin_type'] != 'super')
{
    // Show permission denied message
    header('HTTP/1.1 401 Unauthorized', true, 401);
    header('location:index.php');
    exit('401 Unauthorized');
}
include BASE_PATH . '/includes/search_header.php';

$select = array('id', 'user_name', 'full_name', 'banks_allowed', 'admin_type', 'state_allowed', 'age');

// Get result of the query.
$rows = $db->arraybuilder()->paginate('admin_accounts', $page, $select);
$total_pages = $db->totalPages;

$title = 'Admin Users';
include BASE_PATH . '/includes/header.php';
?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Admin users</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_admin.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add New  Admin</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <?php
    if (isset($del_stat) && $del_stat == 1)
        echo '<div class="alert alert-info">Successfully deleted</div>';
    ?>
    
    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo htmlspecialchars($search_string, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
                foreach ($users->setUsersOrderingValues() as $opt_value => $opt_name):
                    ($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
                    echo ' <option value="'.$opt_value.'" '.$selected.'>'.$opt_name.'</option>';
                endforeach;
                ?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php if ($order_by == 'Asc') echo 'selected';?> >Asc</option>
                <option value="Desc" <?php if ($order_by == 'Desc') echo 'selected';?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="10%">User Name</th>
                <th width="10%">Full Name</th>
                <th width="20%">Banks Available</th>
                <th width="20%">States</th>
                <th width="10%">Admin type</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($rows as $row): ?>
            <?php if ($row['id'] != 1) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php
                    $db = getDbInstance();
                    // Set pagination limit
                    $db->pageLimit = 100;
                    if (isset($row['banks_allowed']) && $row['banks_allowed'] != '') {
                        if($row['banks_allowed'] == 'all') {
                            echo 'All Banks Allowed';
                        } else {
                            $banksOptions = explode(",", $row['banks_allowed']);
                            foreach ($banksOptions as $banksOption) {
                                $db->orWhere('id', $banksOption);
                            }

                            $select = array('bank_name');
                            $banks = $db->get('banks', 100, $select);
                            foreach ($banks as $bank) {
                                echo $bank['bank_name'] . ',&nbsp;';
                            }
                        }
                    } ?></td>
                <td><?php $db = getDbInstance();
                    // Set pagination limit
                    $db->pageLimit = 100;
                    if (isset($row['state_allowed']) && $row['state_allowed'] != '') {
                        if($row['state_allowed'] == 'all') {
                            echo 'All States Allowed';
                        } else {
                            $stateOptions = explode(",", $row['state_allowed']);
                            foreach ($stateOptions as $stateOption) {
                                $db->orWhere('state_id', $stateOption);
                            }

                            $select = array('state_title');
                            $states = $db->get('state', 100, $select);
                            foreach ($states as $state) {
                                echo $state['state_title'] . ',&nbsp;';
                            }
                        }
                    }
                    ?></td>
                <td><?php echo htmlspecialchars($row['admin_type']); ?></td>
                <td>
                    <a href="edit_admin.php?admin_user_id=<?php echo $row['id']; ?>" class="btn btn-primary" title="Edit Details"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="reset_password.php?admin_user_id=<?php echo $row['id']; ?>" class="btn btn-primary" title="Reset Password"><i class="glyphicon glyphicon-user"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_user.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Are you sure you want to delete this Admin?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php } endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <?php
        if (!empty($_GET)) {
            // We must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            // To keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        // Show pagination links
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = '';
                echo '<li' . $li_class . '><a href="admin_users.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
