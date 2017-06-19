<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AmazonController;
use App\Http\Controllers\FlipKartController;

use Illuminate\Http\Request;

class MainController extends Controller
{

	

    public function getItems(Request $request){

    	 $amazon = new AmazonController();
		 $flipkart = new FlipKartController();


		 $keywords = $request->get('query');

		$keywords = str_replace(' ', '+', $keywords);

    	$amazonData = $amazon->getItems($request,$keywords);

    	var_dump($amazonData);

    	$flipkartData = $flipkart->getItems($request,$keywords);

    	var_dump($flipkartData);	
    }
}
