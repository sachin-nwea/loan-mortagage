<?php
$db = getDbInstance();
if($_SESSION['admin_type'] != 'super') {
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
        $db->where('id', 0);
    }
}
$banks = $db->get('banks');