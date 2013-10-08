<?php
	session_start();
	require("app/splAutoload.php");
var_dump($_SESSION);
	$user = null;
	if(isset($_SESSION['user'])) {
		$user = unserialize($_SESSION['user']);
	}

	if(empty($user)) {
		UserController::loginAction();
	}
	else {
		$controller = "frontController";
		$action = "defaultAction";

		if(isset($_GET['p'])) {
			$controller = $_GET['p'] . 'Controller';
			if($_GET['p'] == 'logout'){session_destroy();}
		}
		
		if(isset($_GET['a'])) {
			$action = $_GET['a'] . 'Action';	
		}

		if(file_exists('app/controllers/' . $controller . '.php')) {
			$controller::$action();
		}
	}
?>