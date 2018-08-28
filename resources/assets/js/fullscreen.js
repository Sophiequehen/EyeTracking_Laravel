if(document.URL.includes('fullscreen/')){
	var content = document.getElementById('content');
	var navAuth = document.getElementById('navbar-authentification');
	var logo = document.getElementById('logo-eyes');
	var navbar = document.getElementById('navbar');
	var copyright = document.getElementById('copyright');

	navAuth.classList.add('display-none');
	logo.classList.add('display-none');
	navbar.classList.add('display-none');
	copyright.classList.add('display-none');
	content.classList.add('content-fullscreen');
}