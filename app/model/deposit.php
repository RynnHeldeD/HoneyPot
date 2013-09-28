<?php
	class Deposit
	{
		protected $id = 0;
		protected $accountId = 0;
		protected $amount = 0;
		protected $date = '0000-00-00';

		
		public function Deposit($accountId, $amount, $date) {
			$this->accountId = $accountId;
			$this->amount = $amount;
			$this->date = $date;
		}

		public function save() {
			DepositDAL::create($this);
		}

		public function delete() {
			DepositDAL::delete($this);
		}
		
		public function __get($property) {
			switch($property) {
				case 'id':
					return $this->id;
					break;
				case 'accountId':
					return $this->accountId;
					break;
				case 'date':
					return $this->date;
					break;
				case 'amount':
					return $this->amount;
					break;
				default:
					return false;
					break;
			}
		}

		public function __set($property, $value) {
			switch($property) {
				case 'id':
					if(is_integer($value) && $value >= 0) {
						$this->id = $value;
					}
					break;
				case 'id':
					if(is_integer($value) && $value >= 0) {
						$this->accountId = $value;
					}
					break;
				case 'date':
					$date = explode('-', $value);
					if(checkdate($date[1], $date[2], $date[0])) {
						$this->date = $value;	
					}
					break;
				case 'amount':
					if(is_double($value) && $value >= 0) {
						$this->amount = $value;
					}
					break;
				default:
					return false;
					break;
			}
		}
	}
?>