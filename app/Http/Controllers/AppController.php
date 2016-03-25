<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Twitter;
use App\Http\Requests\RetweetRequest;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
    
    public function zipcode()
    {
        return view('twitter.zipcode');
    }
    
    public function zipcodeSearch(Request $request)
    {
        
        $query  = $request->input('query') ? : 'Hello';
        $count  = $request->input('count') ? : 100;
        
        $lat    = $request->input('lat') ? : 17.4014883;
        $lng    = $request->input('lng') ? : 78.5666052;
        $radius = $request->input('radius') ? : 3;
        $gcode  = $lat . ',' . $lng . ',' . $radius . 'mi';
        $results = Twitter::getSearch(['q' => $query, 'count' => $count, 'geocode' => $gcode, 'format' => 'object']);
        
        return view('twitter.zipcode', compact('results'));
        
        
    }     
    
    public function search(Request $request)
    {
        if($request->input('count')){
            $results = Twitter::getSearch(['q' => $request->input('query'), 'count' => $request->input('count'), 'format' => 'object']);
            return view('welcome', compact('results'));
        }else{
            $results = Twitter::getSearch(['q' => $request->input('query'), 'count' => 20, 'format' => 'object']);
            return view('welcome', compact('results'));
        }
    }
    
    public function retwitter(){
        $filename = '';
        
        if(file_exists(base_path().'/twitterenv/datasets/dazzlespa.csv')){
            $filename = 'dazzlespa';
        }
        return view('twitter.retwitter', compact('filename'));
    }
    public function retweet(RetweetRequest $request , $id){
        dd($request->toArray());
        //$retwets = Twitter::post($id, ['retweet' => $request->input('retweet')]);
    }
    
    public function mapsearch(){
        return view('map.index');
    }
    
    public function mapsearched(Request $request){
        
    }
    
    public function stream(){
        return view('twitter.stream');
    }
}
