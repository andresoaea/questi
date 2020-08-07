@php
	$currnt_user = Auth:: check() ? Auth::user()->makeHidden(['email', 'created_at', 'updated_at']) : 'false';	
@endphp

@section('footer')

			<back-to-top bottom="50px" right="50px">
				<button type="button" class="btn btn-info btn-to-top"><i class="fa fa-chevron-up"></i></button>
			</back-to-top>

			<footer class="main-footer">
				<p class="copyright-text">&copy; 2020 Questi - Q&A Platform</p>	
			</footer>

		</div><!-- #questi -->

		@include('layouts.js')
		<script>window.currentUser = {!! $currnt_user !!}</script>
		<script src="{{ asset('js/main.js') }}"></script> 


		@if(!empty($isProfilePage))
			<script src="{{ asset('js/profile.js') }}"></script> 
		@endif
	
	</body>
</html>

@show