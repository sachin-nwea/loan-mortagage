<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//Only super admin is allowed to access this page
if ($_SESSION['admin_type'] != 'super') {
    // show permission denied message
    echo 'Permission Denied';
    header('location:index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$data_to_store = filter_input_array(INPUT_POST);
    $data_to_store['banks_allowed'] = !empty($data_to_store['banks_allowed'])
        ? (in_array('all',$data_to_store['banks_allowed'])? 'all' : implode(",", $data_to_store['banks_allowed'])) : '';
    $data_to_store['state_allowed'] = !empty($data_to_store['state_allowed'])
        ? (in_array('all',$data_to_store['state_allowed'])? 'all' : implode(",", $data_to_store['state_allowed'])): '';

    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('user_name',$data_to_store['user_name']);
    $db->get('admin_accounts');
    
    if ($db->count >=1){
        $_SESSION['failure'] = "User name already exists please choose different username";
        header('location: add_admin.php');
        exit();
    }

    //Encrypt password
    $data_to_store['password'] = password_hash($data_to_store['password'],PASSWORD_DEFAULT);
    //reset db instance
    $db = getDbInstance();
    $last_id = $db->insert ('admin_accounts', $data_to_store);
    if($last_id)
    {

    	$_SESSION['success'] = "Admin user added successfully!";
    	header('location: admin_users.php');
    	exit();
    }  
    
}
$edit = false;
$title = 'Add Admin';
require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header" style="margin: 10px 0px 0px 0px !important">Add Admin User</h2>
		</div>
	</div>
	 <?php 
    include_once('includes/flash_messages.php');
    ?>
	<form class="well form-horizontal" action=" " method="post"  id="add_form" enctype="multipart/form-data">
		<?php include_once './forms/admin_users_form.php'; ?>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>