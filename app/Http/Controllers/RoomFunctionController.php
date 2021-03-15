<?php

namespace App\Http\Controllers;

use App\Models\RoomFunction;
use Illuminate\Http\Request;
use JWTAuth;

class RoomFunctionController extends Controller
{
    
    public function index()
    {
        $roomFunctions = RoomFunction::all();

        return response()->json(compact('roomFunctions'));
    }

    
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request,[
            'room_id' => 'required',
            'name' => 'required'
        ]);

        $roomFunction = RoomFunction::create([
            'room_id' => $request->get('room_id'),
            'user_id' => $user->id,
            'name' => $request->get('name')
        ]);
        
        return response()->json(compact('roomFunction'));
    }

    
    public function show($id)
    {
        $roomFunction = DB::table('room_functions')
        ->where('room_id', 'like', $id)->get();
        

        if (empty($roomFunction)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('roomFunction'));
        }
    }


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

    
    public function destroy($id)
    {
        $roomFunction = RoomFunction::find($id);

        if ($roomFunction->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }      
    }
}
