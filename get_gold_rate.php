<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (!empty($_POST["bank_id"])) {

    $bank_id = htmlspecialchars($_POST["bank_id"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 1;
    $db->where('bank_id', $bank_id);
    $goldRate = $db->get('bank_list');
    echo (isset($goldRate) && $goldRate[0]['gold_rate']) ? $goldRate[0]['gold_rate'] : '';
}
?>