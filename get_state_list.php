<?php
$db = getDbInstance();
// Set pagination limit
$db->pageLimit = 40;
$db->where('status',  'Active');
if($_SESSION['admin_type'] != 'super') {
    $dba = getDbInstance();
    $dba->where('id', $_SESSION['admin_user_id']);
    $admin_accounts = $dba->getOne("admin_accounts");
    if (isset($admin_accounts['state_allowed']) && $admin_accounts['state_allowed'] != '') {
        /* if all option come then all banks should be allowed' */
        if($admin_accounts['state_allowed'] != 'all') {
            $stateOptions = explode(",", $admin_accounts['state_allowed']);
            foreach ($stateOptions as $stateOption) {
                $db->orWhere('state_id', $stateOption);
            }
        }
    } else {
        $db->where('state_id', 0);
    }
}
$rows = $db->get('state');

