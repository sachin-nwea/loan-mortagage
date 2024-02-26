<?php 
session_start();
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $mortgage_id = $del_id;
    $db = getDbInstance();
    $db->where('mortgage_id', $mortgage_id);
    $status = $db->delete('mortgages');
    $db->where('mortgage_id', $mortgage_id);
    $status = $db->delete('customer_mortgages');
    if ($status) 
    {
        $_SESSION['info'] = "Mortgage deleted successfully!";
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete Mortgage";

    }
    header('location: mortgages.php');
    exit;

}