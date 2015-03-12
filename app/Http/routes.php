<?php

Route::get('/', function () {
  return redirect('/videos');
});

Route::any('/videos', ['middleware' => 'google_login', 'uses' => 'YoutubeAPIController@videos', 'as' => 'videos']);
Route::get('/video/{id}', ['middleware' => 'google_login', 'uses' => 'YoutubeAPIController@video', 'as' => 'video']);
Route::any('/search', ['middleware' => 'google_login', 'as' => 'search', 'uses' => 'YoutubeAPIController@search']);

Route::get('/login', ['uses' => 'GoogleLoginController@index', 'as' => 'login']);
Route::get('/loginCallback', ['uses' => 'GoogleLoginController@store', 'as' => 'loginCallback']);
