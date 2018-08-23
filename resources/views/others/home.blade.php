@extends('layout.app')

@section('title')
Accueil
@endsection

@section('content')

<!-- <section class="page-titles">
    <h2>Reprendre la lecture</h2>
    <p>/</p>
</section>
<section class="containers_catalog">
-->
<!-- REQUEST TO DISPLAY THE ALREADY READED COMICS ORGANISED BY ASCENDING ORDER -->
<!-- @foreach ($comics as $comic) -->
        <!-- <article class="comics_catalog">
            <a href="{{ route('comics_show', $comic->comic_id) }}">
                <img class="img_catalog" src="{{ $comic->comic_miniature_url }}" alt="cover">
            </a>
            <div class="infos_catalog">
                <ul>
                    <li>{{$comic->comic_title}}</li>
                    <li>{{$comic->comic_author}}</li>
                    <li>{{$comic->comic_publisher}}</li>
                </ul>
            </div>

        </article> -->
        <!-- @endforeach -->
        <!-- </section> -->

        <section class="page-titles">
            <h2>Dernières BD mises en ligne</h2>
            <p>/</p>
        </section>
        <section class="containers_catalog">
            @foreach ($comics_last as $comic)
            <article class="comics_catalog">
                <a href="{{ route('comics_show', $comic->comic_id) }}">
                    <img class="img_catalog" src="{{ $comic->comic_miniature_url }}" alt="cover">
                </a>
                <div class="infos_catalog">
                    <ul>
                        <li>{{$comic->comic_title}}</li>
                        <li>{{$comic->comic_author}}</li>
                        <li>{{$comic->comic_publisher}}</li>
                    </ul>
                </div> 
                <div class="read_edit_catalog">
                  @if(Auth::check() && $comic->fk_user_id === Auth::user()->id || Auth::check() && Auth::user()->fk_role_id === 3) 
                  <a  href="{{ route ('comics_update', $comic->comic_id ) }}" id="button_edit_catalog"><button class="btn-catalogue">Modifier</button></a>
                  @endif 
              </div>
          </article>
          @endforeach
      </section>  
      <!-- TO SEE BD CREATED BY THE CONNECTED ADMIN -->
      <section class="page-titles">
        <h2>Vos bandes dessinées</h2>
        <p>/</p>
    </section>
    <section class="containers_catalog">
        @foreach ($comics_all as $comic)
        @if(Auth::check() && $comic->fk_user_id === Auth::user()->id) 
        <article class="comics_catalog">
            <a href="{{ route('comics_show', $comic->comic_id) }}">
                <img class="img_catalog" src="{{ $comic->comic_miniature_url }}" alt="cover">
            </a>
            <div class="infos_catalog">
                <ul>
                    <li>{{$comic->comic_title}}</li>
                    <li>{{$comic->comic_author}}</li>
                    <li>{{$comic->comic_publisher}}</li>
                </ul>
            </div> 
            <div class="read_edit_catalog">
              @if(Auth::check() && $comic->fk_user_id === Auth::user()->id || Auth::check() && Auth::user()->fk_role_id === 3) 
              <a  href="{{ route ('comics_update', $comic->comic_id ) }}" id="button_edit_catalog"><button class="btn-catalogue">Modifier</button></a>
              @endif 
          </div>
      </article>
      @endif
      @endforeach
  </section>
  @endsection