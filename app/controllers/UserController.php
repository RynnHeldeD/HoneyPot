<?php
	class UserController
	{
		public static function defaultAction() {
		}

		private static function showLoginFormAction() {
			include_once('app/views/login.view.php');
		}

		public static function loginAction() {
			if(isset($_POST['login']) && isset($_POST['password'])) {
				$user = UserDAL::authenticate($_POST['login'], $_POST['password']);

				if(!empty($user) && $user instanceOf User) {
					$_SESSION['user'] = serialize($user);
					header('Location: index.php');
				}
				else {
					self::showLoginFormAction();	
				}
			}
			else {
				self::showLoginFormAction();
			}
		}
		
		private static function showRegisterFormAction() {
			include_once('app/views/registration.view.php');
		}
		
		public static function registerAction() {
			if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
				if(!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email'])) {
					$user = new User($_POST['login'], $_POST['email'], $_POST['password']);
					UserDAL::create($user);
					
					if(!empty($user) && $user instanceOf User) {
						$_SESSION['user'] = serialize($user);
						header('Location: index.php');
					}
				}
			}
			else {
				self::showRegisterFormAction();
			}
		}
	}
?>