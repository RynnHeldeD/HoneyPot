<?php
	class UserController
	{
		public static function defaultAction() {
		}

		private static function showLoginFormAction() {
			include_once('app/views/login.html');
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
		

		//registration draft
		/*if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])) {
				$user = new User($_POST['login'], $_POST['email'], $_POST['password']);
				// UserDAL::create($user);
				
				$user2 = UserDAL::authenticate($_POST['email'], $_POST['password']);
				if(!empty($user2) && $user2 instanceOf User) {
					echo "Connecté en tant que : " . $user2->name;
				}
			}
		}	*/
	}
?>