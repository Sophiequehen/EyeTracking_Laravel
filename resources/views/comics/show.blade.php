@extends('layout.app')

@section('title')
BD - {{ $comic->comic_title }}
@endsection

@section('content')


<section class="page-titles">
	<h2>{{ $comic->comic_title }}</h2>
	<p>/</p>
	<div class="comic-presentation">
		<img class="comic-presentation-img" src="{{ $comic->comic_miniature_url }}">
		<div class="descriptif">
			<p class="title">Description</p>
			<p class="paragraph">{{ $comic->comic_description }}</p>
		</div>
	</div>

	<h2>Lire la Bande Dessinée</h2>
	<p>/</p>
</section>

<section class="boards-index">
	<div class="gallery-boards">

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