@extends('layout.app')

@section('title')
BD - {{ $comic->comic_title }}
@endsection

@section('content')


<section class="page-titles">
	<h2>{{ $comic->comic_title }}</h2>
	<p>/</p>
	<div class="comic-presentation">
		<img class="comic-presentation-img comic-show-responsive" src="{{ $comic->comic_miniature_url }}">
		<div class="descriptif responsive">
			<p class="title">Description</p>
			<p class="paragraph">{{ $comic->comic_description }}</p>
			<p class="members">{{ $comic->comic_member }}</p>
		</div>
	</div>

	<h2 class="comic-show-responsive">Lire la Bande Dessinée</h2>
	<p class="comic-show-responsive">/</p>
</section>

<section class="boards-index comic-show-responsive">
	<div class="gallery-boards">
		@if(count($boards) == 0)
		<p>Pas encore de planche</p>
		@endif
		@foreach($boards as $board)
		<div class="small-card">
			<a href="{{ route('board-edit',[$comic->comic_id, $board->board_id]) }}">
				<img src="{{ $board->board_image }}">
				<p>Planche {{ $board->board_number }}</p>
			</a>
		</div>
		@endforeach
	</div>
</section>


@endsection