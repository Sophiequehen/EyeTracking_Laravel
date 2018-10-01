@extends('layout.app')
@section('title')

Liste des médias

@endsection
@section('content')

<!-- ALERT UPON ADDING MEDIA -->
@if ($message = Session::get('add'))
<div class="alert alert-success alert-dismissible" role="alert">
	{{ $message }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

<!-- ALERT UPON MEDIA CREATION FAILURE -->
@if ($message = Session::get('duplicate'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	{{ $message }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

<section id="sectionListMedia">

	<!-- CONFIRMATION ALERT UPON MEDIA DELETION -->
	@if ($message = Session::get('alert_delete'))
	<div class="modal-delete-media">
		<p>Êtes-vous sûr(e) de vouloir supprimer le media :
		{{ $message }} ?</p>
		<div class="modal-delete-buttons">
			<div class="grp-delete-buttons">
				<a id="cancel-delete-board" href="{{ route('medias') }}">ANNULER</a>
			</div>
			<div id="delete-board" class="grp-delete-buttons">
				<a href="{{ route('medias_destroy', ['name' => $message ]) }}">SUPPRIMER</a>
			</div>
		</div>
	</div>
	@endif
	<section class="page-titles">
		<h2>Liste des Médias</h2>
		<p>/</p>
	</section>

	<a href="/medias/create" id="addMedia" class="btn-add-bd" href="{{route('comics_create')}}"><i class="material-icons">add</i><span>Ajouter un média</span></a>

	<!-- missing the foreach to retrieve each media in the DB. Only one <div col-s> will be needed in the foreach -->

		<div class="row justify-content-center">

			@foreach ($medias as $media)
			
			<article class="comics_catalog">

				@if ($media->media_type == 'img')
				<img class="card-img-top " src="{{ $media->media_path }}" alt="Miniature">
				@endif

				@if ($media->media_type == 'video')
				<!-- may need to do depending on video types (attribute type = "") -->
				<img class="card-img-top" src="/img/video.png" alt="Miniature">
				@endif

				@if ($media->media_type == 'son')
				<img class="card-img-top " src="/img/sound.png" alt="Miniature">
				@endif

				<div class="card-body">
					<!-- <p class="card-filename">Nom du fichier :</p> -->
					<h5 class="card-title">{{ $media->media_filename }}</h5>
					@foreach ($users as $user)
					@if($media->fk_user_id === $user->id)
					<p class="card-text medias">Ajouté par</p>
					<p class="card-text medias">{{ $user->name }}</p>
					@endif
					@endforeach

					@if($media->media_use === 1)
					<p class="card-text medias use">Utilisé</p>
					@else
					<p class="card-text medias notuse">Non utilisé</p>
					@endif

					@if(Auth::check() && Auth::user()->fk_role_id === 3 && $media->media_use === 0)
					<a href="{{ route('medias_delete', ['id' => $media->media_id]) }}" class="btn-catalogue medias">Supprimer</a>
					@elseif(Auth::check() && Auth::user()->fk_role_id === 3 && $media->media_use === 1)
					<a class="btn-catalogue medias used">Supprimer</a>
					@endif
				</div>
			</article>

			@endforeach
		</div>
		<div class="medias-pagination">
			{{ $medias->links() }}
		</div>
		@if(Auth::check() && Auth::user()->fk_role_id === 3 || Auth::check() && Auth::user()->fk_role_id === 1) 
		<section class="page-titles">
			<h2>Vos Médias</h2>
			<p>/</p>
		</section>

		<div class="row justify-content-center">

			@foreach ($medias_all as $media)
			@if(Auth::check() && Auth::user()->id === $media->fk_user_id)
			@php ($media_by = true)
			<article class="comics_catalog">

				@if ($media->media_type == 'img')
				<img class="card-img-top " src="{{ $media->media_path }}" alt="Miniature">
				@endif

				@if ($media->media_type == 'video')
				<!-- may need to do depending on video types (attribute type = "") -->
				<img class="card-img-top" src="/img/video.png" alt="Miniature">
				@endif

				@if ($media->media_type == 'son')
				<img class="card-img-top " src="/img/sound.png" alt="Miniature">
				@endif

				<div class="card-body">
					<!-- <p class="card-filename">Nom du fichier :</p> -->
					<h5 class="card-title">{{ $media->media_filename }}</h5>
					@foreach ($users as $user)
					@if($media->fk_user_id === $user->id)
					<p class="card-text medias">Ajouté par</p>
					<p class="card-text medias">{{ $user->name }}</p>
					@endif
					@endforeach

					@if($media->media_use === 1)
					<p class="card-text medias use">Utilisé</p>
					@else
					<p class="card-text medias notuse">Non utilisé</p>
					@endif

					@if(Auth::check() && Auth::user()->fk_role_id === 3 && $media->media_use === 0)
					<a href="{{ route('medias_delete', ['id' => $media->media_id]) }}" class="btn-catalogue medias">Supprimer</a>
					@elseif(Auth::check() && Auth::user()->fk_role_id === 3 && $media->media_use === 1)
					<a class="btn-catalogue medias used">Supprimer</a>
					@endif
				</div>
			</article>
			@endif
			@endforeach
			@if($media_by == false)     
			<p class="notyet">Vous n'avez pas encore ajouté de média</p>
			@endif
		</div>
		@endif

	</section>


	@endsection