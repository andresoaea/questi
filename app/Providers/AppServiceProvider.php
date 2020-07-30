<?php

namespace App\Providers;

use URL;
use View;
use JavaScript;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\WidgetController;

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
        View::share('sidebar_widgets', WidgetController::getAllData());

        // var_dump( WidgetController::getAllData());

        JavaScript::put([
            'siteUrl'  => URL::to('/'),
            'baseUrl'  => $request->getBaseUrl()
        ]);
    }
}
