<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    //Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');
    $data_to_store['created_by'] = $_SESSION['admin_user_id'];
    $db = getDbInstance();

    $last_id = $db->insert('ornaments', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Ornament added successfully!";
    	header('location: ornaments.php');
    	exit();
    }
    else
    {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
$title = 'Add Ornament';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Ornament</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="ornaments_form" enctype="multipart/form-data">
       <?php  include_once('./forms/ornaments_form.php'); ?>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function(){
   $("#ornaments_form").validate({
       rules: {
           ornament_name: {
                required: true,
                minlength: 2
            },
        }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>