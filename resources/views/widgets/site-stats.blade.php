<div class="row">
    
	@foreach($widget['data'] as $stat)
		<div class="col-6">
	      <div class="circle-tile ">
	        <div class="circle-tile-heading dark-blue"><i class="fa fa-{{ $stat['icon'] }}"></i></div>
	        <div class="circle-tile-content dark-blue">
	          <div class="circle-tile-description text-faded"> {{ $stat['text'] }}</div>
	          <div class="circle-tile-number text-faded ">{{ $stat['number'] }}</div>
	        </div>
	      </div>
	    </div>
	@endforeach
     
 </div> 