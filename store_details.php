<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$store_id = 0;
if($_GET['store_id']) {
    $store_id = $_GET['store_id'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_to_store = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    //Check whether the user name already exists ;
    if ($store_id > 0) {
        $db->where('id', $store_id);
        $stat = $db->update('store_details', $data_to_store);
        $_SESSION['success'] = "Store Details updated successfully!";
        $_SESSION['lang'] = $data_to_store['languages_code'];

    } else {
        $data_to_store['created_by'] = $_SESSION['admin_user_id'];
        $last_id = $db->insert('store_details', $data_to_store);
        if ($last_id)
            $_SESSION['success'] = "Store Details added successfully!";
        else
            $_SESSION['failure'] = "Store Details not stored".$db->getLastError();
    }
    header('Location:index.php');
}

$store_details = array();
$edit = false;
if($store_id > 0) {
    $db = getDbInstance();
    $db->where('id', $store_id);
    //Get data to pre-populate the form.
    $store_details = $db->getOne("store_details");
    $edit = true;
}
$title = 'Store Details';
require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Add Store Details </h2>
		</div>
	</div>
	<form class="well form-horizontal" action=" " method="post"  id="store_details_form" enctype="multipart/form-data" onsubmit="return validPhoneNumber($('#mobile1').val(), $('#mobile2').val())">
        <fieldset>
            <div class="row">
                <div class="col-lg-6">
                    <label class="label_css" for="store_name">Store Name*</label>
                    <input type="text" class="form-control-header " name="store_name" value="<?php echo htmlspecialchars($edit ? $store_details['store_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" required="required" id = "store_name" >
                </div>
                <div class="col-lg-6">
                    <label class="label_css" for="store_detail">Store Details*</label>
                    <input type="text" class="form-control-header " name="store_detail" value="<?php echo htmlspecialchars($edit ? $store_details['store_detail'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" required="required" id = "store_detail" >
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="label_css" for="email">Owner Name*</label>
                    <input type="text" name="owner_name" value="<?php echo htmlspecialchars($edit ? $store_details['owner_name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control-header " id="owner_name" required="required" >
                </div>
                <div class="col-lg-6">
                    <label class="label_css verticalTop" for="address">Customer Address*</label>
                    <textarea name="address" style="height: 70px;" placeholder="Address" class="form-control-header heightArea" required="required" id="address"><?php echo htmlspecialchars(($edit) ? $store_details['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="label_css" for="phone">Mobile*</label>
                    <input name="mobile" class="form-control-header " value="<?php echo htmlspecialchars($edit ? $store_details['mobile'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="9876543210"  type="number" id="mobile1" required="required">
                </div>
                <div class="col-lg-6">
                    <label class="label_css" for="phone2">Mobile 2*</label>
                    <input name="mobile2" class="form-control-header " value="<?php echo htmlspecialchars($edit ? $store_details['mobile2'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="9876543210"   type="number" id="mobile2" required="required" >
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="label_css" for="phone">Phone*</label>
                    <input name="phone" class="form-control-header " value="<?php echo htmlspecialchars($edit ? $store_details['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="(020)2323232" maxlength="12"  type="text" id="phone" required="required">
                </div>
                <div class="col-lg-6">
                    <label class="label_css" for="email">Email*</label>
                    <input  type="email" name="email" value="<?php echo htmlspecialchars($edit ? $store_details['email'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control-header " id="email" required="required" >
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <label class="label_css" for="phone">Store Language*</label>
                    <select name="languages_code" class="form-control-header " required="required" id="language">

                        <?php
                        $db = getDbInstance();
                        $languages = $db->get('languages');
                        foreach ($languages as $language) {
                            $sel = $edit && $language['languages_code'] == $store_details['languages_code']? "selected='selected'" :
                                ($language['languages_code'] == 'en'? "selected='selected'" : '');
                            echo '<option value="' . $language['languages_code'] . '" '. $sel.'>' . $language['languages_name'] . '</option>';
                        }
                        ?>
                    </select>
                    </div>
                <div class="col-lg-6"></div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <label><a class="btn-info btn"  href="index.php">Back to Main Page</a></label>
                    <button type="submit" class="btn btn-success" >Save <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </fieldset>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>