<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);
    $caratValue = '';
    if($data_to_store['24_carat']){
        $caratValue .= $data_to_store['24_carat'].'-';
    }
    if($data_to_store['23_carat']){
        $caratValue .= $data_to_store['23_carat'].'-';
    }
    if($data_to_store['22_carat']){
        $caratValue .= $data_to_store['22_carat'].'-';
    }
    if($data_to_store['21_carat']){
        $caratValue .= $data_to_store['21_carat'].'-';
    }
    if($data_to_store['20_carat']){
        $caratValue .= $data_to_store['20_carat'].'-';
    }
    if($data_to_store['19_carat']){
        $caratValue .= $data_to_store['19_carat'].'-';
    }
    if($data_to_store['18_carat']){
        $caratValue .= $data_to_store['18_carat'];
    }

    $loanValue = '';
    if($data_to_store['12_months']){
        $loanValue .= $data_to_store['12_months'].'-';
    }
    if($data_to_store['9_months']){
        $loanValue .= $data_to_store['9_months'].'-';
    }
    if($data_to_store['6_months']){
        $loanValue .= $data_to_store['6_months'].'-';
    }
    if($data_to_store['3_months']){
        $loanValue .= $data_to_store['3_months'].'-';
    }
    if($data_to_store['3_years']){
        $loanValue .= $data_to_store['3_years'].'-';
    }
    //Insert timestamp
    $db = getDbInstance();

    $db->where('bank_id', $data_to_store['bank_id']);
    $carats = $db->getOne("bank_list");
    if(empty($carats)) {
        $db = getDbInstance();
        $bank_options = array(
            'bank_id' => $data_to_store['bank_id'],
            'carats_options'=> $caratValue,
            'gold_rate' => $data_to_store['gold_rate'],
            'account_number' => $data_to_store['account_number'],
            'loan_options' => $loanValue,
            'created_at'   => date('Y-m-d H:i:s'),
            'created_by'   => $_SESSION['admin_user_id']
        );
        $last_id = $db->insert('bank_list', $bank_options);
    }

    if ($last_id)
    {
    	$_SESSION['success'] = "Bank Options added successfully!";
    	header('location: bank_options.php');
    	exit();
    } else {
        $_SESSION['failure'] = "Bank Options not Added!";
        header('location: bank_options.php');
        exit();
    }
}

//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;
$bank_options = array();
$title = 'Add Bank Option';
require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add New Bank Options</h2>
        </div>
        
</div>
    <form class="form well" action="" method="post"  id="bank_options_form" enctype="multipart/form-data">
       <?php  include_once('./forms/bank_options_form.php'); ?>
    </form>
</div>
<?php include_once 'includes/footer.php'; ?>