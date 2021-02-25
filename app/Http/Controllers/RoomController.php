<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    
    public function index()
    {
        $rooms = Room::all();

        return response()->json(compact('rooms'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
            'description' => 'required'
        ]);

        $room = Room::create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'description' => $request->get('description')
        ]);
        
        return response()->json($room);
    }

    
    public function show($id)
    {
        $room = Room::find($id);
        
        if (empty($room)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('room'));
        }
    }
    
    
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if ($request->get('name') != null) {
            $room->update([
                'name' => $request->get('name')
            ]);
        }

        if ($request->get('code') != null) {
            $room->update([
                'code' => $request->get('code')
            ]);
        }

        if ($request->get('description') != null) {
            $room->update([
                'description' => $request->get('description')
            ]);
        }

        return response()->json([ 'message' => "Data Successfully Updated"]);  
    }

    
    public function destroy($id)
    {
        $room = Room::find($id);
        
        if ($room->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }        
    }
}
