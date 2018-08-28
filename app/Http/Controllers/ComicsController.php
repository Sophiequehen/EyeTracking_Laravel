<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Comic;
use App\Board;
use App\User;


/*
|--------------------------------------------------------------------------
| Controller pour les COMICS
|--------------------------------------------------------------------------
*/


class ComicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $comics = Comic::all()->where('comic_publication',1); // a remettre quand on aura la connexion
        $users = User::all();
        $comics = Comic::all();

        return view('comics.index', ['comics' => $comics, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // [!!] OLD public function "add"(Request $request)
    public function create(Request $request)
    {
        return view('comics.create') ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $comic = Comic::all()->where('comic_id', $id)->first();  
       $boards = Board::all()->where('fk_comic_id',$id);
       return view('comics.show', ['comic' => $comic,'boards' => $boards]);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //store dans le dossier public, le fichier 'miniature'
        $originalName = $request->file('miniature')->getClientOriginalName();
        $pathstart = $request->file('miniature')->storeAs('public/miniatures/', $originalName);
        
        //enlève le public devant
        $path = substr($pathstart, 7);
        
        $comics = new Comic;
        $comics-> fk_user_id = $id;
        $comics-> comic_title = request('titre');
        $comics-> comic_author = request('auteur');
        $comics-> comic_publisher = request('editeur');
        $comics-> comic_description = request('description');
        $comics-> comic_miniature_url = '/storage/miniatures/'.$originalName;


        // verification pour éviter la duplication de comic
        $verif_comic = Comic::all()->where('comic_title',$comics-> comic_title)
        ->where('comic_author',$comics-> comic_author)
        ->where('comic_publisher',$comics-> comic_publisher);

        if(count($verif_comic)>0){
            return redirect()->route('comics_index')->with('duplicate','BD déjà existante');
        }else{
            $comics->save();
            return redirect()->route('comics_index')->with('add','BD ajoutée');
        }
        
        
    }

    
    // Récupère une Bande-Dessinée unique necéssaire pour le update
    public function edit($id)
    {
        $users = User::all();
        $comic = Comic::all()->where('comic_id', $id)->first();
        $boards = Board::all()->where('fk_comic_id',$id);
        $lastpage = Board::orderby('board_number', 'desc')->where('fk_comic_id',$id)->first();

        return view('comics.update', ['comic' => $comic,'boards' => $boards, 'lastpage' => $lastpage, 'users' => $users]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {


        $comic = Comic::where('comic_id', $id)->first();
        $comic-> comic_title = request('titre');
        $comic-> comic_author = request('auteur');
        $comic-> comic_publisher = request('editeur');
        $comic-> comic_description = request('description');


        //publication
        if (request('publication') === 'on') {
            $comic-> comic_publication = true;
        }else{
            $comic-> comic_publication = false;
        }
        

        if(request('miniature')){ // met à jour que si on change la miniature
            //suppression de la miniature actuelle
            $path_delete = substr($comic->comic_miniature_url, 9);
            Storage::delete('public/'.$path_delete);
            //upload de la nouvelle miniature
            $originalName = request('miniature')->getClientOriginalName();
            $pathstart = request('miniature')->storeAs('public/miniatures/', $originalName);
            $path = substr($pathstart, 7);
            
            $comic-> comic_miniature_url = '/storage/miniatures/'.$originalName;
        }

        $comic->save();

        return redirect()->route('comics_index')->with('update','BD mise à jour');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // Supprime les miniatures de la DB et du Storage
    public function destroy(Request $request, $id)
    {
        $comic = Comic::where('comic_id', $id)->first();
        $path_delete = substr($comic->comic_miniature_url, 9);

        Storage::delete('public/'.$path_delete);
        Comic::where('comic_id', $id)->delete();

        return redirect()->route('comics_index')->with('delete','BD supprimée');
        

    }
}
