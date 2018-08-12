<div id="navbar">
	<div class='eyes-logo-container'>
		<div class="left">
			<div class="lashes"></div>
			<div class='eye'></div>
			<div class='eyeclosed'></div>
		</div>
		<div class="right">
			<div class="lashes"></div>
			<div class='eye'></div>
			<div class='eyeclosed'></div>
		</div>
	</div>
	<a href="{{ url('/') }}">Accueil</a>
	<a href="{{ route('comics_index') }}">Catalogue</a>
	<a href="{{ route('medias') }}">Médias</a>
	<a href="{{ url('/legalmentions') }}">Mentions Légales</a>
	{{-- @if (Auth::check())
		<a href="{{ url('/medias') }}">Médias</a>
		@endif --}}
	</div>

