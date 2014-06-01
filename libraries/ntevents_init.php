<?php
define ("NTEVENTS_LOCATION", "libraries/penis");	//represents the path to ntevents folder up from php application init file.

spl_autoload_register(function($class){
	set_include_path(get_include_path() . PATH_SEPARATOR . NTEVENTS_LOCATION);
	spl_autoload_extensions('.class.php,.interface.php');
	spl_autoload(strtolower($class));
});