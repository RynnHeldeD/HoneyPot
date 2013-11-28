<?php
	class AccountDAL
	{
		public static function createAccount(&$account, $amount = 0) {
			global $user;

			DataAccessLayer::insertInto(
				'account',
				array($account->label, $user->id),
				array('label', 'userId')
			);
			$account->id = DataAccessLayer::getValue('SELECT  MAX(id) FROM account WHERE userId = '.$user->id.'');
			
			if($amount > 0) {
                var_dump('amount : ' . $amount);
				$firstDeposit = new Deposit($account->id, $amount, date('Y-m-d'));
                var_dump($firstDeposit);
				DepositDAL::createDeposit($firstDeposit);
			}
		}
		
		public static function getAllAccounts() {
			global $user;
			
			$objects = DataAccessLayer::query("SELECT * from account WHERE userId = ?", array($user->id));
			$accounts = array();
			
			foreach($objects as $account){
				$anAccount = new Account($account->userId, $account->label);
				$anAccount->id = $account->id;
				$anAccount->deposits = DepositDAL::getAllAccountDeposits($anAccount->id);
				
				$accounts[] = $anAccount;
			}
			
			return $accounts;
		}
		
		public static function getAllAllocationsForAccount($accountId) {
			$objects = DataAccessLayer::query("SELECT amount FROM allocate WHERE accountId = ?", array($accountId));
			$allocations = array();
			
			foreach($objects as $amount){
				$allocations[] = $amount;
			}
			
			return $allocations;
		}
	}
?>