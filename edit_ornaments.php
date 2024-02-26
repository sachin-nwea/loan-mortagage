<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$ornament_id = filter_input(INPUT_GET, 'ornament_id', FILTER_VALIDATE_INT);
$edit = true;
$db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get ornament id form query string parameter.
    $ornament_id = filter_input(INPUT_POST, 'ornament_id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);
    $ornament = array($ornament_id);
    $data_to_update = array_diff($data_to_update, $ornament);
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');
    $db = getDbInstance();
    $db->where('id',$ornament_id);
    $stat = $db->update('ornaments', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Ornament updated successfully!";
        //Redirect to the listing page,
        header('location: ornaments.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}

if($edit)
{
    if($_SESSION['admin_type'] != 'super')
        $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);
    $db->where('id', $ornament_id);
    //Get data to pre-populate the form.
    $ornaments = $db->getOne("ornaments");
}
$title = 'Update Ornament';
include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Ornament</h2>
    </div>
    <!-- Flash messages -->
    <?php
    include('./includes/flash_messages.php')
    ?>

    <form class="well" action="" method="post" enctype="multipart/form-data" id="ornament_form">
        
        <?php
            //Include the common form for add and edit  
            require_once('./forms/ornaments_form.php');
        ?>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>