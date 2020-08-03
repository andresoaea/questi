@extends('layouts.master') 
@section('title', 'Questi - Q&A Platform') 
@section('content') 

    <section class="home-questions">
        <!-- <show-all-questions><show-all-questions> -->
            <router-view :key="$route.path"></router-view>
    </section>

@stop