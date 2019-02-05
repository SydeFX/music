<?php

namespace App\Http\Controllers\Admin;

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

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $songs = Song::where('title', 'LIKE', "%$keyword%")
                ->orWhere('thumbnail', 'LIKE', "%$keyword%")
                ->orWhere('url', 'LIKE', "%$keyword%")
                ->orWhere('duration', 'LIKE', "%$keyword%")
                ->orWhere('artistId', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $songs = Song::latest()->paginate($perPage);
        }

        return view('admin.songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $artists = Artist::all();
        return view('admin.songs.create', compact('artists'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        $validator = Validator::make($request->all(), [
            'thumbnail' =>'required|mimes:jpeg,jpg,png' 
        ]);
        if($validator->fails()){ 
            Session::flash('flash_class', 'alert-danger');
            Session::flash('flash_message', 'Could not upload image.');
        } else {

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension(); 
            $originalName = $file->getClientOriginalName(); 

            $path_random = rand(1111111111111111,9999999999999999);

            $tmp_path = public_path('poster/'.$path_random);
            $letmovefiles   = $file->move($tmp_path, $originalName);
            $getlnik = url('poster/'.$path_random).'/'.$originalName;  

            $requestData['thumbnail'] = $getlnik;   
            Song::create($requestData);

        }
        

        return redirect('admin/songs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $song = Song::findOrFail($id);

        return view('admin.songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $song = Song::findOrFail($id);
        $artists = Artist::all();

        return view('admin.songs.edit', compact('song','artists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        if($request->file('thumbnail')){

            $validator = Validator::make($request->all(), [
                'thumbnail' =>'required|mimes:jpeg,jpg,png' 
            ]);

            if($validator->fails()){ 
                Session::flash('flash_class', 'alert-danger');
                Session::flash('flash_message', 'Could not upload image.');
            } else {
    
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension(); 
                $originalName = $file->getClientOriginalName(); 
    
                $path_random = rand(1111111111111111,9999999999999999);
    
                $tmp_path = public_path('poster/'.$path_random);
                $letmovefiles   = $file->move($tmp_path, $originalName);
                $getlnik = url('poster/'.$path_random).'/'.$originalName;  
    
                $requestData['thumbnail'] = $getlnik;   
                $song = Song::findOrFail($id);
                $song->update($requestData);
    
            }
        }else {
            $song = Song::findOrFail($id);
            $song->update($requestData);
        }
       

        return redirect('admin/songs')->with('flash_message', 'Song updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Song::destroy($id);

        return redirect('admin/songs')->with('flash_message', 'Song deleted!');
    }
}
