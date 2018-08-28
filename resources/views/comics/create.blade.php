@extends('layout.app')

@section('title')
Ajouter Bande dessinée
@endsection

@section('content')
<div class="container modify">

    <form method="POST" enctype="multipart/form-data" action="{{ action('ComicsController@store', [Auth::user()->id] )}}" >
        @csrf
        <section class="page-titles">
            <h2>Ajouter une Bande Dessinée</h2>
            <p>/</p>
        </section>
        @csrf
        <label for="titre">Titre de la Bande Dessinée :</label>
        <input type="text" id="titre" name="titre"  required/>

        <label for="editeur"> Nom de l'éditeur :</label>
        <input type="text" id="editeur" name="editeur" placeholder="Si la BD existe déjà"/>

        <label for="auteur">Nom de l'auteur :</label>
        <input type="text" id="auteur" name="auteur" placeholder="Si la BD existe déjà"/>

        <label for="auteur">Description :</label>
        <textarea type="text" id="description" name="description" required></textarea>

        <label for="auteur">Membres du groupes :</label>
        <input type="text" id="membre" name="membre" placeholder="ex : Paul Auchon, Fred Riksen, . . ." required />

        <p class="label-miniature">Miniature (600px/850px) :</p>
        <div class="contain-miniature">
            <label class="label-browse" id="label-browse" for="miniature">Parcourir . . .</label>
            <input class="inputfile" type="file" id="miniature" name="miniature" />
            <span id="fileuploadurl"></span>
        </div>

        <input class="btn-outline" type="submit" value="AJOUTER" id="ajouter"/>

    </form>
</div>
@endsection

