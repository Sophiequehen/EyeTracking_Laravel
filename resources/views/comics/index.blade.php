@extends('layout.app')

@section('title')
Catalogue
@endsection

@section('content')

<!-- CREATING A CONFIRMATION ALERT ADDING AND DELETING COMIC -->
@if ($message = Session::get('add'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if ($message = Session::get('update'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if ($message = Session::get('duplicate'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if ($message = Session::get('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  {{ $message }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<section class="page-titles">
  <h2>Catalogue</h2>
  <p>/</p>
</section>

<section class="containers_catalog">

  <!-- HERE THE IF FOR ADMIN + ADD BUTTON -->
  @if(Auth::user()->fk_role_id === 1 || Auth::user()->fk_role_id === 3) 
  <a class="btn-add-bd" href="{{route('comics_create')}}"><i class="material-icons">add</i><span>Ajouter une bande dessinée</span></a>
  @endif

  <!-- REQUEST TO DISPLAY ALREADY READED COMICS ORGANISED BY ASCENDING ORDER -->

  @foreach ($comics as $comic)
  <!-- IF USER IS SUPERADMIN, CAN SEE ALL BD, PUBLISHED OR NOT-->
  @if(Auth::user()->fk_role_id === 3)
  <article class="comics_catalog">
    <a href="{{ route('comics_show', $comic->comic_id) }}">
      @if($comic->comic_publication === 1)
      <img class="img_catalog" src="{{$comic->comic_miniature_url}}" alt="cover">
      @else
      <p class="message-card">Non publiée</p>
      <img class="img_catalog unpublished" src="{{$comic->comic_miniature_url}}" alt="cover">
      @endif
    </a>
    <div class="infos_catalog">
      <ul>
        <li>{{$comic->comic_title}}</li>
        <li>{{$comic->comic_author}}</li>
        <!-- <li>{{$comic->comic_publisher}}</li> -->
        @foreach ($users as $user)
        @if($user->id === $comic->fk_user_id)
        <li>Ajoutée par {{ $user->name }}</li>  
        @endif 
        @endforeach    
      </ul>
    </div>
    <div class="read_edit_catalog">
      <a  href="{{ route ('comics_update', $comic->comic_id ) }}" id="button_edit_catalog"><button class="btn-catalogue">Modifier</button></a>
    </div>
  </article>


  <!-- IF USER IS ADMIN, CAN SEE ALL PUBLISHED BD, AND ONLY HIS UNPUBLISHED BD-->
  @elseif(Auth::user()->fk_role_id === 1 && $comic->comic_publication === 1 || Auth::user()->fk_role_id === 1 && $comic->fk_user_id === Auth::user()->id)
  <article class="comics_catalog">
    <a href="{{ route('comics_show', $comic->comic_id) }}">
      @if($comic->comic_publication === 1)
      <img class="img_catalog" src="{{$comic->comic_miniature_url}}" alt="cover">
      @else
      <p class="message-card">Non publiée</p>
      <img class="img_catalog unpublished" src="{{$comic->comic_miniature_url}}" alt="cover">
      @endif
    </a>
    <div class="infos_catalog">
      <ul>
        <li>{{$comic->comic_title}}</li>
        <li>{{$comic->comic_author}}</li>
        <!-- <li>{{$comic->comic_publisher}}</li> -->
        @foreach ($users as $user)
        @if($user->id === $comic->fk_user_id)
        <li>Ajoutée par {{ $user->name }}</li>  
        @endif 
        @endforeach    
      </ul>
    </div>
    <div class="read_edit_catalog">
      @if($comic->fk_user_id === Auth::user()->id) 
      <a  href="{{ route ('comics_update', $comic->comic_id ) }}" id="button_edit_catalog"><button class="btn-catalogue">Modifier</button></a>
      @endif 
    </div>
  </article>

  <!-- IF USER IS READER, CAN ONLY SEE PUBLISHED BD-->
  @elseif(Auth::user()->fk_role_id === 2 && $comic->comic_publication === 1)
  <article class="comics_catalog">
    <a href="{{ route('comics_show', $comic->comic_id) }}">
      <img class="img_catalog" src="{{$comic->comic_miniature_url}}" alt="cover">
    </a>
    <div class="infos_catalog">
      <ul>
        <li>{{$comic->comic_title}}</li>
        <li>{{$comic->comic_author}}</li>
        <!-- <li>{{$comic->comic_publisher}}</li> -->
        @foreach ($users as $user)
        @if($user->id === $comic->fk_user_id)
        <li>Ajoutée par {{ $user->name }}</li>  
        @endif 
        @endforeach    
      </ul>
    </div>
    <div class="read_edit_catalog">
    </div>
  </article>
  @endif
  @endforeach


</section>  
<div class="nav_catalog">
  <a><button class="btn-pagination">< Previous</button></a>
  <a><button class="btn-pagination">Next ></button></a>
</div>
@endsection