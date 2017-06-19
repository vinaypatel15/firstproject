<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlipKartController extends Controller
{
    public function getItems(Request $request,$keywords){


		$FkToken = "fffb8986c5b547d7aa0fdf85d5aacd1e";

		$FkId = "vinayp150";

		$endpoint = "affiliate-api.flipkart.net";

		$uri = "/affiliate/search/json";


		//var_dump($keywords);

		$params = array(
		    "query" => $keywords
		);

		$pairs = array();

		foreach ($params as $key => $value) {



		    array_push($pairs, $key."=".$value);
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the signed URL

		//var_dump($canonical_query_string);

		$request_url = 'https://'.$endpoint.$uri.'?'.$canonical_query_string;

		//echo "Signed URL: \"".$request_url."\"";
		$request_headers = array();
		$request_headers[] = 'Fk-Affiliate-Id: '. $FkId;
		$request_headers[] = 'Fk-Affiliate-Token: '.$FkToken;

		//var_dump($request_url);
		//var_dump($request_headers);
		 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $request_url); 
		curl_setopt($ch,CURLOPT_HTTPHEADER,$request_headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$data = curl_exec($ch); 
		curl_close($ch);

		return $data;
	}

}
