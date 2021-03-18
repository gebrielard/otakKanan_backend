<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;

class RoomTypeController extends Controller
{
   
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $roomTypes = DB::table('room_types')
        ->where('user_id', '=', $user->id)
        ->get();

        if(empty($roomTypes)) {

            return response()->json(['status' => "Data Doesn't exist"]);
        }

        $status = "Data Exist";

        return response()->json(compact('roomTypes', 'status'));
        
    }

    
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request,[
            'room_id' => 'required',
            'name' => 'required|string',
            'capacity' => 'required|integer',
        ]);

        if($request->hasFile('layout')) {
            $request->validate([
                'filename' => 'required|image|mimes:png,jpeg,jpg'
            ]);
            $file = $request->file('filename');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('otakkanan/', $filename);
        }

        $roomType = RoomType::create([
            'room_id' => $request->get('room_id'),
            'user_id' => $user->id,
            'name' => $request->get('name'),
            'capacity' => $request->get('capacity'),
            'layout' => $request->get('layout')
        ]);
        
        $status = "Data created successfully";

        return response()->json(compact('roomType', 'status'));
    }

   
    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $roomType = DB::table('room_types')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();
        
        if (empty($roomType)) {

            return response()->json(['status' => "Data Doesn't exist"]);
        } else {

            $status = "Showed successfully";
            return response()->json(compact('roomType', 'status'));
        }
    }

 
    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $roomType = DB::table('room_types')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($roomType)){

            return response()->json(['status' => "Data Doesn't exist"]);
        }


        if($request->get('name')==NULL){

            $name = $roomType->name;

        } else{

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('name');

        }

        if($request->get('capacity')==NULL){

            $capacity = $roomType->capacity;

        } else{

            $validator = Validator::make($request->all(), [
                'capacity' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $capacity = $request->get('capacity');

        }

        if($request->get('layout')==NULL){

            $layout = $roomType->layout;

        } else{

            $validator = Validator::make($request->all(), [
                'layout' => 'required|image|mimes:png,jpeg,jpg'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }

            $file = $request->file('layout');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('otakkanan/', $filename);
            Storage::delete('otakkanan/' . $roomType->filename);

        }

        $roomType_temp = RoomType::find($roomType->id);
        
        $roomType_temp->update([
            'name' => $name,
            'capicity' => $capacity,
            'layout' => $layout
        ]);

        return response()->json(['status' => "Update successfully"]);

    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $roomType = DB::table('room_types')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($roomType)){

            return response()->json(['status' => "Data Doesn't exist"]);
        }

        $roomType->delete();

        return response()->json(['status' => "Delete successfully"]);
    }
}
