<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if (! empty($_POST["state_id"])) {

    $stateId = $_POST["state_id"];
    $db = getDbInstance();
    // Set pagination limit
    $db->pageLimit = 100;
    $db->where('state_id',  $stateId);
    $db->where('status', 'Active');
    $db->orderBy('name', 'asc');
    $cityResult = $db->get('city');
    ?>
    <option value=''>Select City</option>
    <?php
    foreach ($cityResult as $city) {
        ?>
        <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
        <?php
    }
}
?>