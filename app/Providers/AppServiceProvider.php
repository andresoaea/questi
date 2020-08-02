<?php

namespace App\Providers;

use URL;
use View;
use JavaScript;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(Request $request, UrlGenerator $url)
    {
        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('https');
        }

        view()->composer('*', function($view){
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
        });

        View::share('sidebar_widgets', WidgetController::getAllData());

        // var_dump( WidgetController::getAllData());

        JavaScript::put([
            'siteUrl'  => URL::to('/'),
            'baseUrl'  => $request->getBaseUrl()
        ]);
    }
}
