<?php
	class Objective
	{
		protected $id = 0;
		protected $label = 'New objective';
		protected $allocations = null;
		protected $goal = 0;
		protected $validationDate = '0000-00-00';

		public function Objective($label, $goal, $validationDate) {
			$this->label = $label;
			$this->goal = $goal;
			$this->validationDate = $validationDate;
		}

		public function __get($property) {
			switch($property) {
				case 'amount':
					$totalAmount = 0;
					foreach ($this->allocations as $account => $amount) {
						$totalAmount += $amount;
					}
					return $totalAmount;
					break;
				case 'allocations':
					return $this->allocations;
					break;
				case 'id':
					return $this->id;
					break;
				case 'label':
					return $this->label;
					break;
				case 'goal':
					return $this->goal;
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
					if(is_double($value) && $value >= 0) {
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
