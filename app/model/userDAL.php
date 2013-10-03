<?php
	class UserDAL
	{
		private static function encryptPassword($password)
		{
			return md5($password);
		}

		public static function create(&$user) {
			DataAccessLayer::insertInto(
				'User',
				array($user->name, $user->email, self::encryptPassword($user->password)),
				array('name', 'email', 'password')
			);
		}

		public static function authenticate($email, $password)
		{
			$result = DataAccessLayer::query(
				"SELECT * FROM user WHERE email = ? AND password = ?",
				array($email, self::encryptPassword($password))
			);

			if(!empty($result)) {
				$result = $result[0];
				$user = new User($result->name, $result->email, $result->password);
				$user->id = $result->id;
				return $user;
			}
			else {
				return false;
			}
		}
	}
?>