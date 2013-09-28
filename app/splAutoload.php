<?php
	function splAutoload()
	{
		spl_autoload_register(function ($class) {
			if(file_exists('model/' . $class . '.php'))
			{
				require_once('model/'. $class . '.php');
			}
		});
	}
	
	splAutoload();
	DataAccessLayer::init();
?>