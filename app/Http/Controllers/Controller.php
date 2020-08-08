<?php

namespace App\Http\Controllers;

use URL;
use Illuminate\Http\Request;
use App\Http\Controllers\WidgetController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
    
         $widgets_data = WidgetController::getAllData();
         
         \JavaScript::put([
            'siteUrl'  => URL::to('/'),
            'baseUrl'  => $request->getBaseUrl(),
            'widgets'  => json_encode($widgets_data)
        ]);


    }
}
