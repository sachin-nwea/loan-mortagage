<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$select = array('bank_list.id', 'banks.bank_name', 'carats_options', 'loan_options', 'gold_rate', 'account_number', 'bank_list.created_at', 'bank_list.created_by', 'bank_list.updated_at');
$selectHeader = array('Id', 'Bank Name', 'Carat Options', 'Loan Options', 'Gold Rate', 'Account Number', 'Created On', 'Created By' , 'Updated On');

$chunk_size = 1000;
$offset = 0;

$db = getDbInstance();
if($_SESSION['admin_type'] != 'super')
    $db->where('branches.created_by', $_SESSION['admin_user_id']);

$data = $db->get('bank_list');
$total_count = $db->totalCount;

$handle = fopen('php://memory', 'w');

fputcsv($handle,$selectHeader);
$filename = 'export_bank_options.csv';

$num_queries = ($total_count/$chunk_size) + 1;

//Prevent memory leak for large number of rows by using limit and offset :
for ($i=0; $i<$num_queries; $i++){

    $db->join('banks', 'banks.id = bank_list.bank_id', 'LEFT');
    $rows = $db->get('bank_list',Array($offset,$chunk_size), $select);
    $offset = $offset + $chunk_size;
    foreach ($rows as $row) {

        fputcsv($handle,array_values($row));
    }
}

// reset the file pointer to the start of the file
fseek($handle, 0);
// tell the browser it's going to be a csv file
header('Content-Type: application/csv');
// Save instead of displaying csv string
header('Content-Disposition: attachment; filename="'.$filename.'";');
//Send the generated csv lines directly to browser
fpassthru($handle);

