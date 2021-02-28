<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EdamamAPIController extends Controller
{
	private $api_id = '847f439a';
	private $api_key = 'a45e9774cef26c282eab6469795fe8b9';

	public function get_request($search)
    {
    	$param = ['q' => $search];
    	$param  = http_build_query($param);
    	$param  = '&'.$param;
    	$url = 'https://api.edamam.com/search?'.$param.'&app_id='.$this->api_id.'&app_key='.$this->api_key;
    	$client = new \GuzzleHttp\Client();
        $response = $client->get($url);
        $result = json_decode($response->getBody());
        $data = [];
        if($result->hits){
        	foreach ($result->hits as  $res) {
        		$recipe = $res->recipe;
        		$data[] = [
        			'label' => $recipe->label,
        			'image' => $recipe->image,
        			'source' => $recipe->source,
        			'url' => $recipe->url,
        			'healthLabels' => $recipe->healthLabels,
        			'ingredientLines' => $recipe->ingredientLines,
        			'calories' => round($recipe->calories,2),
        		];
        	}
        }
        return $data;
    }

   	public function index(Request $request)
    {
    	$param = [
    		'q' => 'chicken'
    	];
    	$param_s  = http_build_query($param);
    	$param_s  = '&'.$param_s;
    	$url = 'https://api.edamam.com/search?q=chicken&app_id=847f439a&app_key=a45e9774cef26c282eab6469795fe8b9&from=0&to=3&calories=591-722&health=alcohol-free'.$param_s;
    	dd($url);
    	 $client = new \GuzzleHttp\Client();
         $response = $client->get($url);
         $data = json_decode($response->getBody());
         dd($data);
    }
}
