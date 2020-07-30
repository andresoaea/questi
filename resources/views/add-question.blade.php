@extends('layouts.master')

@section('content')

	@auth
           
         <add-new-question></add-new-question>
        



		{{-- {!! Form::open(['route' => 'saveQuestion']) !!}
    	
    	<div class="form-group">
    		{!! Form::label('title', 'Question title') !!}
    		{!! Form::text('title', old('title')) !!}
    	</div>

    	<div class="form-group">
    		{!! Form::label('description', 'Question description') !!}
    		{!! Form::text('description', old('description')) !!}
    	</div>


    	<div class="form-group">
    		{!! Form::label('category', 'Question category') !!}
    		{!! Form::select('category', $categories, '1') !!}
    	</div>

    	{!! Form::submit('Click Me!') !!}



		{!! Form::close() !!}

        --}}

	@else 

		Trebuie sa te conectezi

	@endauth			


@stop