<?php

/*
|--------------------------------------------------------------------------
| Application Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


// User Handling, authantication etc


Route::get('/user', function(){
	return View::make('create_user_form');
});


Route::post('/user', function(){
	$user = new User();
	$user->username    = Input::get('username');
	$user->password    = Hash::make(Input::get('password'));
	$user->email       = Input::get('email');
	$user->warfacts_id = (int) Input::get('warfacts_id');
	$user->empire      = Input::get('empire', null);
	$user->approved    = false;
	$user->save();

	return Response::make('User Added!');
});

Route::get('/fleets/enemy', array(
	'before' => 'auth',
	function()
	{
		return View::make('enemy_fleets');
	}
));

Route::get('/login', function(){
	return View::make('login_form');
});

Route::post('login', function(){
	$username = Input::get('username');
	$password = Input::get('password');
	$remember = Input::has('remember');

	$credentials = array('username' => $username, 'password' => $password, 'approved' => true);
	if (Auth::attempt($credentials, $remember) ){
		Log::info("User " + $username + " successfully log on on " +  date('Y/m/d h:i:s', time()));
		return Redirect::intended('/');
	}
	return Redirect::to('login');
});

Route::get('/logout', function(){
	Auth::logout();
	return Response::make('Logged out');
});



// Fleet Handling

//Bind route parameters
Route::model('fleet', 'Fleet');

Route::group(array('prefix' => 'fleets', 'before' => 'auth'), function() {

	//Show pages

	Route::get('/', 'FleetsController@show');
	Route::get('/add', 'FleetsController@add');
	Route::get('/update/{fleet}', 'FleetsController@update');
	Route::get('/delete/{fleet}', 'FleetsController@delete');

	//Handle form submissions

	Route::post('/', 'FleetsController@show');
	Route::post('/add', 'FleetsController@handleAdd');
	Route::post('/update', 'FleetsController@handleUpdate');
	Route::post('/delete', 'FleetsController@handleDelete');

});

// Perimeter Scan Handling

Route::get('/scanHtml', 'PerimeterScanController@getPerimeterScanHtml');
Route::post('/scanHtml', 'PerimeterScanController@parsePerimeterScanHtml');


//After here all are Test to be removed


// SOS double quotes to show variables like that
Route::get('/{number}/page', function($number){
	return ("This is the {$number}  page");
});

Route::get('redirect', function(){
	return Redirect::to('/first/page');
});

//SOS Note: testview, not testview.php
route::get('/{uri}', function($uri){
	$data['typed_uri'] = $uri;
	return View::make('testview',$data);
});

