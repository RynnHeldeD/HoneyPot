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

		if(isset($_GET['p']) || isset($_POST['p'])) {
			if(isset($_GET['p']) && $_GET['p'] == 'logout') {
				session_destroy();
				header('Location: index.php');
			}
			else {
                if(isset($_GET['p']) && !empty($_GET['p'])) {
                    $controller = $_GET['p'] . 'Controller';
                }
                elseif(isset($_POST['p']) && !empty($_POST['p'])) {
                    $controller = $_POST['p'] . 'Controller';
                }
                
				if(isset($_GET['a']) && !empty($_GET['a'])) {
					$action = $_GET['a'] . 'Action';	
				}
                elseif(isset($_POST['a']) && !empty($_POST['a'])) {
                    $action = $_POST['a'] . 'Action';	
                }
			}
		}

		if(file_exists('app/controllers/' . $controller . '.php')) {
			$controller::$action();
		}
	}
?>