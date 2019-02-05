<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('artists', 'Api\\ArtistsController');
Route::resource('songs', 'Api\\SongsController');
Route::get('popular-songs', 'Api\\SongsController@popularSong');
Route::get('popular-artists', 'Api\\ArtistsController@popularArtists');
Route::get('popular-artists-all', 'Api\\ArtistsController@popularArtistsAll');



Route::post('counter-song', 'Api\\SongsController@songCounter');
Route::get('search', 'Api\\SearchController@search');


