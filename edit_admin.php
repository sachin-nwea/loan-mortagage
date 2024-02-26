<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//User ID for which we are performing operation
$admin_user_id = filter_input(INPUT_GET, 'admin_user_id');
$edit = true;
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// If non-super user accesses this script via url. Stop the execution
	if ($_SESSION['admin_type'] != 'super') {
		// show permission denied message
		echo 'You dont have Permission to update the users.';
        header('location:index.php');
		exit();
	}

	// Sanitize input post if we want
	$data_to_update = filter_input_array(INPUT_POST);

    $data_to_update['banks_allowed'] = !empty($data_to_update['banks_allowed'])
        ? (in_array('all',$data_to_update['banks_allowed'])? 'all' : implode(",", $data_to_update['banks_allowed'])) : '';
    $data_to_update['state_allowed'] = !empty($data_to_update['state_allowed'])
        ? (in_array('all',$data_to_update['state_allowed'])? 'all' : implode(",", $data_to_update['state_allowed'])): '';

	$admin_user_id = filter_input(INPUT_GET, 'admin_user_id', FILTER_VALIDATE_INT);

	$db = getDbInstance();
	$db->where('id', $admin_user_id);
	$stat = $db->update('admin_accounts', $data_to_update);

	if ($stat) {
		$_SESSION['success'] = "Admin user has been updated successfully";
	} else {
		$_SESSION['failure'] = "Failed to update Admin user : " . $db->getLastError();
	}

	header('location: admin_users.php');
	exit;

}

//Select where clause
$db = getDbInstance();
$db->where('id', $admin_user_id);

$admin_account = $db->getOne("admin_accounts");

// Set values to $row

// import header
$title = 'Update Admin';
require_once 'includes/header.php';
?>
<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Update User</h2>
        </div>

    </div>
    <?php include_once 'includes/flash_messages.php';?>
    <form class="well form-horizontal" action="" method="post"  id="edit_form" enctype="multipart/form-data">
        <?php include_once './forms/admin_users_form.php';?>
    </form>
</div>
<?php include_once 'includes/footer.php';?>