<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AmazonController extends Controller
{
    public function getItems(Request $request){


		// Your AWS Access Key ID, as taken from the AWS Your Account page
		$aws_access_key_id = "AKIAJBBDWTVA2GR37Y6A";

		// Your AWS Secret Key corresponding to the above ID, as taken from the AWS Your Account page
		$aws_secret_key = "KKrVc0Teb0BffHIaRiSBE0Q2znACuQ2Y2u6zKbDE";

		// The region you are interested in
		$endpoint = "webservices.amazon.in";

		$uri = "/onca/xml";

		$keywords = $request->get('q');

		$params = array(
		    "Service" => "AWSECommerceService",
		    "Operation" => "ItemSearch",
		    "AWSAccessKeyId" => "AKIAJBBDWTVA2GR37Y6A",
		    "AssociateTag" => "123456066a-21",
		    "SearchIndex" => "All",
		    "Keywords" => $keywords,
		    "ResponseGroup" => "ItemAttributes"
		);

		// Set current timestamp if not set
		if (!isset($params["Timestamp"])) {
		    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
		}

		// Sort the parameters by key
		ksort($params);

		$pairs = array();

		foreach ($params as $key => $value) {
		    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

		// Generate the signed URL
		$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

		//echo "Signed URL: \"".$request_url."\"";
		 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $request_url); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$data = curl_exec($ch); 
		curl_close($ch); 

		$data = $this->convertJson($data);

		//var_dump($data);

		$items = [];

		foreach ($data as $key => $value) {
			if($key == 'Item'){
				$asin = null;
				$itemAttr = null;
				foreach ($value as $key => $val) {
					if($key == 'ASIN')
						$asin = $val;
					else if($key == 'ItemAttributes')
						$items[$asin] = $val;
				}
			}
		}

		var_dump($items);

		return $data;
	}

	public function convertJson($data){
		$data = $this->str_chop_lines($data,8);
		$xml = simplexml_load_string($data);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		return $array['Items'];

	}

	public function str_chop_lines($str, $lines) {
    	$counter = 0;
    	$length = strlen($str);
    	while($str{$counter} != '<'){
    		$counter++;
    	}
    	//var_dump($str);
    	return substr($str, $counter);
	}

}
