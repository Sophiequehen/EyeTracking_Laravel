@extends('layout.app')
@section('title')

Liste des médias

Medias

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
	<div class="modal-content alert-warning">
		<div class="modal-header">
			<h4 class="alert-heading col-12">Suppression en cours</h4>
		</div>
		<p>
			Voulez-vous vraiment supprimer le media suivant :
			{{ $message }} ?
		</p>
	</br>
	<div class="mb-0">
		<a href="{{ route('medias_destroy', ['name' => $message ]) }}" class="btn btn-danger">Supprimer</a>
		<a href="{{ route('medias') }}" class="btn btn-warning">Annuler</a>
	</div>
	<div class="modal-footer">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
					<p class="card-text">Type de fichier : {{ $media->media_type }}</p>
					<a href="{{ route('medias_delete', ['id' => $media->media_id]) }}" class="btn-catalogue">Supprimer</a>
				</div>
			</article>


			@endforeach


		</div>

	</section>


	@endsection