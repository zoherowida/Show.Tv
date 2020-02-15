<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::post('/vueLogin', 'Auth\LoginController@vueLogin');
Route::post('/registerUser','VueController@register');
Route::prefix('json')->name('json.')->group(static function() {
    Route::post('UserAuth', [
        'as' => 'get.user',
        'uses' => 'VueController@getUser',
    ]);
    Route::post('SeriesTv', [
        'as' => 'get.seriesTv',
        'uses' => 'VueController@SeriesTv',
    ]);
    Route::get('Episode/all', [
        'as' => 'get.EpisodesAll',
        'uses' => 'VueController@EpisodesAll',
    ]);
    Route::post('Episodes', [
        'as' => 'get.Episodes',
        'uses' => 'VueController@EpisodeBySeries',
    ]);
    Route::post('Episode', [
        'as' => 'get.EpisodeById',
        'uses' => 'VueController@EpisodeById',
    ]);
    Route::post('ChangeFollow',[
        'as' => 'Change.Follow',
        'uses' => 'VueController@ChangeFollowingSeriesTv',
    ]);
    Route::post('ChangeLike',[
        'as' => 'Change.Like',
        'uses' => 'VueController@ChangeLikeEpisodes',
    ]);

});


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');
