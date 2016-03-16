<?php
/**
 * Created by PhpStorm.
 * User: Developer1
 * Time: 5:24 PM
 */

namespace Cls;

class Scraper {


	private $searchString;
	private $rawWebData;
    private $itemArry = [];
    private $sortArry = [];


	private $error = false;
	const URL = "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=";


/*
 *  Constructor
 */
	function __construct($searchString)
	{
		$this->searchString = $searchString;


		$this->connection();
//
//		$this->scrapping();
//        $this->parsing();



	}


    /**
     * Get the result
     * @return array :  Scraped  that is sorted data
     */
    public function getItemArry()
    {
        return json_encode($this->itemArry);
    }


    /*
     * Connection to outward URL using Curl
     */
	public function connection()
	{
//		$curly = curl_init();
//		curl_setopt($curly, CURLOPT_URL,self::URL.$this->searchString);
//		curl_setopt($curly, CURLOPT_HEADER, 0);
//		curl_setopt($curly, CURLOPT_TIMEOUT, 120);
//		curl_setopt($curly, CURLOPT_RETURNTRANSFER, true);
//
//		$this->rawWebData = curl_exec($curly);
//		$errorString = curl_error($curly);
//		if(strlen($errorString)>0)
//			$this->error = true;
//
//		curl_close($curly);

	}


    /*
     * Scrapping (Get chunk of a data and discard the rest)
     */
	public function scrapping()
	{

		if($this->error == false)
		{

			$dom = new \DOMDocument();

			@$dom->loadHTML($this->rawWebData);
			$xpath = new \DOMXPath($dom);

			$requiredBlock = $xpath->query("//div[@class='s-item-container']");


            $itemArry = [];
            foreach ($requiredBlock as $content)
            {
                $imgpath = $title = $price = null;
                $tableRows1  = $xpath->query("div/div/div[@class='a-fixed-left-grid-col a-col-left']/div/div/a[@class='a-link-normal a-text-normal']/img",$content);

                if($tableRows1->length >0)
                    $imgpath = $tableRows1->item(0)->getAttribute('src');
                else
                    $imgpath = "http://www.jetcharters.com/bundles/jetcharterspublic/images/image-not-found.jpg";


                $tableRows2  = $xpath->query("div/div/div[@class='a-fixed-left-grid-col a-col-right']/div[@class='a-row a-spacing-small']/a[@class='a-link-normal s-access-detail-page  a-text-normal']",$content);
                if($tableRows2->length >0)
                    $title = $tableRows2->item(0)->getAttribute('title');


                $tableRows3  = $xpath->query("div/div/div[@class='a-fixed-left-grid-col a-col-right']/div[@class='a-row']/div/div/a/span",$content);
                if($tableRows3->length >0)
                    $price = $tableRows3->item(0)->textContent;

                if($price != null)
                {

                    if(is_numeric(substr($price,1)))
                    {
                        $currency = $price[0];
                        $cost = substr($price,1);

                    }
                    else
                    {
                        $currency = "";
                        $cost = $price;
                    }

                    $itemArry[] = ["img"=>$imgpath,"title"=>$title,"price"=>$cost,"currency"=>$currency];

                }

            }

            $this->itemArry = $itemArry;



		}

	}



    /*
     * Parsing (Parse the data into sortable arrays)
     */
	public function parsing ()
	{
        foreach($this->itemArry as $ky => $val)
        {
            $this->sortArry['price'][$ky] = $val['price'];
            $this->sortArry['title'][$ky] = $val['title'];

        }

	}


    /*
     * Sorting (Sort based on price in ascending or descending
     * $mode : 1 low to high / 0 high to low
     * $by : price sort array will be used
     *
     *
     */
	public function sorting ($mode=1,$by = "price")
	{
        if(isset($this->sortArry[$by]))
        {
        if($mode == 1)
            uasort($this->sortArry[$by],function($a,$b)
                {
                    $a = ($a =="Free")?0:$a;
                    $b = ($b =="Free")?0:$b;

                    if ($a==$b) return 0;
                    return ($a<$b)?-1:1;
                }
            );
        else
            uasort($this->sortArry[$by],function($a,$b)
            {
                $a = ($a =="Free")?0:$a;
                $b = ($b =="Free")?0:$b;
                if ($a==$b) return 0;
                return ($a<$b)?1:-1;
            });
        $sAry = [];
        foreach($this->sortArry[$by] as $ky => $val)
        {
            $sAry[] = ["img"=>$this->itemArry[$ky]["img"],"title"=>$this->itemArry[$ky]["title"],"currency"=>$this->itemArry[$ky]["currency"],"price"=>$this->itemArry[$ky]["price"]];
        }
        $this->itemArry = $sAry;

        }

    }




}