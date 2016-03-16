<?php
spl_autoload_register(function($class){
    print_r($class);exit;
	require_once "$class.php";
});


?>