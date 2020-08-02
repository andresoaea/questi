@if($view_name !== 'add-question')
    <a href="{{ route('addQuestion') }}">Ask a Question</a>
@else 
    <!-- Fix for first widget spacing -->
    <div style="position:relative; top:0; margin-top: -30px;"></div>
@endif
