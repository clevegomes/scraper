<?php
/**
 * Created by PhpStorm.
 * User: Developer1
 * Date: 17/11/2015
 * Time: 5:24 PM
 */

namespace Cls;

class Scraper {


	private $searchString;
	private $rawWebData;
	private $error = false;
	const URL = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=";
//	const URL = "http://www.livescore.com/soccer/england/";

	function __construct($searchString)
	{
		$this->searchString = $searchString;

		$this->connection();

		$this->scrapping();



	}


	public function connection()
	{
		$curly = curl_init();
		curl_setopt($curly, CURLOPT_URL,self::URL.$this->searchString);
//		curl_setopt($curly, CURLOPT_URL,self::URL);
		curl_setopt($curly, CURLOPT_HEADER, 0);
		curl_setopt($curly, CURLOPT_TIMEOUT, 120);
		curl_setopt($curly, CURLOPT_RETURNTRANSFER, true);

		$this->rawWebData = curl_exec($curly);
		$errorString = curl_error($curly);
		if(strlen($errorString)>0)
			$this->error = true;

		curl_close($curly);

	}


	public function scrapping()
	{

		if($this->error == false)
		{

			$dom = new \DOMDocument();
//			$page = file_get_contents(self::URL.$this->searchString);
//			print_r($page);exit;
			@$dom->loadHTML($this->rawWebData);
//			$dom->loadHTML($page);
			$xpath = new \DOMXPath($dom);

//			$tableRows  = $xpath->query('//div');
//			$tableRows  = $xpath->query("//body[@class='soccer narrow']");
			$tableRows  = $xpath->query("//div[@class='s-item-container']");
			$scores = array();
//			var_dump($tableRows);exit;

			foreach ($tableRows as $row) {

				print_r($row);
				exit;

				// fetch all 'td' inside this 'tr'
				$td = $xpath->query('td', $row);
				// we'll store information about each match in this array
				$match = array();

				if ($td->length == 1 && $xpath->query('td/b', $row)->length == 1) {
					$league = substr($xpath->query('td/text()', $row)->item(1)->textContent, 3);
					$scores[$league] = array();

				} elseif ($td->length == 2) { // date
					/* ... */
				} elseif ($td->length == 4) { // match result
					/* ... */
				}
			}



		}

	}


	public function parsing  ()
	{

	}

	public function sorting ()
	{
		
	}


}