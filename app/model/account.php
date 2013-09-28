<?php
	class Account
	{
		protected $id = 0;
		protected $label = 'New account';
		protected $amount = 0;
		protected $deposits = null;

		public function Account($label, $amount, $deposits = array()) {
			$this->label = $label;
			$this->amount = $amount;
			$this->deposits = $deposits;
		}
		
		public function save() {
			AccountDAL::createAccount($this);
		}
		
		public function __get($property) {
			switch ($property) {
				case 'id':
					return $this->id;
					break;
				case 'label':
					return $this->label;
					break;
				case 'amount':
					return $this->amount;
					break;
				case 'deposits':
					return $this->deposits;
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
				case 'label':
					if(is_string($value) && !empty($value)) {
						$this->label = $value;	
					}
					break;
				case 'amount':
					if(is_double($value) && $value >= 0) {
						$this->amount = $value;
					}
					break;
				case 'deposits':
					if(is_array($value) && !empty($value)) {
						$this->deposits = $value;
					}
					break;
				default:
					return false;
					break;
			}
		}
	}
?>