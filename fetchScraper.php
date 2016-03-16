<?php

require_once "init.php";
$searchString = $_GET["searchString"];
$order = $_GET["order"];


$scraperObj = new \Cls\Scraper($searchString);

$scraperObj->sorting($order);
echo $scraperObj->getItemArry();


?>