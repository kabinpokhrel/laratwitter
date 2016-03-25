<?php
Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/', 'AppController@index');
    Route::post('/', 'AppController@search');
    Route::get('/zipcode', 'AppController@zipcode');
    Route::get('/mapsearch', 'AppController@mapsearch');
    Route::get('/stream', 'AppController@stream');
    Route::get('/retweet', 'AppController@retwitter');
    Route::post('/mapsearch', 'AppController@mapsearched');
    Route::post('/zipcode', 'AppController@zipcodesearch');
    Route::post('/retweet/{twitterID}/', [
        'as' => 'retweet', 
        'uses' => 'AppController@retweet'
    ]);
    Route::get('/home', 'HomeController@index');
    Route::get('/testingmap', function(){
        return view('map.test');
    });
});
