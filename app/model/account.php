<?php
	class Account
	{
		protected $id = 0;
		protected $label = 'New account';
		protected $amount = 0;


		public function __get($property)
		{
			switch ($property) 
			{
				case 'id':
					return $this->id;
					break;
				case 'label':
					return $this->label;
					break;
				case 'amount':
					return $this->amount;
					break;
				default:
					return false;
					break;
			}
		}

		public function __set($property, $value)
		{
			switch($property) 
			{
				case 'id':
					if(is_integer($value) && $value >= 0)
					{
						$this->id = $value;
					}
					break;
				case 'label':
					if(is_string($value) && !empty($value))
					{
						$this->label = $value;	
					}
					break;
				case 'amount':
					if(is_double($value) && $value >= 0)
					{
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