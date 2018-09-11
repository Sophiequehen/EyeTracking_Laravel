<?php
Auth::routes();
/*
|--------------------------------------------------------------------------
| [ACCUEIL] / [CONNEXION] / [LEGALMENTIONS]
|--------------------------------------------------------------------------
*/
// home | 3 last bd published
Route::get('/', 'HomeController@index')->name('home');
// page legalmentions | mentions légales
Route::get('/legalmentions', function () {
	return view('others.legal_mentions');
})->name('legalmentions');
//register
Route::get('/inscription', 'RoleController@index')->name('new-register');
//create user
Route::post('/user/store', 'UserController@store')->name('register-store');
//see user
Route::get('/user/index', 'UserController@index')->name('index-users');
//update user
Route::get('/user/update/{id}', 'UserController@edit')->name('update-user');
Route::post('/user/update/{id}', 'UserController@update');
/*
|--------------------------------------------------------------------------
| COMICS
|--------------------------------------------------------------------------
*/
/* ----------------[ CREATE COMICS ]---------------- */
//This is the form, and on submit the ::post is called
Route::get('/comics/create', 'ComicsController@create')->name('comics_create');
Route::post('/comics/store/{id}', 'ComicsController@store');
/* ----------------[ READ COMICS ]---------------- */
Route::get('/comics/index', 'ComicsController@index')->name('comics_index');
Route::get('/comics/show/{id}', 'ComicsController@show')->name('comics_show');
/* ----------------[ UPDATE COMICS ]---------------- */
//there's some html and css not reaching routes with parameters.
Route::get('/comics/update/{id}', 'ComicsController@edit')->name('comics_update');
Route::post('/comics/update/{id}', 'ComicsController@update');
/* ----------------[ DELETE COMICS ]---------------- */
//right now it's an input that then pass the comics' id  in $GET.
// /!\ Doesn't work if you have pages in your DB that are linked to it
// pas de confirmation/!\
Route::get('/comics/delete/{id}', 'ComicsController@destroy')->name('comic_delete');
/*
|--------------------------------------------------------------------------
| BOARD
|--------------------------------------------------------------------------
*/
/* ----------------[ CREATE BOARD ]---------------- */
// Ajouter page depuis idBD (clé étrangère fk_com_oid de 'pages')
// No link to this page. 
Route::get('/boards/create/{idBD}', function ($idBD) {
	return view('boards.create', ['idBD' => $idBD]);
}) -> name('addPage');
Route::post('/boards/store/{idBD}', 'BoardsController@store');
/* ----------------[ READ PAGES ]---------------- */
// Route::get('/boards/show/{idBD}/{idPage}', 'BoardsController@show')->name('board-show');
Route::get('/boards/edit/{idBD}/{idPage}', 'BoardsController@edit')->name('board-edit');
Route::get('/boards/fullscreen/{idBD}/{idPage}', 'BoardsController@read')->name('board-fullscreen');

/* ----------------[ UPDATE PAGES ]---------------- */
// not necessary
/* ----------------[ DELETE PAGES ]---------------- */
Route::get('/boards/delete/{idBoard}', 'BoardsController@destroy')->name('board-delete');
/*
|-----------------------------------------------------------------------
| MEDIAS
|-----------------------------------------------------------------------
*/
// /!\ pour upload des fichiers : consulter "try file uploading" dans le read me
/* ----------------[ READ MEDIAS ]---------------- */
Route::get('/medias/read', 'MediasController@index')->name('medias');
/* ----------------[ CREATE MEDIAS ]---------------- */
Route::get('/medias/create', 'MediasController@create')->name('medias_create');
Route::get('/medias/create-from-board/{idBD}/{idPage}', 'MediasController@createFromBoard')->name('medias_create_from_board');
/* ----------------[ UPLOAD MEDIAS ]---------------- */
Route::post('/medias/store', 'MediasController@store');
Route::post('/medias/storeFromBoard/{idBD}/{idPage}', 'MediasController@storeFromBoard');
/* ----------------[ DELETE MEDIAS ]---------------- */
//appellée par un bouton par media sur la page /medias
Route::get('/medias/delete/{id}', 'MediasController@delete')->name('medias_delete');
/* ----------------[ DESTROY MEDIAS ]---------------- */
Route::get('/medias/destroy/{name}', 'MediasController@destroy')->name('medias_destroy');
/* ----------------[ UPDATE MEDIAS ]---------------- */

/*
|--------------------------------------------------------------------------
| MAPPING
|--------------------------------------------------------------------------
*/
// /* ----------------[ CREATE AND STORE AREAS ]---------------- */
Route::get('/mapping/create/{idBD}/{idPage}', 'AreaController@create')->name('mapping_create');
Route::post('/mapping/store/{idBD}/{idPage}', 'AreaController@store');
// /* ----------------[ READ AREAS ]---------------- */
Route::get('/mapping/show/{id}', 'AreaController@show')->name('mapping_show');
// /* ----------------[ UPDATE AREAS ]---------------- */
Route::get('/mapping/update/{idPage}', 'AreaController@edit')->name('mapping_update');
Route::post('/mapping/update/{idPage}', 'AreaController@update');
/* ----------------[ DELETE MAPPING ]---------------- */
Route::get('/mapping/delete/{idArea}', 'AreaController@destroy')->name('mapping_delete');

//ajax
Route::post('/postajax','AjaxController@post');