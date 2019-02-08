<?php

namespace App\Http\Controllers;

// Modules nécessaires pour gestion des erreurs et du storage
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Board;
use App\Comic;
use App\Area; 
use App\Media;
use App\User;


/*
|--------------------------------------------------------------------------
| Controller pour les PAGES des BD
|--------------------------------------------------------------------------
*/

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function read($idBD, $idPage)
    {
        $users = User::all();
        $comic = Comic::all()->where('comic_id', $idBD)->first();  
        $board = Board::all()->where('board_id',$idPage)->first();
        $medias = Media::all();
        $areas = Area::all()->where('fk_board_id', $idPage); 

        $allboards = Board::all()->where('fk_comic_id', $idBD);
        $nextboard = Board::all()->where('fk_comic_id', $idBD)->where('board_number', $board->board_number + 1)->first();
        $previousboard = Board::all()->where('fk_comic_id', $idBD)->where('board_number', $board->board_number - 1)->first();

        return view('boards.fullscreen', ['comic' => $comic, 'medias' => $medias, 'areas' => $areas, 'board' => $board, 'users' => $users, 'allboards' => $allboards, 'nextboard' => $nextboard, 'previousboard' => $previousboard]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($idBD,$idPage)
    {
        $comic = Comic::all()->where('comic_id', $idBD)->first();  
        $board = Board::all()->where('board_id',$idPage)->first();
        return view('boards.show', ['comic' => $comic,'board' => $board]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idBD, Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($idBD,Request $request)
    {
        $validatedData = $request->validate(['board-image' => 'required|image']); // Vérifie que le fichier uploadé est bien une image.
        $numeroPage = request('numero-board');

        // try-catch de la requête
        try {
           // récupère le nom du fichier uploadé
            $originalName = $request->file('board-image')->getClientOriginalName();
            $completePath = $request->file('board-image')->storeAs('public/boards/', $originalName);

            // envoi du path du fichier, du numéro de la page et de l'id de la bd correspondante dans la table 'pages'

            $board = new Board;

            $board-> board_image = '/storage/boards/'.$originalName;
            $board-> board_number = $numeroPage;
            $board-> fk_comic_id = $idBD;
            
            $board->save();

            $message = "Page {$numeroPage} ajoutée";
        } catch (QueryException $e) { // affiche une erreur si le fichier est en doublon
            $error_code = $e->errorInfo[1];
             if($error_code == 1062){ // 1062 est le code d'erreur pour un duplicate sur col definie en unique
             $message = "La page {$numeroPage} existe déjà";
         }
            if($error_code == 1452){ // 1452 est le code d'erreur généré lorque l'id de la BDn'existe pas
            
            $message = "La BD numéro {$idBD} n'existe pas";
        }
    }

        // redirection sur la même page
    return redirect()->back()->with('add', $message);
}



    /**
     * Show the form for editing the specified resource.
          * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idBD,$idPage)
    {
        $users = User::all();
        $comic = Comic::all()->where('comic_id', $idBD)->first();  
        $board = Board::all()->where('board_id',$idPage)->first();
        $allboards = Board::all()->where('fk_comic_id', $idBD);
        $nextboard = Board::all()->where('fk_comic_id', $idBD)->where('board_number', $board->board_number + 1)->first();
        $previousboard = Board::all()->where('fk_comic_id', $idBD)->where('board_number', $board->board_number - 1)->first();
        $medias = Media::all();
        $areas = Area::all()->where('fk_board_id', $idPage); 

        return view('boards.edit', ['previousboard' => $previousboard,'nextboard' => $nextboard, 'allboards' => $allboards, 'comic' => $comic, 'medias' => $medias, 'areas' => $areas, 'board' => $board, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idBoard)
    {
        $areas = Area::all()->where('fk_board_id', $idBoard);
        $zones = Area::all()->where('fk_board_id', '!=', $idBoard);

        $tab_media_id = array();
        foreach ($areas as $area) {

            array_push($tab_media_id, $area-> fk_media_id);
            $area->delete();
        }

        $board = Board::where('board_id', $idBoard)->first();
        $path_delete = substr($board->board_image, 9);
        Storage::delete('public/'.$path_delete);
        $board->delete();

        foreach ($tab_media_id as $mediaId) {
            var_dump($mediaId);
            $medias = Media::all()->where('media_id', $mediaId);

            foreach ($medias as $media) {
                $use = 0;
                foreach ($zones as $zone) {
                    if ($zone-> fk_media_id === $mediaId) {
                        $use += 1;
                    }
                }
                if ($use === 0) {
                    $media-> media_use = false;
                }else{
                    $media-> media_use = true;
                }
                // var_dump($media-> media_use);
                $media->save();
            }
        }

        return redirect()->back();
    }
}