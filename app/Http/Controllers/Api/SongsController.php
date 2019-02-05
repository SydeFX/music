<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Song;
use App\SongsCounter;

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

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        try{
            $keyword = $request->get('search');
            $perPage = 25;
            if (!empty($keyword)) {
                $songs = Song::join('artists', 'artists.id', '=', 'songs.artistId')
                    ->select('songs.*', 'artists.title as name', 'artists.thumbnail as poster')
                    ->where('songs.title', 'LIKE', "%$keyword%")
                    ->orderBy('songs.id', 'desc')->paginate($perPage);
            } else {
                $songs = Song::join('artists', 'artists.id', '=', 'songs.artistId')
                ->select('songs.*', 'artists.title as name')
                ->orderBy('songs.id', 'desc')->paginate($perPage);
            }
            return response()->json($songs, 200, [],JSON_NUMERIC_CHECK);
        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
    }
    public function popularSong(Request $request){
        try {
            $songs =  DB::table('songs')
            ->join('artists', 'artists.id', '=', 'songs.artistId')
            ->join('song_counter', 'song_counter.song_id', '=' , 'songs.id')
            ->select(
                'songs.id', 
                'songs.title', 
                'songs.url', 
                'songs.thumbnail', 
                'songs.duration', 
                'artists.title as name',
                'artists.thumbnail as poster',
                'artists.id as artistId',
                DB::raw('COUNT(song_counter.song_id) as views'))
            ->groupBy('songs.id')
            ->orderBy('views', 'desc')
            ->paginate(20);
            return response()->json($songs,200,[],JSON_NUMERIC_CHECK);
        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
    }
    
    public function songCounter(Request $request){
        try{
            $requestData = $request->all();            
            SongsCounter::create($requestData);
            return response()->json(['message' => 'success']);
        }catch (\Exception $ex) {
            return response()->json(["message" =>  $ex->getMessage()], 400); 
        }
    }
    public function create(){

    }

    public function store(Request $request){
    }
    public function show($id){
    }
    public function edit($id){
    }
    public function update(Request $request, $id) {
    }
    public function destroy($id){
    }
}
