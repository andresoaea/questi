@section('header')
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        
        @if(!empty($isProfilePage))
           <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
        @else 
           <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @endif     

    </head>
    <body>

  {{--  @inject( 'response', 'Illuminate\Http\Response' )
   @if($response->status() === 200)
   --}}

      <div class="questi-preloader">
         <div class="pulse-loader"></div>
      </div> 

         <div id="questi">
    	
    		<vue-progress-bar></vue-progress-bar>
    		<navigation-bar></navigation-bar>

@show