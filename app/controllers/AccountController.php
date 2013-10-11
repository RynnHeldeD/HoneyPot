<?php
	class AccountController
	{
		public static function defaultAction() {
		}

		public static function getAllAccountsAction() {
			$accounts = AccountDAL::getAllAccounts();
			$objectives = ObjectiveDAL::getAllObjectives();
			
			include_once('app/views/index.view.php');
		}
	}
?>