@php
	$currnt_user = Auth:: check() ? Auth::user()->makeHidden(['email', 'created_at', 'updated_at']) : 'false';	
@endphp

@section('footer')

	<back-to-top bottom="50px" right="50px">
		<button type="button" class="btn btn-info btn-to-top"><i class="fa fa-chevron-up"></i></button>
	</back-to-top>

		<footer style="width: 100%; height: 200px; background-color: #343a40;">
			
		</footer>

	</div><!-- #questi -->

	@include('layouts.js')
		<script>window.currentUser = {!! $currnt_user !!}</script>
<!-- 	<script src="https://abouolia.github.io/sticky-sidebar/js/ResizeSensor.js"></script> -->

	<script src="{{ URL::asset('js/main.js') }}"></script> 

{{-- 
	@if(!empty($isProfilePage))
		<script src="{{ URL::asset('js/profile.js') }}"></script> 
	@endif
	--}}

<!-- 	<script src="https://cdn.rawgit.com/leafo/sticky-kit/v1.1.2/jquery.sticky-kit.min.js"></script> -->

	</body>
</html>

@show