@extends('layout.app')

@section('title')
Modifier Bande dessinée
@endsection

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

@section('content')

@if ($message = Session::get('add'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>

@endif
<div class="contain-header">
    <div class="header-comic comic-update-responsive">
        <section class="page-titles">
            <h2>Modifier la Bande Dessinée</h2>
            <p>/</p>
        </section>

        <ul class="nav-comic">
            <li class="selected-tab" id="comic-infos">INFORMATIONS</li>
            <li class="slash">/</li>
            <li id="comic-add">AJOUTER UNE PLANCHE</li>
            <li class="slash">/</li>
            <li id="comic-liste">LISTE DES PLANCHES</li>
        </ul>
    </div>
</div>

<div class="container modify comic-update-responsive">
    <form id="informations" method="POST" enctype="multipart/form-data" action="{{ action('ComicsController@update', [$comic->comic_id]) }}">
        @csrf

        <label for="titre">Titre de la Bande Dessinée :</label>
        <input type="text" id="titre" name="titre" value="{{$comic->comic_title}}"/>
        
        <label for="editeur"> Nom de l'éditeur :</label>
        <input type="text" id="editeur" name="editeur" value="{{$comic->comic_publisher}}"/>

        <label for="auteur">Nom de l'auteur :</label>
        <input type="text" id="auteur" name="auteur" value="{{$comic->comic_author}}"/>

        <label for="description">Description :</label>
        <textarea type="text" id="description" name="description">{{$comic->comic_description}}</textarea>

        <label for="membre">Membres du groupes :</label>
        <input type="text" id="membre" name="membre" value="{{$comic->comic_member}}"/>

        <p class="label-miniature">Miniature (600px/850px) :</p>
        <div class="contain-miniature">
            <label class="label-browse" id="label-browse" for="miniature">Parcourir . . .</label>
            <input class="inputfile" type="file" id="miniature" name="miniature" />
            <span id="fileuploadurl">{{$comic->comic_miniature_url}}</span>
        </div>

        @if(Auth::check() && Auth::user()->fk_role_id === 3) 
        <div class="material-toggle">
            @if($comic->comic_publication === 1)
            <input id="publication" name="publication" type="checkbox" checked="checked" />
            @else
            <input id="publication" name="publication" type="checkbox" />
            @endif
            <label for="publication" class="label-main-color"></label>
            <p class="label-publication">Publication On/Off</p>
        </div>
        @endif
        <div class="update-buttons">
            <input class="btn-outline" type="submit" value="MODIFIER"/>
            <a href="{{route('comic_delete',[$comic->comic_id])}}"><div class="btn-outline delete">SUPPRIMER LA BANDE DESSINÉE</div></a>
        </div>
    </form>


    <form class="display-none" id="add-planche" method="POST" enctype="multipart/form-data" action="{{ action('BoardsController@store', [$comic->comic_id]) }}">
        @csrf

        <div>
            <label for="numero-board">Numéro de la planche :</label>
            @if($lastpage !== 0)
            <input type="number" id="numero-board" name="numero-board" value="{{ $lastpage->board_number + 1 }}"/>
            @else
            <input type="number" id="numero-board" name="numero-board" value="1"/>
            @endif

            <p class="label-miniature">Image de la planche (600px/850px) :</p>
            <div class="contain-miniature">
                <label class="label-browse" id="label-board-image" for="board-image">Parcourir . . .</label>
                <input class="inputfile" type="file" accept="image/*" id="board-image" name="board-image" />
                <span id="boarduploadurl"></span>
            </div>        
        </div>
        <input class="btn-outline" type="submit" value="AJOUTER" />
    </form>

    
    <div id="liste-planches" class="gallery-boards display-none">

        <div class="modal-delete-board">
            <p>Êtes-vous sûr(e) de vouloir supprimer cette planche et toutes les zones qui lui sont associées ?</p>
            <div class="modal-delete-buttons">
                <div class="grp-delete-buttons"><a id="cancel-delete-board" href="">ANNULER</a></div>
                <div id="delete-board" class="grp-delete-buttons"><a href="">SUPPRIMER</a></div>
            </div>
        </div>

        <div class="gallery-boards">
            @foreach($boards as $board)
            <div class="small-card">
                <a href="{{ route('board-edit',[$comic->comic_id, $board->board_id]) }}">
                    <img src="{{ $board->board_image }}">
                    <p>Planche {{ $board->board_number }}</p>
                    <!-- @if(Auth::check() && $comic->fk_user_id === Auth::user()->id || Auth::check() && Auth::user()->fk_role_id === 3) 
                    <a href="" class="delete-liste-planches"><button id="{{ $board->board_id }}">Supprimer</button></a>
                    @endif -->
                </a>
            </div>
            @endforeach
        </div>
        
        

    </div>
</div>
@endsection

@section('extraJS')
<script type="text/javascript">

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('.delete-liste-planches').each(function(){
        var idBoard = $(this)[0].children[0].attributes.id.value;
        $(this).click(function(event){
            event.preventDefault();
            console.log(idBoard);
            $('.modal-delete-board').toggle();
            $('#delete-board').html('<a href="/boards/delete/'+idBoard+'">SUPPRIMER</a>');
        })
    });

    $('#cancel-delete-board').click(function(event){
        event.preventDefault();
        $('.modal-delete-board').toggle();
    });
</script>
@endsection