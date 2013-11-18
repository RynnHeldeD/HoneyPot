<?php
	class FrontController
	{
		public static function defaultAction() {
			self::showFrontPage();
		}

		private static function showFrontPage() {
			$accounts = AccountDAL::getAllAccounts();
			$nonCompletedObjectives = ObjectiveDAL::getNonCompletedObjectives();
			$completedObjectives = ObjectiveDAL::getCompletedObjectives();

			include_once('app/views/index.view.php');
		}
	}
?>