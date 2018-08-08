@extends('layout.app')

@section('title')
{{ $comic->comic_title }} / Planche {{ $board->board_number }}
@endsection


@section('content')
<section class="page-titles">
	<h2>{{ $comic->comic_title }} - Planches n° {{ $board->board_number }}</h2>
	<p>/</p>
</section>
<div class="board-view">
	<img src="{{ $board->board_image }}">
</div>
<a class="btn-add-bd" href="{{ route('mapping_create',[$board->board_id]) }}"><i class="material-icons">add</i><span>Ajouter des zones</span></a>

@endsection


