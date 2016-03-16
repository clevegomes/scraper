<?php

require_once "init.php";
$searchString = $_GET["searchString"];
$order = $_GET["order"];
echo "test";
exit;


$scraperObj = new \Cls\Scraper($searchString);

$scraperObj->sorting($order);
echo $scraperObj->getItemArry();


?>