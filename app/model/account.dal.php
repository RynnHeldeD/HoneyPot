<?php
	class AccountDAL extends DataAccessLayer
	{
		public static function createAccount($account)
		{
			if($account->amount > 0){
				DataAccessLayer::insertInto('account', array($account->name, 0), array('label', amount));
			}
		}
	}
?>