<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//Only super admin is allowed to access this page

if ($_SESSION['admin_type'] != 'super') {
    // show permission denied message
    header('location:index.php');
    exit();
}


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $target_dir = "assets/images/";
    $success = false;
    $fileName = '';

    if(isset($_FILES["logo"]["tmp_name"]) && $_FILES["logo"]["tmp_name"] != '') {
        if($_FILES["logo"]["size"] > 0) {
            $target_file = $target_dir . $_FILES["logo"]["name"];
            $paths = explode("/", $_FILES["logo"]["type"]);
            $imageFileType = strtolower($paths[1]);
            if (($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") &&
                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                $success = true;
                $fileName = $target_file;
            }
        }
    }

    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    $banks = array(
        'bank_name' => $data_to_store['bank_name'],
        'logo' => $fileName,
        'created_at'   => date('Y-m-d H:i:s')
    );
    //Insert timestamp
    $db = getDbInstance();
    $last_id = $db->insert('banks', $banks);

    if ($last_id)
    {
    	$_SESSION['success'] = "New Bank added successfully!";
    	header('location: banks.php');
    	exit();
    } else {
        $_SESSION['failure'] = "New Bank not Added!".$db->getLastError();
        header('location: banks.php');
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
$banks = array();
$title = 'Add Bank';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add New Bank</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="bank_form" enctype="multipart/form-data" onsubmit="return checkFileExtension();">
       <?php  include_once('./forms/bank_form.php'); ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>