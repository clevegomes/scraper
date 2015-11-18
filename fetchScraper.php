<?php


require_once "init.php";
$searchString = $_GET["searchString"];


$scraperObj = new \Cls\Scraper($searchString);
echo $searchString;


?>