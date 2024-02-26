<?php 
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{
	if ($_SESSION['admin_type'] != 'super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: index.php');
        exit;
	}

    $db = getDbInstance();
    $db->where('id', $del_id);
    $status = $db->delete('bank_list');
    
    if ($status) {
        $_SESSION['info'] = "Bank Options List deleted successfully!";
    } else {
    	$_SESSION['failure'] = "Unable to delete Bank Options List";
    }
    header('location: bank_options.php');
    exit;

}