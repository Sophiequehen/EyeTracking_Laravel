@extends('layout.app')

@section('title')
    Catalogue
@endsection

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

@section('content')

    <section class="containers_catalog">
        <!-- ICI LE IF POUR L'ADMIN + BOUTON AJOUTER -->
        <a id="ajouter_catalog" href="{{route('ajouter-bd')}}"><i class="material-icons catalogue">add_circle_outline</i></a>

        <!-- REQUÊTE POUR AFFICHER LES BD DÉJÀ LUES CLASSÉES PAR ORDRE CROISSANT -->

        @foreach ($comics as $comic)
            <article class="comics_catalog">
                <img class="img_catalog" src="/bd.jpg" alt="cover">
                <div class="infos_catalog">
                    <ul>
                        <li>{{$comic->com_title}}</li>
                        <li>{{$comic->com_author}}</li>
                        <li>{{$comic->com_publisher}}</li>
                        <li>{{$comic->com_timestamp}}</li>
                    </ul>
                    <div class="read_edit_catalog">
                        <!-- ICI LE IF POUR L'ADMIN + BOUTON MODIFIER -->
                        <a href="{{route('update-bd/',[$comic->com_oid])}}"><button class="buttons" id="button_edit_catalog">Modifier</button></a>
                        @foreach($pages as $page)
                        <a href="{{route('showPage',[$comic->com_oid, $page->pag_number])}}"><button class="buttons">Lire</button></a>
                        @endforeach
                    </div>
                </div>
            </article>
        @endforeach
    </section>  
    <div class="nav_catalog">
        <a><button class="buttons_catalog">Previous</button></a>
        <a><button class="buttons_catalog">Next</button></a>
    </div>
@endsection