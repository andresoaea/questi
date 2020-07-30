@include('layouts.header')
{{--
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div id="main-content">@yield('content')</div>
		</div>
		<div class="col-lg-4">
			
			<affix relative-element-selector="#main-content" :scroll-affix="true" :offset="{ top: 30, bottom: 0 }">
				@include('layouts.sidebar')
			</affix>
			
		</div>
	</div>
</div>
--}}

<div class="main-container container">
	<div class="row" data-sticky_parent>
		<div class="content col-lg-8">
        	@yield('content')
    	</div>
	    <div class="sidebar col-lg-4">
	        <div class="sidebar__inner" data-sticky_column>
	            @include('layouts.sidebar')
	        </div>
	    </div>
	</div>
</div>

@include('layouts.footer')