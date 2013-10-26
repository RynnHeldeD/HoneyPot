<?php
	class User
	{	
		protected $id = 0;
		protected $login = "undefined";
		protected $email = "undefined";
		protected $password = "undefined";

		public function User($login, $email, $password)
		{
			$this->login = $login;
			$this->email = $email;
			$this->password = $password;
		}

		public function create() {
			UserDAL::create($this);
		}

		public function __get($property) {
			switch ($property) {
				case 'id':
					return $this->id;
					break;
				case 'login':
					return $this->login;
					break;
				case 'password':
					return $this->password;
					break;
				case 'email':
					return $this->email;
					break;
				default:
					return false;
					break;
			}
		}
		
		public function __set($property, $value) {
			switch($property) {
				case 'id':
					$value = intval($value);
					if(is_integer($value) && $value >= 0) {
						$this->id = $value;
					}
					break;
				case 'login':
					if(is_string($value) && !empty($value)) {
						$this->login = $value;
					}
					break;
				case 'email':
					if(is_string($value) && !empty($value)) {
						$this->email = $value;
					}
					break;
				case 'password':
					if(is_string($value) && !empty($value)) {
						$this->password = $value;
					}
					break;
				default:
					return false;
					break;
			}
		}
	}
?>