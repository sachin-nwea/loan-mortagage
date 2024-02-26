<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$interestListsOptions = "<option value=''>Select Interest Month</option>";
if (!empty($_POST["bank_id"])) {

    $bank_id = htmlspecialchars($_POST["bank_id"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 10;
    $db->where('bank_id', $bank_id);
    $interestLists = $db->get('bank_list');
    foreach ( $interestLists as $interestList) {
        $options = explode('-', $interestList['loan_options']);
        foreach($options as $option) {
            if($option != '') {
                $sel = ($option == '12 months' )? "selected='selected'" : '';
                $interestListsOptions .= '<option value="' . $option . '" '. $sel. '>' . $option . '</option>';
            }
        }
    }
}
echo $interestListsOptions;
?>
