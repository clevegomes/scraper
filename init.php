<?php
spl_autoload_register(function($class){

//    print_r("$class.php");exit;
	//require_once "$class.php";

    $class = str_replace('\\', '/', $class);
    if(file_exists('/var/www/html/scraper/' . $class . '.php'))
        require_once('/var/www/html/scraper/' . $class . '.php');
});


?>