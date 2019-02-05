<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Artist;
use App\ArtistCounter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Response;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\File;
use Image;

class ArtistsController extends Controller{
   
    public function index(Request $request){
        try {
            $keyword = $request->get('search');
            $perPage = 25;
    
            if (!empty($keyword)) {
                $artists = Artist::where('title', 'LIKE', "%$keyword%")
                    ->orWhere('thumbnail', 'LIKE', "%$keyword%")
                    ->latest()->paginate($perPage);
            } else {
                $artists = Artist::latest()->paginate($perPage);
            }
            return response()->json($artists, 200);

        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
        
    }
    public function create() {

    }
    public function store(Request $request){

    }
    public function show($id)
    {
       try {

            $artist =  DB::table('songs')
            ->select('songs.*','artists.title as name','artists.thumbnail as poster')
            ->join('artists', 'artists.id', '=', 'songs.artistId')
            ->where('songs.artistId', $id)
            ->groupBy('songs.id')
            ->orderBy('songs.id', 'desc')
            ->paginate(25);

            $requestData['artist_id'] = $id;
            ArtistCounter::create($requestData);

        return Response()->json($artist, 200, [], JSON_NUMERIC_CHECK);
       }catch (\Exception $ex) {
        return response()->json(["message" =>  $ex->getMessage()], 400); 
        }

    }
    public function popularArtists(Request $request){
        try{

            $artist =  DB::table('artists')
            ->join('artist_counter', 'artist_counter.artist_id', '=', 'artists.id')
            ->select('artists.*', DB::raw('COUNT(artist_counter.artist_id) as views'))
            ->groupBy('artists.id')
            ->orderBy('views', 'desc')
            ->paginate(25);
            
            return Response()->json($artist, 200, [], JSON_NUMERIC_CHECK);

        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
    }
    
    public function edit($id){
    }
    public function update(Request $request, $id) {
    }
    public function destroy($id){

    }
}
