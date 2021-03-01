<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EdamamApi as EdamamApiResource;

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
        			'calories' => round($recipe->calories,2),
        		];
        	}
        }
        return $data;
    }

}
