<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{

       function __construct()
    {
         $this->middleware('permission:social_media-list|social_media-create|social_media-edit|social_media-delete', ['only' => ['index','store']]);
         $this->middleware('permission:social_media-create', ['only' => ['create','store']]);
         $this->middleware('permission:social_media-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:social_media-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SocialMedia::orderBy('position','asc')->paginate(10);
        return view('backend.social-media.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.social-media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'position' => 'required',
            'status' => 'required',
        ]);
    
        $SocialMedia = new SocialMedia();
        $SocialMedia->name = $request->name ?? '';
        $SocialMedia->url = $request->url ?? '';
        $SocialMedia->icon = $request->icon ?? '';
        $SocialMedia->position = $request->position ?? '';
        $SocialMedia->status = $request->status ?? '';
        $SocialMedia->save();
        return redirect()->route('social_media.index')
                        ->with('success','Information created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $social_media = SocialMedia::find($id);
        return view('backend.social-media.show',compact('social_media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social_media = SocialMedia::find($id);
        return view('backend.social-media.edit',compact('social_media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'icon' => 'required',
            'position' => 'required',
            'status' => 'required',
        ]);
    
        $SocialMedia = SocialMedia::find($id);
        $SocialMedia->name = $request->name ?? '';
        $SocialMedia->url = $request->url ?? '';
        $SocialMedia->icon = $request->icon ?? '';
        $SocialMedia->position = $request->position ?? '';
        $SocialMedia->status = $request->status ?? '';
        $SocialMedia->save();
        return redirect()->route('social_media.index')
                        ->with('success','Information created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table("social_media")->where('id',$id)->delete();
        return redirect()->route('social_media.index')
                        ->with('success','Information deleted successfully');
    }
}
