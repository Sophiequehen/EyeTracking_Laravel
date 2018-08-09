@extends('layout.app')

@section('title')
Voir les zones
@endsection

@section('content')
<div class="container modify">
  <div class="card-body area">
    <div id="imgModif">
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
<a class="btn-add-bd" href="{{ route('mapping_create',[$board->board_id]) }}"><i class="material-icons">add</i><span>Ajouter des zones</span></a>
@endsection

<!-- <map id="map_object"name="planetmap"> -->
  <!-- avec/sans media -->
<!-- @foreach ($areas as $zone) 
{{$zone->are_coord}}
@if ( $zone-> has_media == 0 ) -->
<!-- <area id="{{ $zone->are_oid }}" shape="poly" coords="{{ $zone->are_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"FE2E2E","strokeWidth":2,"fillColor":"FE2E2E","fillOpacity":0.6}' data-style= "without-media" href="" > -->
<!-- @endif
  @if ( $zone-> has_media >= 1 ) -->
  <!-- <area id="{{ $zone->are_oid }}" shape="poly" coords="{{ $zone->are_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"0000ff","strokeWidth":2,"fillColor":"0000ff","fillOpacity":0.6}' data-style= "without-media" href="" > -->
<!-- @endif
  @endforeach -->
  <!-- </map> -->

  @section('extraJS')
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script>
  <script>
//init the map for highlighting
$('.map').maphilight();

$(document).ready(function(){
  $('area').each(function(){
    //   console.log($(this), 'ici');
    var data = $(this).data('maphilight');  
    $(this).data('maphilight', data).trigger('alwaysOn.maphilight');
    $(this).click(function(){
            //    console.log($(this))
            //    redirige vers ./area/{id}
          });
  });
});  

</script>
<script type="text/javascript">

  var tabMedias = {!! json_encode($medias->toArray()) !!};
  var tabAreas = {!! json_encode($areas->toArray()) !!};

  console.log(tabMedias);
  console.log(tabAreas);


  tabAreas.forEach(function(area){
    tabMedias.forEach(function(media){

      var mediaId = media.media_id;
      var zoneId = area.fk_media_id;

      if(mediaId === zoneId){

        console.log(mediaId);
        console.log(zoneId);

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