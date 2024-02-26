<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (!empty($_POST["bank_id"])) {

    $bank_id = htmlspecialchars($_POST["bank_id"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 100;

    if($_SESSION['admin_type'] != 'super') {
        $db->where('created_by', $_SESSION['admin_user_id']);
    }
    $db->where('bank_id', $bank_id);


    $db->orderBy('branch_name', 'asc');
    $banks = $db->get('branches');
    echo "<option value=''>Select Branch</option>";
    foreach ($banks as $bank) {
        echo '<option value="' . $bank['branch_name'] . '">' . $bank['branch_name'] . '</option>';
    }
}
?>