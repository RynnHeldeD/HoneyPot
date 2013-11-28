<?php
	class Objective
	{
		protected $id = 0;
		protected $userId = 0;
		protected $goal = null;
		protected $label = 'New objective';
		protected $allocations = null;
		protected $validationDate = '0000-00-00';

		public function Objective($userId, $label, $goal, $validationDate = '0000-00-00', $allocations = array()) {
			$this->userId = (int) $userId;
			$this->goal = (int) $goal;
			$this->label = $label;
			$this->allocations = $allocations;
			$this->validationDate = $validationDate;
		}

		public function getAmount() {
			$totalAmount = 0;
			if($this->allocations) {
				foreach ($this->allocations as $account => $amount) {
					$totalAmount += $amount;
				}
			}
			return $totalAmount;
		}

		public function __get($property) {
			switch($property) {
				case 'allocations':
					return $this->allocations;
					break;
				case 'id':
					return $this->id;
					break;
				case 'userId':
					return $this->userId;
					break;
				case 'label':
					return $this->label;
					break;
				case 'goal':
					return $this->goal;
					break;
				case 'amount':
					return $this->getAmount();
					break;
				case 'validationDate':
					return $this->validationDate;
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
				case 'userId':
					if(is_integer($value) && $value >= 0) {
						$this->userId = $value;
					}
					break;
				case 'label':
					if(is_string($value) && !empty($value)) {
						$this->label = $value;
					}
					break;
				case 'allocations':
					if(is_array($value) && !empty($value)) {
						$this->allocations = $value;
					}
					break;
				case 'goal':
					if((is_double($value) && $value >= 0) || is_null($value)) {
						$this->goal = $value;
					}
					break;
				case 'validationDate':
					$date = explode('-', $value);
					if(checkdate($date[1], $date[2], $date[0])) {
						$this->date = $value;
					}
					break;
				default:
					return false;
					break;
			}
		}
	}
?>
