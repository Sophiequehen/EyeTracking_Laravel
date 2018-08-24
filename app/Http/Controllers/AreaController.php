<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Comic;
use App\Board;
use App\Area; 
use App\Media; 

class AreaController extends Controller
{
    public function fetchAssocZones($idPage) {
        $pageQuery = Board::all()->where('pag_oid','=', $idPage)->first();
        $areasQuery = Area::all()->where('fk_board_id','=', $idPage);
        // var_dump($areasQuery);

        //to verify if media
      // foreach ($areasQuery as $key => $value) {
      //   $mediaQuery = Media::all()->where('fk_are_oid','=', $value->are_oid);

      //   $areasQuery[$key]->has_media = count($mediaQuery);
        
      // }

        return view('boards.mapping.show',['pages' => $pageQuery[0], 'areas' => $areasQuery]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function create($idBD, $idPage, Request $request)
    {
        $comic = Comic::all()->where('comic_id', $idBD)->first();  
        $board = Board::all()->where('board_id',$idPage)->first();
        $medias = Media::all();
        $areas = Area::all()->where('fk_board_id', $idPage);   


        return view('boards.mapping.create', ['comic' => $comic, 'medias' => $medias, 'board' => $board, 'areas' => $areas]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::all()->where('board_id',$id)->first();
        $medias = Media::all();
        $areas = Area::all()->where('fk_board_id', $id); 

        // return view('boards.mapping.show', compact('medias'), compact('areas'), ['medias' => $medias, 'board' => $board, 'areas' => $areas]);

        return view('boards.mapping.show', ['medias' => $medias, 'board' => $board, 'areas' => $areas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($idBD, $idPage, Request $request)
    {
            // var_dump( request('dataType'));
        // var_dump($request->all());

        $area = new Area;
        $area-> area_coord = request('coords1');
        $area-> area_trigger = request('trigger');
        $area-> fk_board_id = $idPage;
        $area-> fk_media_id = request('dataType');
        $area->save();

        return redirect()->route('board-edit',  ['idBD' => $idBD, 'idPage' => $idPage]);

    }

    
    // Récupère une Bande-Dessinée unique necéssaire pour le update
    public function edit($id)
    {

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



    }
}
