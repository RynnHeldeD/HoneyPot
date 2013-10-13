<?php
	class FrontController
	{
		public static function defaultAction() {
			self::showFrontPage();
		}

		private static function showFrontPage() {
			$accounts = AccountDAL::getAllAccounts();
			$objectives = ObjectiveDAL::getAllObjectives();

			include_once('app/views/index.view.php');
		}
	}
?>