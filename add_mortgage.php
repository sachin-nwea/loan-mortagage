<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);
    $customer_mortgages_data = array('customer_id' => $data_to_store['customer_id'],
        'interest_payment_type' => $data_to_store['interest_payment_type'],
        'state_id' => $data_to_store['state_id'],
        'city' => $data_to_store['city'],
        'bank_id' => $data_to_store['bank_id'],
        'branch_name' => $data_to_store['branch_name'],
        'total_amount' => $data_to_store['total_amount'],
        'total_weight' => $data_to_store['total_weight'],
        'total_net_weight' => $data_to_store['total_net_weight'],
        'total_no_of_units'=> $data_to_store['total_no_of_units'],
        'total_equivalent_weight' => $data_to_store['total_equivalent_weight'],
        'acid_test' => $data_to_store['acid_test'],
        'touch_sound_test' => $data_to_store['touch_sound_test'],
        'sound_test' => $data_to_store['sound_test'],
        'loan_requested' => $data_to_store['loan_requested'],
        'loan_approved' => $data_to_store['loan_approved'],
        'bag_pouch' => $data_to_store['bag_pouch'],
        'number' => $data_to_store['number'],
        //Insert timestamp
        'created_at'   => date('Y-m-d H:i:s'),
        'created_by'   => $_SESSION['admin_user_id']
    );

    $mortgages = array_diff($data_to_store, $customer_mortgages_data);
    $mortgages_data = array();
    $countArray = isset($mortgages['ornament_name'])? count($mortgages['ornament_name']) : 0;

    $db = getDbInstance();
    $db->pageLimit = 1;
    $mortgage = $db->get("mortgage_current_value");
    $new_mortgage_id = (int) $mortgage[0]['latest_mortgage_id'] + 1;
    $last_id = array();
    for($i=0; $i < $countArray; $i++) {

        if ($mortgages['ornament_name'][$i] != null
            && $mortgages['no_of_units'][$i] != null
            && $mortgages['weight'][$i] != null
            && $mortgages['net_weight'][$i] != null
            && $mortgages['carat_purity'][$i] != null
            && $mortgages['equivalent_weight'][$i] != null
            && $mortgages['rate_per_gram'][$i] != null
            && $mortgages['final_value'][$i] != null
        ) {
            $store_mortgage_data = array('mortgage_id' => $new_mortgage_id,
                'ornament_name' => $mortgages['ornament_name'][$i],
                'hallmark' => $mortgages['hallmark'][$i],
                'no_of_units' => $mortgages['no_of_units'][$i],
                'weight' => $mortgages['weight'][$i],
                'net_weight' => $mortgages['net_weight'][$i],
                'carat_purity' => $mortgages['carat_purity'][$i],
                'equivalent_weight' => $mortgages['equivalent_weight'][$i],
                'rate_per_gram' => $mortgages['rate_per_gram'][$i],
                'final_value' => $mortgages['final_value'][$i]);

            $last_id[] = $db->insert('mortgages', $store_mortgage_data);
        }
    }
    if (count($last_id) > 0) {
        $customer_mortgages_data['mortgage_id'] = $new_mortgage_id;
        $customer_mortgages_id = $db->insert('customer_mortgages', $customer_mortgages_data);
        $db->update("mortgage_current_value", array('latest_mortgage_id' => $new_mortgage_id));
        $_SESSION['success'] = "Mortgage added successfully!";
        header('location: mortgages.php');
        exit();
    } else {
        $db->where('mortgage_id', $new_mortgage_id);
        $db->delete('mortgages');
        $_SESSION['failure'] = 'insert failed: please add proper data: ' . $db->getLastError();
        header('location: mortgages.php');
        exit();
    }

}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
$mortgages_data = array(array('mortgages_id' => '',
  'ornament_name'  => '',
  'no_of_units'  => '',
  'weight'  => '',
  'net_weight'  => '',
  'purity'  => '',
  'carat_purity'  => '',
  'equivalent_weight_22' => '',
  'rate_per_gram'  => '',
  'final_value'=> ''));
$mortgages = array();
for($i=0; $i<6; $i++) {
    foreach ($mortgages_data as $mortgage) {
        $mortgages['mortgages_data'][$i] = $mortgage;
    }
}
$title = 'Add Mortgage';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
    <div class="row">
        <h2>Add Mortgage</h2>
    </div>
    <form class="form well" action="" method="post"  id="mortgage_form" enctype="multipart/form-data" onchange="return validateData();">
       <?php  include_once('./forms/mortgages_form.php'); ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>