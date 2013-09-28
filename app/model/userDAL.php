<?php
	class UserDAL
	{
		private static function encryptPassword($password)
		{
			return md5($password . substr($password, 0, 2));
		}

		public static function create(&$this) {
			DataAccessLayer::insertInto(
				'User',
				array($this->name, $this->email, self::encryptPassword($this->password),
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
				$user = new User($result->name, $result->email, $result->password);
				$user->id = $result->id;
				return $user;
			}
			else {
				return false;
			}
		}
	}
?