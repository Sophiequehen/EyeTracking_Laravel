@extends('layout.app')

@section('title')
À propos
@endsection

@section('content')
<div class="contain-header  legal-responsive">
    <div class="header-comic">
        <section class="page-titles">
            <h2>À propos</h2>
            <p>/</p>
        </section>

        <ul class="nav-comic legal">
            <li class="selected-tab" id="donnees">CONTACT</li>
            <li class="slash">/</li>
            <li id="propriete">MENTIONS LÉGALES</li>
            <li class="slash">/</li>
            <li id="publication">PRÉSENTATION</li>
        </ul>
    </div>
</div>

<div class="container legal">
    <div id="societe" class="societe">
        <p class="societe-nom">CALYXEN - Romaric Defrance</p>
        <div class="societe-infos">
            <div>
                <i class="material-icons">phone</i>
                <p class="societe-title">- Téléphone -</p>
                <p class="societe-phone">05 65 35 22 59</p>
            </div>
            <div>
                <i class="material-icons">smartphone</i>
                <p class="societe-title">- Portable -</p>
                <p class="societe-cellphone">06 15 41 60 43</p>
            </div>
            <div>
                <i class="material-icons down">location_on</i>
                <p class="societe-title">- Adresse -</p>
                <p class="societe-address">46 240 Montfaucon</p>
            </div>
            <div>
                <i class="material-icons down">mail</i>
                <p class="societe-title">- Email -</p>
                <p class="societe-mail">romaric@calyxen.com</p>
            </div>
        </div>
    </div>
</div>


<div id="intellectuelle" class="intellectuelle display-none">

    <p class="intellect-display">Éditeur :</p>

    <p class="nomargin">Calyxen</p>
    <p>Responsable publication: Romaric Defrance</p>

    <p class="intellect-display">Hébergeur :</p>

    <p class="nomargin">OVH</p>
    <p>2 rue Kellermann 59100 Roubaix France</p>

    <p class="intellect-display">Framework utilisé :</p>
    <p>Laravel</p>

    <p class="intellect-display">Crédits :</p>
    <p class="nomargin">Site développé par Sophie Quehen</p>
    <p>dans le cadre de la formation Simplon</p>

</div>

<div class="container-hebergement">
    <div id="hebergement" class="hebergement display-none">
        Ce site est un support pour les ateliers de création animés par Romaric Defrance et Jérôme Piot. Le but est de réaliser une ou plusieurs planches de bande dessinée et d'imaginer un scénario pour que la narration évolue avec des sons ajoutés par la suite. Une fois leur planche terminée, elle est scannée puis des zones sont choisies et agrémentées de sons que les groupes auront sélectionnés ou enregistrés eux-mêmes. À la fin de l'atelier, leurs planches sont exposées et les sons sont lancés grâce au regard du spectateur par le biais du dispositif d'Eyetracking (capteur de regard).
    </div>
</div>

@endsection