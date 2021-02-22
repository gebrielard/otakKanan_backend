<?php

namespace App\Http\Controllers;

use App\Models\RoomFunction;
use Illuminate\Http\Request;

class RoomFunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomFunctions = RoomFunction::all();

        return response()->json(compact('roomFunctions'));
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
            'name' => 'required'
        ]);

        $roomFunction = RoomFunction::create([
            'room_id' => $request->get('room_id'),
            'name' => $request->get('name')
        ]);
        
        return response()->json($roomFunction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoomFunction  $roomFunction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roomFunction = RoomFunction::find($id);
        
        if (empty($roomFunction)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('roomFunction'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RoomFunction  $roomFunction
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomFunction $roomFunction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoomFunction  $roomFunction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $roomFunction = RoomFunction::find($id);

        if ($request->get('room_id') != null) {
            $roomFunction->update([
                'room_id' => $request->get('room_id')
            ]);
        }

        if ($request->get('name') != null) {
            $roomFunction->update([
                'name' => $request->get('name')
            ]);
        }
        
        return response()->json([ 'message' => "Data Successfully Updated"]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoomFunction  $roomFunction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roomFunction = RoomFunction::find($id);

        if ($roomFunction->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }      
    }
}
