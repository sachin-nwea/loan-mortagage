<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (!empty($_POST["branch_name"])) {

    $branch_name = htmlspecialchars($_POST["branch_name"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 4;

    if($_SESSION['admin_type'] != 'super')
        $db->where('branches.created_by', $_SESSION['admin_user_id']);

    $db->where('branch_name',  $branch_name);
    $db->orderBy('id', 'desc');
    $branches = $db->get('branches');

    $text = 'Officer Email : <input class="form-control-header margin-bottom" type="text" value="'.$branches[0]['officer_email'].'" name="officer_email"  readonly/><br />';
    if(!empty($branches[0]['officer_email2'])) {
        $text .= 'Officer_email2 : <input class="form-control-header margin-bottom" type="text" value="' . $branches[0]['officer_email2'] . '" name="officer_email2" readonly /><br />';
    }
    if(!empty($branches[0]['email'])) {
        $text .= 'Bank Email:  <input class="form-control-header margin-bottom" type="text" value="' . $branches[0]['email'] . '" name="email" readonly />';
    }
    echo $text;
}
?>