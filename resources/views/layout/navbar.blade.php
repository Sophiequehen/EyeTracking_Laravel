		<div id="logo-eyes">
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
		</div>
		<div id="navbar">
			<a href="{{ url('/') }}">Accueil</a>
			<a href="{{ route('comics_index') }}">Catalogue</a>
			@if(Auth::user()->fk_role_id === 1 || Auth::user()->fk_role_id === 3) 
			<a href="{{ route('medias') }}">Médias</a>
			@endif
			<a href="{{ url('/legalmentions') }}">À propos</a>
		</div>

