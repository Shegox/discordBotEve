<?php
session_set_cookie_params($_GLOBALS["SESSION_TIMEOUT"]);
ini_set('session.gc_maxlifetime',$_GLOBALS["SESSION_TIMEOUT"]);
session_start();

if (array_key_exists("auth",$_SESSION))
{
echo json_encode($_SESSION["auth"]);
}
else
{
	http_response_code(200);
}
//include_once "isAuth.php";
//echo json_encode(isAuth($_GET["auth_code"]));