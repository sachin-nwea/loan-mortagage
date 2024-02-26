<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    $branches = array(
        'bank_id' => $data_to_store['bank_id'],
        'branch_name' => $data_to_store['branch_name'],
        'state' => $data_to_store['state'],
        'city' => $data_to_store['city'],
        'address' => $data_to_store['address'],
        'branch_area' => $data_to_store['branch_area'],
        'email' => $data_to_store['email'],
        'pin_code'=> $data_to_store['pin_code'],
        'branch_code'=> $data_to_store['pin_code'],
        'officer_email' => $data_to_store['officer_email'],
        'officer_email2' => $data_to_store['officer_email'],
        'created_at'   => date('Y-m-d H:i:s'),
        'created_by'   => $_SESSION['admin_user_id']
    );
    //Insert timestamp
    $db = getDbInstance();
    $last_id = $db->insert('branches', $branches);

    if ($last_id)
    {
    	$_SESSION['success'] = "Branch added successfully!";
    	header('location: branches.php');
    	exit();
    } else {
        $_SESSION['failure'] = "Branch not Added!".$db->getLastError();
        header('location: branches.php');
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
$title = 'Add Branch';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Branch</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="branch_form" enctype="multipart/form-data">
       <?php  include_once('./forms/branches_form.php'); ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>