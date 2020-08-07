@include('layouts.header')

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