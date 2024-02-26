<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $to = "priyakothari077@gmail.com";
    $subject = "This is subject";

    $message = "<b>This is HTML message.</b>";
    $message .= "<h1>This is headline.</h1>";

    $header = "From:sachinjain.it@gmail.com \r\n";
    //$header .= "Cc:afgh@somedomain.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $response = mail($to, $subject, $message, $header);

    if ($response) {
        $_SESSION['success'] =  "Message sent successfully...";
    } else {
        $_SESSION['failure'] =  "Message could not be sent...";
    }
}
$title = 'Send Emails';
require_once 'includes/header.php';

?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-6">
			<h2 class="page-header">Send Email to Bank and Customers</h2>
		</div>
	</div>
    <?php
    include('./includes/flash_messages.php')
    ?>
	<form class="well form-horizontal" action="" method="post"  id="send_email" enctype="multipart/form-data">
        <fieldset>
            <div class="row">
                <div class="col-lg-3">
                    <label class="label_css" for="branch_name">Select Mortgage</label>
                </div>
                <div class="col-lg-6">
                    <select name="branch_name" class="form-control-header " required="required" id="branch_name" onchange="fetchMortgageList(this.value);">
                    <?php
                    $db = getDbInstance();
                    //Get data to pre-populate the form.
                    if($_SESSION['admin_type'] != 'super')
                        $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);
                    $customers_mortgages = $db->get("customer_mortgages");
                    $options = "<option value=''>Select Mortgage </option>";
                    foreach($customers_mortgages as $customers_mortgage) {
                        $db->where('id',  $customers_mortgage['customer_id']);
                        $db->orderBy('id', 'desc');
                        $customers = $db->get('customers');
                        $options .= '<option value="'.$customers_mortgage['branch_name'].'">' . $customers[0]['f_name']. ' '. $customers[0]['l_name'].' '. $customers_mortgage['branch_name'] . '</option>';
                    }
                    echo $options;
                    ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="label_css" for="email">Details of Bank Emails*</label>
                </div>
                <div class="col-lg-7">
                    <span id="details"></span>
                </div>
            </div>
             <div class="row">
                <div class="col-lg-12"></div>
                    <label><a class="btn-info btn"  href="index.php">Back to Main Page</a></label>
                    <button type="submit" class="btn btn-success" >Send Emails <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
        </fieldset>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>