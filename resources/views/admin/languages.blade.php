@extends('layouts.admin.master')
@section('page-header', 'Languages')

@section('content')


	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Change Language Strings</h3>
		</div>
		<div class="box-body">
			<div class="dataTables_wrapper form-inline dt-bootstrap">
				
				<table class="table table-bordered table-hover dataTable">
					<thead>
		                <tr>
		                  <th>Original strings</th>
		                  <th>Translated strinsg</th>
		                </tr>
	                </thead>
	                <tbody>
		                <tr>
		                  {!! $lang_strings  !!}
		                </tr>
	            	</tbody>
				</table>
			
			</div>
		</div>
	</div>

	
	

	
	
@stop