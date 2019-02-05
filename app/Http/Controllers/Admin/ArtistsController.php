<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Artist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Response;
use DB;
use Auth;
use Validator;
use Illuminate\Support\Facades\File;
use Image;

class ArtistsController extends Controller
{
    public function __construct()  {
        $this->middleware('auth');
         date_default_timezone_set("Asia/Bangkok");
    }

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
            $artists = Artist::where('title', 'LIKE', "%$keyword%")
                ->orWhere('thumbnail', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $artists = Artist::latest()->paginate($perPage);
        }

        return view('admin.artists.index', compact('artists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.artists.create');
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

            $tmp_path = public_path('artists/'.$path_random);
            $letmovefiles   = $file->move($tmp_path, $originalName);
            $getlnik = url('artists/'.$path_random).'/'.$originalName;  

            $requestData['thumbnail'] = $getlnik;   
            Artist::create($requestData);
            Session::flash('flash_class', 'alert-success');
            Session::flash('flash_message', 'Artist added!');
        }

        return redirect('admin/artists');

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
        $artist = Artist::findOrFail($id);

        return view('admin.artists.show', compact('artist'));
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
        $artist = Artist::findOrFail($id);

        return view('admin.artists.edit', compact('artist'));
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
            }else {
                
                $file = $request->file('thumbnail');
                $extension = $file->getClientOriginalExtension(); 
                $originalName = $file->getClientOriginalName(); 
    
                $path_random = rand(1111111111111111,9999999999999999);
    
                $tmp_path = public_path('artists/'.$path_random);
                $letmovefiles   = $file->move($tmp_path, $originalName);
                $getlnik = url('artists/'.$path_random).'/'.$originalName;  

                $requestData['thumbnail'] = $getlnik;  
                $artist = Artist::findOrFail($id);
                $artist->update($requestData);
            }
        }else {
            $artist = Artist::findOrFail($id);
            $artist->update($requestData);
        }

      

        return redirect('admin/artists')->with('flash_message', 'Artist updated!');
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
        Artist::destroy($id);

        return redirect('admin/artists')->with('flash_message', 'Artist deleted!');
    }
}
