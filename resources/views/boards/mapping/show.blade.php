@extends('layout.app')

@section('title')
Voir les zones
@endsection

@section('content')
<div class="container modify">
  <div class="card-body area">

    <img id="background_map" src="/img/plancheBD.JPG" alt="Planets" usemap="#planetmap" class="map">
    <map id="map_object"name="planetmap">

      <!-- avec/sans media -->
      @foreach ($areas as $zone) 

      <area id="{{ $zone->area_id }}" shape="poly" coords="{{ $zone->area_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"0000ff","strokeWidth":2,"fillColor":"0000ff","fillOpacity":0.6}' data-style= "without-media" href="">

      @endforeach
    </map>  

  </div>
</div>

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



            @endsection


            @section('extraJS')
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
            <script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script>

            <script  >


// //init the map for highlighting
$('.map').maphilight();


$(document).ready(function()
{
  $('area').each(function() {

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
@endsection