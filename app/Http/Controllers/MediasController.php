<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Comic;
use App\Board;
use App\Media;
use App\User;
use App\Area; 
use Auth;
/*
|--------------------------------------------------------------------------
| Controller pour les MÉDIAS des BD
|--------------------------------------------------------------------------
*/

class MediasController extends Controller
{

	// private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
	// private $audio_ext = ['mp3', 'ogg', 'mpga'];
	// private $video_ext = ['mp4', 'mpeg'];

	public function index(){
		
		$areas = Area::all();
		$users = User::all();
		$medias = Media::orderBy('created_at', 'desc')->paginate(12);
		$media_by = false;
		$medias_all = Media::all();
		// $medias = Media::sortByDesc('created_at')->paginate(5);
		return view('medias.read', ['media_by' => $media_by, 'medias_all' => $medias_all, 'areas' => $areas, 'medias' => $medias, 'users' => $users]);
	}


	public function create(Request $request)
	{
		return view('medias.create');
	}

	public function createFromBoard($idBD, $idPage, Request $request)

	{
		$comic = Comic::where('comic_id', $idBD)->first();
		$board = Board::where('board_id', $idPage)->first();
		return view('medias.create-from-board', ['comic' => $comic, 'board' => $board]);
	}

	public function store(Request $request)
	{

	//stores the file in the media folder
		$originalName = $request->file('media')->getClientOriginalName();
		$pathstart = $request->file('media')->storeAs('public/medias/', $originalName);

	//removes the "public"
		$path = substr($pathstart, 7);

		$dataType = request('dataType');


	//VALIDATION : validate method stops the code execution if conditions not fullfilled, and send error automatically on the page.

	//ERROR : The validation does not prevent problems with large files.


		//VÉRIFICATIONS À REVOIR	
		// if ($dataType == 'image') {
		// 	$validatedData = $request->validate([
		// 		'file' => 'required|image'
		// 	]);
		// } elseif ($dataType == 'video') {
		// 			// x-msvideo = avi
		// 	$validatedData = $request->validate([
		// 		'file' => 'required|mimetypes:video/mpeg,video/ogg,video/mp4,video/quicktime|max:500000'
		// 	]);
		// } elseif ($dataType == 'son') {
		// 			// mpeg == mp3
		// 	$validatedData = $request->validate([
		// 		'file' => 'required|mimetypes:mpga,audio/mpeg,wav,audio/ogg,mp4|max:100000'
		// 	]);
		// }

		$medias = new Media;
		$medias-> fk_user_id = Auth::user()->id;
		$medias-> media_type = $dataType;
		$medias-> media_filename = $originalName;
		$medias-> media_path = '/storage/medias/'.$originalName;



		//verifies if the media is already present
		$verif_media = Media::all()->where('media_type',$medias-> media_type)
		->where('media_filename',$medias-> media_filename)
		->where('media_path',$medias-> media_path);

		if(count($verif_media)>0){
			// media already present, abort.
			return redirect()->route('medias')->with('duplicate','Le média existe déjà.');
		}else{
			//success
			$medias->save();
			return redirect()->route('medias')->with('add','Media correctement ajouté.');
		}
	}

	public function storeFromBoard($idBD, $idPage, Request $request)
	{

	//stores the file in the media folder
		$originalName = $request->file('media')->getClientOriginalName();
		$pathstart = $request->file('media')->storeAs('public/medias/', $originalName);

	//removes the "public"
		$path = substr($pathstart, 7);
		$dataType = request('dataType');

		$medias = new Media;
		$medias-> fk_user_id = Auth::user()->id;
		$medias-> media_type = $dataType;
		$medias-> media_filename = $originalName;
		$medias-> media_path = '/storage/medias/'.$originalName;

		//verifies if the media is already present
		$verif_media = Media::all()->where('media_type',$medias-> media_type)
		->where('media_filename',$medias-> media_filename)
		->where('media_path',$medias-> media_path);

		if(count($verif_media)>0){
			//media already present, abort.
			return redirect()->route('mapping_create',[$idBD, $idPage])->with('duplicate','Le média existe déjà.');
		}else{
			//success
			$medias->save();
			return redirect()->route('mapping_create',[$idBD, $idPage])->with('add','Media correctement ajouté.');
		}
	}


	public function delete(Request $request, $id)
	{

		$media = Media::where('media_id', $id)->first();
		$media_name = $media-> media_filename;

		return redirect()->route('medias')->with('alert_delete',$media_name);
	}

	public function destroy($name, Request $request)
	{		
		$media = Media::where('media_filename', $name)->first();
		$path_delete = substr($media->media_path, 9);
		Storage::delete('public/'.$path_delete);
		Media::where('media_filename', $name)->delete();

		return redirect()->route('medias')->with('add','Media correctement supprimé : '.$name);
	}
}