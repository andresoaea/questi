@extends('layouts.master') 
@section('title', 'Questi - Q&A Platform') 
@section('content') 

    {{--

    @guest
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
    @else
        
             {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }} 

            <ul>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        
    @endguest

   
        <section class="questions">
        @foreach($questions as $question) 

            <h1>{{ $question->title }}</h1>
            <p>{{ $question->description }}</p>
            <p style="color: green">{{ $categories[$question->category]['name'] }}</p>
            <p style="color: red">Intrebarea lui {{ $authors[$question_author_ids[$question->id]]['firstname'] }}</p>

            <br>

        @endforeach
    </section>
    --}}

    <section class="home-questions">
       <!--  @{{ questions }} -->
        <show-all-questions><show-all-questions>
    </section>

@stop