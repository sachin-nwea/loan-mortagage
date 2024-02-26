<?php
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once 'fpdf/PDFLandscape.php';
require_once 'fpdf/PDFPortrait.php';

// Sanitize if you want
$mortgage_id = filter_input(INPUT_GET, 'mortgage_id', FILTER_VALIDATE_INT);
$printFormat = filter_input(INPUT_GET, 'formatType');

$db = getDbInstance();
if($_SESSION['admin_type'] != 'super')
    $db->where('created_by', $_SESSION['admin_user_id']);
$db->where('mortgage_id', $mortgage_id);
//Get data to pre-populate the form.
$mortgages = array();

if($_SESSION['admin_type'] != 'super')
    $db->where('customer_mortgages.created_by', $_SESSION['admin_user_id']);

$customers_mortgages = $db->get("customer_mortgages");
foreach($customers_mortgages as $customers_mortgage) {
    $db->where('mortgage_id', $customers_mortgage['mortgage_id']);
    $mortgages = $customers_mortgages[0];
    $mortgages_data = $db->get("mortgages");
    if (isset($mortgages_data)) {
        $mortgages['mortgages_data'] = $mortgages_data;
    }
}

$db->where('id', $mortgages['bank_id']);
//Get data to pre-populate the form.
$banks = $db->get("banks");
$banks_options = $db->get("bank_list");

$db->pagelimit =1;
if($_SESSION['admin_type'] != 'super')
    $db->where('store_details.created_by', $_SESSION['admin_user_id']);
$storeDetails = $db->get("store_details");

$db->pagelimit = 1;
$db->where('id', $customers_mortgages[0]['customer_id']);
$customer = $db->get('customers');

if(count($mortgages) > 0) {
    if ($printFormat == 'L') {
        // Instantiate a PDF object
        $pdf = new PDFLandscape();
        $pdf->SetTitle('Print Mortgage');
        $pdf->SetFont('times', '', 10);
        $loop = ceil(count($mortgages['mortgages_data']) / 5);
        $pdf->printLandscapeData($banks[0], $customer[0], $storeDetails[0], $banks_options[0], $mortgages['mortgages_data'], $customers_mortgages[0]);
    } else {
        $pdf = new PDFPortrait();
        $pdf->SetTitle('Print Mortgage');
        $pdf->SetFont('times', '', 10);
        $pdf->printPortraitData($banks[0], $customer[0], $storeDetails[0], $banks_options[0], $mortgages['mortgages_data'], $customers_mortgages[0]);
    }
    $pdf->outPrint();
} else {
    $_SESSION['failure'] = "Dont have Access for this mortgages!";
    header('location: mortgages.php');
    exit();
}
?>
