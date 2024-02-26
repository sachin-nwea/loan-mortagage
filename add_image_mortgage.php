<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$mortgage_id = filter_input(INPUT_GET, 'mortgage_id', FILTER_VALIDATE_INT);

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $mortgage_id = filter_input(INPUT_POST, 'mortgage_id', FILTER_VALIDATE_INT);
    $target_dir = "assets/gold_images/";
    $success = false;
    $fileName = '';

    if(isset($_FILES["uploadImage"]["tmp_name"]) && $_FILES["uploadImage"]["tmp_name"] != '') {
        if($_FILES["uploadImage"]["size"] > 0) {
            $target_file = $target_dir . $_FILES["uploadImage"]["name"];
            $paths = explode("/", $_FILES["uploadImage"]["type"]);
            $imageFileType = strtolower($paths[1]);
            if (($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") &&
                move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $target_file)) {
                    $success = true;
                    $fileName = $target_file;
            }
        }
    }

    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $customer_mortgages_data = array('mortgage_image_path' => $fileName);
       //Insert timestamp
    $db = getDbInstance();
    $db->where('mortgage_id',$mortgage_id);
    $status = $db->update('customer_mortgages', $customer_mortgages_data, 1);
    try {
        $db->commit();
    } catch (Exception $e) {
    }

    if ($status) {
    	$_SESSION['success'] = "Image Upload successfully!";
    } else {
        $_SESSION['failure'] = "Image not Upload successfully! ".$db->getLastError();
    }
    header('location: mortgages.php');
    exit();
}

$db = getDbInstance();
$db->where('mortgage_id', $mortgage_id);
$mortgages = $db->getOne("customer_mortgages");
$title = 'Add Mortgage Image';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add New Image</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="mortgage_form" enctype="multipart/form-data">
        <fieldset>
            <div class="row">
                <div class="col-lg-5">
                    <label class="label_css">Upload Mortgage Image</label>
                </div>
                <div class="col-lg-7">
                    <input type="file" name="uploadImage" onchange="checkExtension(this.value);" id="logo" placeholder="Add Image" class="form-control-header " />
                    <input type="hidden" name="mortgage_id" value="<?= $_GET['mortgage_id'] ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 updateLogo" id="updateLogo">
                    <?php
                    if(!empty($mortgages['mortgage_image_path'])) {
                        echo '<label class="label_css">Uploaded Image</label>';
                        echo '<img src="' . $mortgages['mortgage_image_path'] . '" height="100" width="100" />';
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="banks_id" value="<?= $_GET['bank_id'] ?>">
                    <label class="label_css" for="Back"><a class="btn-info btn"  href="mortgages.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>

                    <button type="submit" class="btn btn-success" onsubmit="checkFileExtension();">Save <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
    function checkFileExtension() {
        let extension = $("#logo").val().split('.').pop().toLowerCase().toLowerCase();
        let validExtensions= ['jpg', 'png', 'jpeg', 'gif'];
        if(extension != '' && !validExtensions.includes(extension)) {
            return false;
        } else {
            document.getElementById("mortgage_form").submit();
        }
    }
</script>
<?php include_once 'includes/footer.php'; ?>