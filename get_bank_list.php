<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (!empty($_POST["city"])) {

    $city = htmlspecialchars($_POST["city"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 100;
    //for showing only records created by user.
    if($_SESSION['admin_type'] != 'super') {
        $db->where('branches.created_by', $_SESSION['admin_user_id']);

        $dba = getDbInstance();
        $dba->where('id', $_SESSION['admin_user_id']);
        $admin_accounts = $dba->getOne("admin_accounts");
        if (isset($admin_accounts['banks_allowed']) && $admin_accounts['banks_allowed'] != '') {
            /* if all option come then all banks should be allowed' */
            if($admin_accounts['banks_allowed'] != 'all') {
                $banksOptions = explode(",", $admin_accounts['banks_allowed']);
                foreach ($banksOptions as $banksOption) {
                    $db->orWhere('banks.id', $banksOption);
                }
            }
        } else {
            $db->where('banks.id', 0);
        }
    }
    $db->where('branches.city', $city);
    $db->orderBy('city', 'asc');
    $db->join('branches', 'banks.id = branches.bank_id', 'LEFT');
    $select = array('banks.id', 'banks.bank_name');
    $banks = $db->get('banks', 100, $select);
    $banksOptions = array();
    $banksList = "<option value=''>Select Bank</option>";
    foreach ($banks as $bank) {
        if (!in_array($bank['id'], $banksOptions))
            $banksOptions[$bank['id']] = $bank['bank_name'];
    }
    //Creating the bank List.
    foreach ($banksOptions as $key => $value) {
        $banksList  .= '<option value="' . $key . '">' . $value . '</option>';
    }
    echo $banksList;
}
?>