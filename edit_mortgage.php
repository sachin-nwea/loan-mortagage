<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$mortgage_id = filter_input(INPUT_GET, 'mortgage_id', FILTER_VALIDATE_INT);
$edit = true;
$db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);
    $customer_mortgages_data = array('customer_id' => $data_to_update['customer_id'],
        'interest_payment_type' => $data_to_update['interest_payment_type'],
        'state_id' => $data_to_update['state_id'],
        'city' => $data_to_update['city'],
        'bank_id' => $data_to_update['bank_id'],
        'branch_name' => $data_to_update['branch_name'],
        'total_amount' => $data_to_update['total_amount'],
        'total_weight' => $data_to_update['total_weight'],
        'total_net_weight' => $data_to_update['total_net_weight'],
        'total_no_of_units'=> $data_to_update['total_no_of_units'],
        'total_equivalent_weight' => $data_to_update['total_equivalent_weight'],
        'acid_test' => $data_to_update['acid_test'],
        'touch_sound_test' => $data_to_update['touch_sound_test'],
        'sound_test' => $data_to_update['sound_test'],
        'loan_requested' => $data_to_update['loan_requested'],
        'loan_approved' => $data_to_update['loan_approved'],
        'bag_pouch' => $data_to_update['bag_pouch'],
        'number' => $data_to_update['number'],
        'updated_at'   => date('Y-m-d H:i:s')
    );

    //Insert timestamp
    $mortgages = array_diff($data_to_update, $customer_mortgages_data);
    $mortgages_data = array();
    $countArray = isset($data_to_update['ornament_name'])? count($data_to_update['ornament_name']) : 0;

    $db = getDbInstance();
    $mortgage_id = $data_to_update['mortgage_main_id'];
    $db->where('mortgage_id', $mortgage_id);
    $status = $db->delete('mortgages');
    $statusNew = false;
    for ($i=0; $i < $countArray; $i++) {

        if ($mortgages['ornament_name'][$i] != null
            && $mortgages['no_of_units'][$i] != null
            && $mortgages['weight'][$i] != null
            && $mortgages['net_weight'][$i] != null
            && $mortgages['carat_purity'][$i] != null
            && $mortgages['equivalent_weight'][$i] != null
            && $mortgages['rate_per_gram'][$i] != null
            && $mortgages['final_value'][$i] != null
        ) {
            $store_mortgage_data = array('mortgage_id' => $mortgage_id,
                'ornament_name' => $mortgages['ornament_name'][$i],
                'hallmark' => $mortgages['hallmark'][$i],
                'no_of_units' => $mortgages['no_of_units'][$i],
                'weight' => $mortgages['weight'][$i],
                'net_weight' => $mortgages['net_weight'][$i],
                'carat_purity' => $mortgages['carat_purity'][$i],
                'equivalent_weight' => $mortgages['equivalent_weight'][$i],
                'rate_per_gram' => $mortgages['rate_per_gram'][$i],
                'final_value' => $mortgages['final_value'][$i]);

                $status = $db->insert('mortgages', $store_mortgage_data);
                $statusNew = (bool)$status;
            }
        }
    if($statusNew)
    {
        $db->where('mortgage_id',$mortgage_id);
        $customer_mortgages_id = $db->update('customer_mortgages', $customer_mortgages_data);
        $_SESSION['success'] = "Mortgage updated successfully!";
        //Redirect to the listing page,
        header('location: mortgages.php');
        exit();
    } else {
        $_SESSION['failure'] = "Mortgage not updated! ".$db->getLastError();
        //Redirect to the listing page,
        header('location: mortgages.php');
        exit();
    }
}
$mortgages=array();
//If edit variable is set, we are performing the update operation.
if($edit)
{
    if($_SESSION['admin_type'] != 'super')
        $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);
    $db->where('mortgage_id', $mortgage_id);
    //Get data to pre-populate the form.
    $customers_mortgages = $db->get("customer_mortgages");
    foreach($customers_mortgages as $customers_mortgage) {
        $db->where('mortgage_id', $customers_mortgage['mortgage_id']);
        $mortgages = $customers_mortgage;
        if($_SESSION['admin_type'] != 'super')
            $db->where('mortgages.created_by', $_SESSION['admin_user_id']);
        $mortgages_data = $db->get("mortgages");
        if (isset($mortgages_data)) {
            $mortgages['mortgages_data'] = $mortgages_data;
        }
    }
}
$title = 'Update Mortgage';
include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2>Update Mortgage</h2>
    </div>
    <!-- Flash messages -->
    <?php
    include('./includes/flash_messages.php')
    ?>

    <form class="well" action="" method="post" enctype="multipart/form-data" id="edit_mortgage_form">
        <?php
            //Include the common form for add and edit  
            require_once('./forms/mortgages_form.php');
        ?>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>

