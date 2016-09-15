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
        \Blade::setRawTags('{{', '}}');
        \Blade::setContentTags('{{{', '}}}');
        \Blade::setEscapedContentTags('{{{', '}}}');
    }
}
