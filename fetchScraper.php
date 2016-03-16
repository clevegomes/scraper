<?php

require_once "init.php";
$searchString = $_GET["searchString"];
$order = $_GET["order"];



$scraperObj = new \Cls\Scraper($searchString);
echo "working2";
return;

$scraperObj->sorting($order);
echo $scraperObj->getItemArry();


?>