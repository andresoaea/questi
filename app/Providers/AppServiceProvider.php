<?php

namespace App\Providers;

use URL;
use JavaScript;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        JavaScript::put([
            'siteUrl'  => URL::to('/'),
            'baseUrl'  => $request->getBaseUrl()
        ]);
    }
}
