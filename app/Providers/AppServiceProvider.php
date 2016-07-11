<?php

namespace App\Providers;
use Validator;
use Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('non_zero_key', function($attribute, $value, $parameters, $validator) {
            return ($value!=0) ? true : false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('App\Api\InterfacerInterface', 'App\Api\SanitasInterfacer');

/*        $this->app->singleton('App\Api\InterfacerInterface', function ($ext) {

            $labRequest = json_decode(Request::getContent());
            $labRequest = json_decode($labRequest[0]);
            // $labRequest = str_replace(['labRequest', '='], ['', ''], $labRequest);

            // return $ext['App\Api\SanitasInterfacer']->retrieve($labRequest);
            return $ext['App\Api\SanitasInterfacer']->retrieve($labRequest);
            // prepare for labRequest here
        });
*/    }
}
