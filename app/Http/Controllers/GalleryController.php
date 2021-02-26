<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(){
        return Gallery::all();
        return response()->json(compact('gallery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required'
        ]);

        if($request->hasFile('filename')) {
            $request->validate([
                'filename' => 'required|image|mimes:png,jpeg,jpg'
            ]);
            $file = $request->file('filename');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('otakkanan/', $filename);
        }else{
            $filename= $request->filename;
        }

        $gallery = Gallery::create([
            'room_id' => $request->room_id,
            'filename' => $filename,
        ]);

        return response()->json($gallery);
    }

    public function show($id)
    {
        $currentGallery = Gallery::find($id);
        if(empty($currentGallery)){

        } else {
            return response()->json(compact('currentGallery'));
        }

    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if(empty($gallery)){

        } else {

            $request->validate([
                'room_id' => 'required'
            ]);

            if($request->hasFile('filename')) {

                $request->validate([
                    'filename' => 'required|image|mimes:png,jpeg,jpg'
                ]);

                $file = $request->file('filename');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('otakkanan/', $filename);
                Storage::delete('otakkanan/' . $gallery->filename);
            }else{
                $filename=$request->filename;
            }

            $gallery->update([
                'room_id' => $request->room_id,
                'filename' => $filename,
            ]);

            return response()->json($gallery);
        }

    }

    public function destroy(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        if(empty($gallery)){

        }else {
            Storage::delete('otakkanan/' . $gallery->filename);
            $gallery->delete();
            return response()->json($gallery);
        }
    }
}
