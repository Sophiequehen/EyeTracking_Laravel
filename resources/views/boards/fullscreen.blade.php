	@extends('layout.app')

	@section('title')
	{{ $comic->comic_title }} / Planche {{ $board->board_number }}
	@endsection


	@section('content')
	<div class="container modify board-fullscreen">
		<div class="card-body area">
			<div id="imgModif">
				<a id="exit-fullscreen" class="exit-fullscreen" href="{{ route('board-edit',[$comic->comic_id, $board->board_id]) }}"><i class="material-icons">close</i></a>
				<img id="background_map" src="{{ $board->board_image }}" alt="Planets" usemap="#planetmap" class="map">
				<map id="map_object" name="planetmap">
					<!-- avec/sans media -->
					@foreach ($areas as $zone) 
					<area id="map{{ $zone->area_id }}" shape="poly" coords="{{ $zone->area_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"0000ff","strokeWidth":2,"fillColor":"0000ff","fillOpacity":0.6}' data-style= "without-media" href="">
					@endforeach
				</map>  
			</div>
		</div>
	</div>
	@foreach ($areas as $zone) 
	@foreach ($medias as $media)
	@if($media->media_id === $zone->fk_media_id)
	<audio id="audio{{ $media->media_id }}"><source src="{{ $media->media_path }}" type="audio/mp3">
	</audio>
	@endif
	@endforeach
	@endforeach

	@endsection
	@section('extraJS')
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<script type="text/javascript">

		var tabMedias = {!! json_encode($medias->toArray()) !!};
		var tabAreas = {!! json_encode($areas->toArray()) !!};

		console.log(tabMedias);
	// console.log(tabAreas);

	tabAreas.forEach(function(area){
		tabMedias.forEach(function(media){

			var mediaId = media.media_id;
			var zoneId = area.fk_media_id;

			if(mediaId === zoneId){

				// console.log(mediaId);
				// console.log(zoneId);

				var test = "test_" + mediaId;
				$( "#map" + zoneId ).hover(function() {
					$("#audio" + mediaId).animate({volume: 1}, 100);
					test = setTimeout(function(){document.getElementById('audio'+mediaId).play()}, 500);
				});
				$( "#map" + zoneId ).mouseout(function() {
					clearTimeout(test);
					$("#audio" + mediaId).animate({volume: 0}, 1000);
				});
			};
		});
	});
</script>
@endsection
