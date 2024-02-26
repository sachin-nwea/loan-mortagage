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
    $target_dir = "assets/images/";
    $success = false;
    $target_file = '';
    $bank = array($bank_id);
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data = array_filter($_POST);
    $data_to_update = array_diff($data, $bank);
    $banksData = array(
        'bank_name' => $data_to_update['bank_name'],
        'updated_at' => date('Y-m-d H:i:s')
    );

    if(isset($_FILES["logo"]["tmp_name"]) && $_FILES["logo"]["tmp_name"] != '') {
        if($_FILES["logo"]["size"] > 0) {
            $target_file = $target_dir . $_FILES["logo"]["name"];
            $paths = explode("/", $_FILES["logo"]["type"]);
            $imageFileType = strtolower($paths[1]);
            if (($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") &&
                move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                $success = true;
                $banksData['logo'] = $target_file;
            }
        }
    }

    if (!$success && isset($data_to_update['existing_logo']) && $data_to_update['existing_logo'] != '') {
        $banksData ['logo'] = $data_to_update['existing_logo'];
    }

    //Get input data
    $db = getDbInstance();
    $db->where('id',$bank_id);
    $stat = $db->update('banks', $banksData);
    $db->commit();

    if($stat)
    {
        $_SESSION['success'] = "Bank updated successfully!";
        //Redirect to the listing page,
        header('location: banks.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    } else {
        $_SESSION['failure'] = "Bank not Updated! ".$db->getLastError();
        header('location: banks.php');
        exit();
    }
}


//If edit variable is set, we are performing the update operation.
if($edit)
{
    $db = getDbInstance();
    $db->where('id', $bank_id);
    //Get data to pre-populate the form.
    $banks = $db->getOne("banks");
}
$title = 'Update Bank';
?>

<?php include_once 'includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Bank</h2>
    </div>
    <!-- Flash messages -->
    <?php include('./includes/flash_messages.php'); ?>

    <form class="well" action="" method="post" enctype="multipart/form-data" id="bank_form" onsubmit=" return checkFileExtension();">
        <?php
            //Include the common form for add and edit  
            require_once('./forms/bank_form.php');
        ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>