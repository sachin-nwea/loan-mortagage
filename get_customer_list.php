<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (!empty($_POST["city"])) {

    $city = htmlspecialchars($_POST["city"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 100;
    if($_SESSION['admin_type'] != 'super') {
        $db->where('created_by', $_SESSION['admin_user_id']);
    }
    $db->where('city',  $city);

    $db->orderBy('id', 'desc');
    $customers = $db->get('customers');
    echo  "<option value=''>Select Customer</option>";
    foreach ($customers as $customer) {
        echo '<option value="'.$customer['id'].'">'.$customer['f_name']. ' '. $customer['l_name'].'</option>';
    }
}
?>