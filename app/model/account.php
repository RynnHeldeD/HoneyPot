<?php
	class Account
	{
		protected $id = 0;
		protected $userId = 0;
		protected $label = 'New account';
		protected $deposits = null;

		public function Account($userId, $label, $deposits = array()) {
			$this->userId = (int) $userId;
			$this->label = $label;
			$this->deposits = $deposits;
		}
		
		public function getAmount() {
			$amount = 0;
			foreach($this->deposits as $deposit) {
				$amount += $deposit->amount;
			}
			return $amount;
		}
		
		public function getAvailable() {
			$availableAmount = $this->getAmount();
			$allocations = AccountDAL::getAllAllocationsForAccount($this->id);
			
			foreach($allocations as $allocation) {
				$availableAmount -= $allocation->amount;
			}
			return $availableAmount;
		}

		public function __get($property) {
			switch ($property) {
				case 'id':
					return $this->id;
					break;
				case 'userId':
					return $this->UserId;
					break;
				case 'label':
					return $this->label;
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
				case 'userId':
					$value = intval($value);
					if(is_integer($value) && $value >= 0) {
						$this->userId = $value;
					}
					break;
				case 'label':
					if(is_string($value) && !empty($value)) {
						$this->label = $value;	
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