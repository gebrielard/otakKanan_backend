<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        return response()->json(compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        
        if (empty($room)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('room'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        
        if ($room->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }        
    }
}
