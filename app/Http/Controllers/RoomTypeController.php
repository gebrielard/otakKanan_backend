<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomTypes = RoomType::all();

        return response()->json(compact('roomTypes'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roomType = RoomType::find($id);
        
        if (empty($roomType)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('roomFunction'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roomType = RoomType::find($id);

        if ($roomType->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }      
    }
}
