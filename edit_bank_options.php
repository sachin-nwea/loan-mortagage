<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Sanitize if you want
$carat_id = filter_input(INPUT_GET, 'carat_id', FILTER_VALIDATE_INT);
$edit = true;
$db = getDbInstance();
//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_update = array_filter($_POST);
    $caratValue = '';
    if($data_to_update['24_carat']){
        $caratValue .= $data_to_update['24_carat'].'-';
    }
    if($data_to_update['23_carat']){
        $caratValue .= $data_to_update['23_carat'].'-';
    }
    if($data_to_update['22_carat']){
        $caratValue .= $data_to_update['22_carat'].'-';
    }
    if($data_to_update['21_carat']){
        $caratValue .= $data_to_update['21_carat'].'-';
    }
    if($data_to_update['20_carat']){
        $caratValue .= $data_to_update['20_carat'].'-';
    }
    if($data_to_update['19_carat']){
        $caratValue .= $data_to_update['19_carat'].'-';
    }
    if($data_to_update['18_carat']){
        $caratValue .= $data_to_update['18_carat'];
    }

    $loanValue = '';
    if($data_to_update['12_months']){
        $loanValue .= $data_to_update['12_months'].'-';
    }
    if($data_to_update['9_months']){
        $loanValue .= $data_to_update['9_months'].'-';
    }
    if($data_to_update['6_months']){
        $loanValue .= $data_to_update['6_months'].'-';
    }
    if($data_to_update['3_months']){
        $loanValue .= $data_to_update['3_months'].'-';
    }
    if($data_to_update['3_years']){
        $loanValue .= $data_to_update['3_years'];
    }

    $bank_options = array(
        'bank_id' => $data_to_update['bank_id'],
        'carats_options'=> $caratValue,
        'gold_rate' => $data_to_update['gold_rate'],
        'account_number' => $data_to_update['account_number'],
        'loan_options' => $loanValue,
        'created_at'   => date('Y-m-d H:i:s')
    );
    //Insert timestamp
    $db = getDbInstance();
    $db->where('id', $carat_id);
    try {
        $last_id = $db->update('bank_list', $bank_options);
    } catch (Exception $e) {
    }

    if ($last_id)
    {
    	$_SESSION['success'] = "Bank Options added successfully!";
    } else {
        try {
            $_SESSION['failure'] = "Bank Options not Added! " . $db->getLastError();
        } catch (Exception $e) {

        }
    }
    header('location: bank_options.php');
    exit();
}
$bank_options = array();
//We are using same form for adding and editing. This is a create form so declare $edit = false.
if($edit)
{
    $db->where('id', $carat_id);
    //Get data to pre-populate the form.
    try {
        $bank_options = $db->getOne("bank_list");
    } catch (Exception $e) {
    }
}
$title = 'Update Bank Options';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Update Bank Options</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="bank_options_form" enctype="multipart/form-data">
       <?php  include_once('./forms/bank_options_form.php'); ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>