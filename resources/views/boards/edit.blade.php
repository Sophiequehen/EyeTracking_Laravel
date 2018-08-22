@extends('layout.app')

@section('title')
{{ $comic->comic_title }} / Planche {{ $board->board_number }}
@endsection


@section('content')
<section class="page-titles">
	<h2>{{ $comic->comic_title }} - Planches n° {{ $board->board_number }}</h2>
	<p>/</p>
	<p id="full-screen" class="link-full-screen"><i class="material-icons">fullscreen</i><span>Lire en plein écran</span></p>
</section>

<div class="container modify board-edit">
	<div class="card-body area">
		<div id="imgModif">
			<!-- <a id="see-areas" class="link-see-areas" href="{{ route('mapping_show',[$board->board_id]) }}"><i class="material-icons">visibility</i><span>Voir toutes les zones</span></a> -->

			@if($comic->fk_user_id === Auth::user()->id || Auth::user()->fk_role_id === 3) 
			<p id="see-areas" class="link-see-areas"><i class="material-icons">visibility</i><span>Voir toutes les zones</span></p>
			<p id="hide-areas" class="link-hide-areas" style="display: none"><i class="material-icons">visibility_off</i><span>Cacher les zones</span></p>
			@endif

			<img id="background_map" src="{{ $board->board_image }}" alt="Planets" usemap="#planetmap" class="map">

			@if($comic->fk_user_id === Auth::user()->id || Auth::user()->fk_role_id === 3) 
			<a id="add-area" class="link-add-area" href="{{ route('mapping_create',[$board->board_id]) }}"><i class="material-icons">add_circle</i><span>Ajouter des zones</span></a>
			@endif

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
<script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script>
<script src="/js/jquery.maphilight.js"></script>
<script>
	$('#see-areas').click(function(){
		// $('.map').maphilight();
		$('.map').maphilight();
		$( "#hide-areas" ).toggle();
		$( "#see-areas" ).toggle();
	});
	$('#hide-areas').click(function(){
		$( "#hide-areas" ).toggle();
		$( "#see-areas" ).toggle();
		location.reload(true);
	});
</script>

<script>
//init the map for highlighting
// $('.map').maphilight();

// $(document).ready(function(){
// 	$('area').each(function(){
//     //   console.log($(this), 'ici');
//     var data = $(this).data('maphilight');  
//     $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
//     $(this).click(function(){
//             //    console.log($(this))
//             //    redirige vers ./area/{id}
//         });
// });
// });  

</script>
<script type="text/javascript">

	var tabMedias = {!! json_encode($medias->toArray()) !!};
	var tabAreas = {!! json_encode($areas->toArray()) !!};

	// console.log(tabMedias);
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
