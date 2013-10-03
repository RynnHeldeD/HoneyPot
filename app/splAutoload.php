<?php
	function splAutoload()
	{
		spl_autoload_register(function ($class) {
			if(file_exists('app/model/' . $class . '.php'))
			{
				require_once('app/model/'. $class . '.php');
			}
		});
	}
	
	splAutoload();
	DataAccessLayer::init();
?>