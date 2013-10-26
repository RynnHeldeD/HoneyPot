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
				$firstDeposit = new Deposit($account->id, $amount, date('Y-m-d'));
				DepositDAL::createDeposit($firstDeposit);
			}
		}
		
		public static function getAllAccounts()
		{
			$objects = DataAccessLayer::query("SELECT * from account");
			$accounts = array();
			
			foreach($objects as $account){
				$anAccount = new Account($account->userId, $account->label);
				$anAccount->id = $account->id;
				$anAccount->deposits = DepositDAL::getAllAccountDeposits($anAccount->id);
				
				$accounts[] = $anAccount;
			}
			
			return $accounts;
		}
	}
?>