@extends('layout.app')

@section('title')
Créer une zone
@endsection

@section('content')
<div class="container modify">

    @php if(isset($result)) echo $result; @endphp

    <div class="card-body area">
        <form class="area-form" method="post" action=" {{action('AreaController@store', [$board->board_id])}}" enctype="multipart/form-data">
            @csrf

            <div class="area-form-manage">
                <div>
                    <div id="form-tps" >
                        <label for="tpsDeclenchement">Temps de déclenchement :</label>
                        <input type="number" name="trigger" class="form-control" id="tpsDeclenchement" value="1">
                        <p>Millisecondes</p>
                    </div>
                </div>
                
                <!-- if file does not comply / do not pass validations -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- if the sending in the db is successful. the two possible $ results are modifiable in mediascontroller line 45 & 50 -->

                <select name="dataType" required>
                    <option selected disabled>Sélectionner un média</option> 
                    @foreach($medias as $media)
                    <option value="{{ $media->media_id }}">{{ $media->media_filename }}</option>
                    @endforeach
                </select>

                <input type="submit" class="btn-outline" value="Valider"/>
            </div>

            <div id="imgModif">
                <div class="see-all">
                    <a class="" href="{{ route('mapping_show',[$board->board_id]) }}"><i class="material-icons">visibility</i><span>Voir toutes les zones</span></a>
                </div>
                <div class="page">
                    <textarea name="coords1" class="canvas-area input-xxlarge" placeholder="Shape Coordinates" data-image-url="{{ $board->board_image }}" style="display: none;">
                    </textarea>
                </div>

                <!-- To see all areas on another board but scaling doesn't work -->
                <!-- <img id="background_map" src="{{ $board->board_image }}" alt="Planets" usemap="#planetmap" class="map">
                <map id="map_object"name="planetmap">
                  @foreach ($areas as $zone) 
                  <area id="{{ $zone->area_id }}" shape="poly" coords="{{ $zone->area_coord }}" data-maphilight='{"alwaysOn": true,"strokeColor":"0000ff","strokeWidth":2,"fillColor":"0000ff","fillOpacity":0.6}' data-style= "without-media" href="">
                  @endforeach
              </map>  -->
          </div>
      </form>

  </div>
</div>
@endsection



@section('extraJS')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.js"></script>
<script src={{ asset("js/canvasAreaDraw.js") }}></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="http://davidlynch.org/projects/maphilight/jquery.maphilight.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.js"></script>
<script>
// //init the map for highlighting
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
<script>
//To scale areas to their image
imageMapResize();
</script>
@endsection
