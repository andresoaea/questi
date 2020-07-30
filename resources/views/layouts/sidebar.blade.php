{{-- 
	@foreach( $sidebar_widgets as $widget_key => $widget )

		@php 

			$widget_component = str_replace('_', '-', $widget_key);

			$widget_class = isset($widget['not_standard_layout']) ? 
						    'widget-not-standard' : 'sidebar-widget';

			$widget_class = $widget_class . ' widget-' . $widget_component;			    

		@endphp
	

	 	<div class="{{ $widget_class }}">
	 		@if(!empty($widget['title']))
	 			<h5 class="widget-title">{{ $widget['title'] }}</h5>
	 			<hr />
	 		@endif
	 		<div class="widget-content">
	 			@include('widgets.' . $widget_component)
	 		</div>
	 	</div>

	@endforeach
	--}}