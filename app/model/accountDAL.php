<?php
	class AccountDAL
	{
		public static function createAccount(&$account) {
			DataAccessLayer::insertInto(
				'account',
				array($account->label, $account->amount),
				array('label', 'amount')
			);
			$account->id = DataAccessLayer::getValue('SELECT  MAX(id) FROM account');
			
			if($account->amount > 0) {
				$firstDeposit = new Deposit($account->id, $account->amount, date('Y-m-d'));
				DepositDAL::createDeposit($firstDeposit);
			}
		}
		
		public static function getAllAccounts()
		{
			$objects = DataAccessLayer::query("SELECT * from account");
			$accounts = array();
			
			foreach($objects as $account){
				$anAccount = new Account($account->label, $account->amount);
				$anAccount->id = $account->id;
				$anAccount->deposits = DepositDAL::getAllAccountDeposits($anAccount->id);
				
				$accounts[] = $anAccount;
			}
			
			return $accounts;
		}
	}
?>