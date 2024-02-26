<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$caratOptions = "<option value=''>Carat Value</option>";
if (!empty($_POST["bank_id"])) {

    $bank_id = htmlspecialchars($_POST["bank_id"]);
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 6;
    $db->where('bank_id', $bank_id);
    $caratLists = $db->get('bank_list');
    foreach ($caratLists as $caratList) {
        $carats = explode('-', $caratList['carats_options']);
        foreach($carats as $carat) {
            if($carat != '') {
                $sel = ($carat == 22 )? "selected='selected'" : '';
                $caratOptions .= '<option value="' . $carat . '" '. $sel. '>' . $carat . '</option>';
            }
        }
    }
}
echo $caratOptions;
?>
