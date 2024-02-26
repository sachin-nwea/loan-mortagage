<?php 
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST')
{
	if ($_SESSION['admin_type']!='super') {
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: index.php');
        exit;
	}
    $bank_id = $del_id;

    $db = getDbInstance();
    $db->where('id', $bank_id);
    $status = $db->delete('banks');
    
    if ($status) {
        $_SESSION['success'] = "Bank deleted successfully!";
    } else {
    	$_SESSION['failure'] = "Unable to delete Bank";

    }
    header('location: banks.php');
    exit;
}