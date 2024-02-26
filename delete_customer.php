<?php 
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $db = getDbInstance();
    $db->where('id', $del_id);
    $status = $db->delete('customers');
    
    if ($status) {
        $_SESSION['success'] = "Customer deleted successfully!";
    } else {
    	$_SESSION['failure'] = "Unable to delete customer!";
    }
    header('location: customers.php');
    exit;

}