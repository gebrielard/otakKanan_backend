<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class GalleryController extends Controller
{
    public function index(){

        $user = JWTAuth::parseToken()->authenticate();

        $gallery = DB::table('galleries')
        ->where('user_id', '=', $user->id)
        ->get();

        $gallerykw = DB::table('galleries')
        ->where('user_id', '=', $user->id)
        ->first();

        if (empty($gallerykw)) {
            return response()->json([ 'status' => "Data doesn't exist"]); 
        }

        $status = "Data exist";

        return response()->json(compact('gallery', 'status'));

    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        
        $request->validate([
            'room_id' => 'required'
        ]);

        if($request->hasFile('filename')) {
            
            $validator = Validator::make($request->all(), [
                'filename' => 'required|image|mimes:png,jpeg,jpg'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }

            $file = $request->file('filename');
            $filename = 'otakkanan/' .  time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('otakkanan/', $filename);

        }

        $gallery = Gallery::create([
            'room_id' => $request->room_id,
            'user_id' => $user->id,
            'filename' => $filename,
        ]);

        $status = "Data created succesfully";

        return response()->json(compact('gallery', 'status'));
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $currentGallery = DB::table('galleries')
        ->where('user_id', '=', $user)
        ->where('id', '=', $id)
        ->first();

        if(empty($currentGallery)){
            return response()->json([ 'status' => "Data doesn't exist"]);

        } 

        $status = 'Data exist';

        return response()->json(compact('currentGallery', 'status'));

    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $currentGallery = DB::table('galleries')
        ->where('user_id', '=', $user)
        ->where('id', '=', $id)
        ->first();

        if(empty($currentGallery)){

            return response()->json([ 'status' => "Data doesn't exist"]);

        } else {

            if($request->hasFile('filename')) {

                $request->validate([
                    'filename' => 'required|image|mimes:png,jpeg,jpg'
                ]);

                $file = $request->file('filename');
                $filename = 'otakkanan/' . time() . '.' . $file->getClientOriginalExtension();
                
                $file->storeAs('otakkanan/', $filename);
                
                Storage::delete($currentGallery->filename);

            }

            $currentGallery->update([
                'filename' => $filename,
            ]);

            $status = "Update Successfully";

            return response()->json(compact('currentGallery', 'status'));
        }

    }

    public function destroy(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $currentGallery = DB::table('galleries')
        ->where('user_id', '=', $user)
        ->where('id', '=', $id)
        ->first();

        if(empty($currentGallery)){
        
            return response()->json([ 'status' => "Data doesn't exist"]);
        
        } else {
            
            Storage::delete('otakkanan/' . $currentGallery->filename);

            $currentGallery->delete();
            
            return response()->json([ 'status' => "Data Successfully Deleted"]);
        
        }
    }
}
