<?php

require_once "init.php";
//require_once "/var/www/html/scraper/Cls/Scraper.php";
$searchString = $_GET["searchString"];
$order = $_GET["order"];


$scraperObj = new \Cls\Scraperg($searchString);

//$scraperObj->sorting($order);
//echo $scraperObj->getItemArry();


?>