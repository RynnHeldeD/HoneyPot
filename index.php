<?php
	session_start();
	require("app/splAutoload.php");
	global $user;

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
			if($_GET['p'] == 'logout') {
				session_destroy();
				header('Location: index.php');
			}
			else {
				$controller = $_GET['p'] . 'Controller';
				if(isset($_GET['a'])) {
					$action = $_GET['a'] . 'Action';	
				}
			}
		}

		if(file_exists('app/controllers/' . $controller . '.php')) {
			$controller::$action();
		}
	}
?>