<?php
	class User
	{	
		protected $name = "undefined";
		protected $email = "undefined";
		protected $password = "undefined";

		public function User($name, $email, $password)
		{
			$this->name = $name;
			$this->email = $email;
			$this->password = $password;
		}

		public function save() {
			UserDAL::create($this);
		}

		public function __get($property) {
			switch ($property) {
				case 'id':
					return $this->id;
					break;
				case 'name':
					return $this->name;
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
				case 'name':
					if(is_string($value) && !empty($value)) {
						$this->name = $value;
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