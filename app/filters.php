<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::route('user.login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::route('user.home');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/* Role/permission based Route filters */

/*If the user does not have the first role most likely administrator
redirect to the home page */
Route::filter('admin', function()
{
    if (! Entrust::hasRole(Role::find(1)->name))
    {
        return Redirect::to('home');
    }
});

/**
 *  A filter that receives a permission ($perms) as the parameter and checks if the user has
 *  the said permissions. 
 */
Route::filter('checkPerms', function($route, $request, $perms)
{
    if (! Entrust::can($perms)) {
       return Redirect::to('home');
    }
});

/**
 *  A filter that permits the user to only edit his own profile
 */
Route::filter('selfdom', function($route, $request)
{
	// The second segment of the URI contains the user id
	// Check this against the id of the current user
	if (Auth::id() != Request::segment(2)) {
 		//That was not your profile - don't be nosey!
		return Redirect::route('user.home');
	}
});