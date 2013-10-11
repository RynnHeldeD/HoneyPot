<?php
	class FrontController
	{
		public static function defaultAction() {
			self::showFrontPage();
		}

		private static function showFrontPage() {
			include_once('app/views/index.view.php');
		}
	}
?>