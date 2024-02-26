<?php
require_once './config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
session_destroy();


if(isset($_COOKIE['series_id']) && isset($_COOKIE['remember_token'])){
	clearAuthCookie();
}
header('Location:login.php');
exit;
?>