<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use Illuminate\Http\Request;
use App\Artist;
use Carbon\Carbon;
use Session;
use Response;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\File;
use Image;

class SearchController extends Controller{
 
    public function search(Request $request){
        try{
            $keyword = $request->get('search');
            $perPage = 25;
            if (!empty($keyword)) {
                $songs = Song::join('artists', 'artists.id', '=', 'songs.artistId')
                        ->select('songs.*', 'artists.title as name', 'artists.thumbnail as poster')
                        ->where('songs.title', 'LIKE', "%$keyword%")
                        ->orderBy('songs.id', 'desc')->get();
                
                $artists = Artist::where('title', 'LIKE', "%$keyword%")
                        ->select("id","title", "thumbnail")
                        ->limit(5)
                        ->get();
                 return response()->json(["songs" => $songs, "artists" => $artists], 200, [],JSON_NUMERIC_CHECK);
            }

            return response()->json(['songs' => [], 'artists' => [] ], 200);


        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
    }

} 
