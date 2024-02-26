<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$bank_id = filter_input(INPUT_GET, 'bank_id', FILTER_VALIDATE_INT);
$edit = true;

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get customer id form query string parameter.
    $bank_id = filter_input(INPUT_POST, 'banks_id', FILTER_SANITIZE_STRING);

    $bank = array($bank_id);

    $data_to_update = array_filter($_POST);
    $data_to_update = array_diff($data_to_update, $bank);

    $branchesData = array(
        'bank_id' => $data_to_update['bank_id'],
        'branch_name' => $data_to_update['branch_name'],
        'state' => $data_to_update['state'],
        'city' => $data_to_update['city'],
        'address' => $data_to_update['address'],
        'branch_area' => $data_to_update['branch_area'],
        'email' => $data_to_update['email'],
        'pin_code'=> $data_to_update['pin_code'],
        'branch_code'=> $data_to_update['pin_code'],
        'officer_email' => $data_to_update['officer_email'],
        'officer_email2' => $data_to_update['officer_email2'],
        'updated_at' => date('Y-m-d H:i:s')
    );

    //Get input data
    $db = getDbInstance();
    $db->where('id',$bank_id);
    $stat = $db->update('branches', $branchesData);
    $db->commit();

    if($stat)
    {
        $_SESSION['success'] = "Branch updated successfully!";
        //Redirect to the listing page,
        header('location: branches.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db = getDbInstance();
    if($_SESSION['admin_type'] != 'super')
        $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);
    $db->where('id', $bank_id);
    //Get data to pre-populate the form.
    $branches = $db->getOne("branches");
}
$title = 'Update Branches';
include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Branch</h2>
    </div>
    <!-- Flash messages -->
    <?php
    include('./includes/flash_messages.php')
    ?>

    <form class="well" action="edit_branches.php" method="post" enctype="multipart/form-data" id="branch_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./forms/branches_form.php');
        ?>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>