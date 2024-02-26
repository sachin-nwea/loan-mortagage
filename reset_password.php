<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $admin_id = filter_input(INPUT_POST, 'admin_id', FILTER_VALIDATE_INT);

	$data_to_store = filter_input_array(INPUT_POST);
    $db = getDbInstance();
    //Check whether the user name already exists ; 
    $db->where('id',$admin_id);
    $admin = $db->get('admin_accounts');

    if($db->count = 1) {
        //reset db instance
        $db = getDbInstance();
        $db->where('id', $admin_id);
        $last_id = $db->update('admin_accounts', array('password' => password_hash($data_to_store['new_password'], PASSWORD_DEFAULT)));
        if ($last_id) {
            $_SESSION['success'] = "Password Changed successfully!";
        } else {
            $_SESSION['failure'] = "Password not changed!";
        }
    } else {
        $_SESSION['failure'] = "Password not changed! User have multiple profiles";
    }
    header('location: admin_users.php');
    exit();
}
$db = getDbInstance();
//Check whether the user name already exists ;
$db->where('id',$_GET['admin_user_id']);
$admin = $db->getOne('admin_accounts');
$title = 'Reset Password';
require_once 'includes/header.php';
?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header">Reset Password</h2>
		</div>
	</div>
	 <?php 
    include_once('includes/flash_messages.php');
    ?>
	<form class="well form-horizontal" action=" " method="post"  id="reset_form" enctype="multipart/form-data" onSubmit="return validatePassword()">
        <!-- Text input-->
        <div class="row">
            <div class="col-lg-4">
                <label class="label_css">UserName*</label>
            </div>
            <div class="col-lg-8">
                <input  type="readonly" disabled="disabled" class="form-control-header  margin-bottom" value="<?= $admin['user_name'] ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label class="label_css">New Password*</label>
            </div>
            <div class="col-lg-8">
                <input  type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control-header  margin-bottom" value="" required="required">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label class="label_css">Confirm Password*</label>
            </div>
            <div class="col-lg-8">
                <input  type="password" name="confirm_password" id="confirm_password" autocomplete="off" placeholder="Confirm Password" class="form-control-header  margin-bottom" value="" required="required">
                <span class="error-span" id="error"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-8">
                <input type="hidden" name="admin_id" value="<?= $_GET['admin_user_id'] ?>">
                <label class="label_css" for="Back"><a class="btn-info btn"  href="admin_users.phpy/admin_users.php"><span class="glyphicon glyphicon-backward"> </span><?= __('Back to Listing') ?></a></label>
                <button type="submit" class="btn btn-success">Save <span class="glyphicon glyphicon-send"></span></button>
            </div>
        </div>
	</form>
</div>
<script type="text/javascript">
    function validatePassword() {
        var newPassword = $("#new_password").val();
        var confirmPassword = $("#confirm_password").val();

        if (newPassword != confirmPassword) {
            $('#error').html('Password are not same');
            return false;
        }
    }
</script>



<?php include_once 'includes/footer.php'; ?>