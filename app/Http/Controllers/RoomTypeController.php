<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
   
    public function index()
    {
        $roomTypes = RoomType::all();

        return response()->json(compact('roomTypes'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'room_id' => 'required',
            'name' => 'required',
            'capacity' => 'required',
            'layout' => 'required'
        ]);

        $roomType = RoomType::create([
            'room_id' => $request->get('room_id'),
            'name' => $request->get('name'),
            'capacity' => $request->get('capacity'),
            'layout' => $request->get('layout')
        ]);
        
        return response()->json($roomType);
    }

   
    public function show($id)
    {
        $roomType = RoomType::find($id);
        
        if (empty($roomType)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('roomFunction'));
        }
    }

 
    public function update(Request $request, $id)
    {
        $roomType = RoomType::find($id);

        if ($request->get('room_id') != null) {
            $roomType->update([
                'room_id' => $request->get('room_id')
            ]);
        }

        if ($request->get('name') != null) {
            $roomType->update([
                'name' => $request->get('name')
            ]);
        }
        
        if ($request->get('capacity') != null) {
            $roomType->update([
                'capacity' => $request->get('capacity')
            ]);
        }

        if ($request->get('layout') != null) {
            $roomType->update([
                'layout' => $request->get('layout')
            ]);
        }

        return response()->json([ 'message' => "Data Successfully Updated"]);  
    }

    public function destroy($id)
    {
        $roomType = RoomType::find($id);

        if ($roomType->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }      
    }
}
