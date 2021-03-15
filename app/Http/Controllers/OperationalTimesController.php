<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OperationalTimes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Validator;

class OperationalTimesController extends Controller
{
    public function index() {

        $user = JWTAuth::parseToken()->authenticate();

        $operational_times = DB::table('operational_times')
        ->where('user_id', '=', $user->id)
        ->get();

        if (empty($operational_times)) {
            $status = "Data doesn't exist";
        }

        $status = "Data exist";

        return response()->json(compact(['operational_times', 'status']));

    }

    public function store(Request $request) {

        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request,[
            'room_id' => 'required',
            'day' => 'required|string|max:255',
            'open_times' => 'required|string|max:5|min:5',
            'close_times' => 'required|string|max:5|min:5'
        ]);

        try {

            $operational_times = OperationalTimes::create([
                'room_id' => $request->get('room_id'),
                'user_id' => $user->id,
                'day' => $request->get('day'),
                'open_times' => $request->get('open_times'),
                'close_times' => $request->get('close_times')
            ]);
        }
        catch(\Exception $e){
            return response()->json(['status'=>$e->getMessage()]);
        }
        
        return response()->json(compact('operational_times'));

    }

    public function update(Request $request, $id)
    {
        // $user = JWTAuth::parseToken()->authenticate();

        // $operational_times = DB::table('operational_times')
        // ->where('user_id', '=', $user->id)
        // ->where('id', '=', $id)
        // ->first();

        $operational_times = OperationalTimes::find($id);

        if(empty($operational_times)){

            $status = "Data doesn't exist";
            return response()->json(compact('status'));
        }

        if($request->get('day')==NULL){

            $day = $operational_times->day;

        } else{

            $validator = Validator::make($request->all(), [
                'day' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $day = $request->get('day');

        }

        if($request->get('open_times')==NULL){

            $open_times = $operational_times->open_times;

        } else{

            $validator = Validator::make($request->all(), [
                'open_times' => 'required|string|max:5|min:5'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $open_times = $request->get('open_times');

        }

        if($request->get('close_times')==NULL){

            $close_times = $operational_times->close_times;

        } else{

            $validator = Validator::make($request->all(), [
                'close_times' => 'required|string|max:5|min:5'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $close_times = $request->get('close_times');

        }

        $operational_times->update([
            'day'=>$day,
            'open_times'=>$open_times,
            'close_times'=>$close_times
        ]);

        $status = "Update successfull";

        return response()->json(compact(['operational_times', 'status']));

    }

    public function destroy($id) {

        // $user = JWTAuth::parseToken()->authenticate();
        
        // $operational_times = DB::table('operational_times')
        // ->where('user_id', '=', $user->id)
        // ->where('id', '=', $id)
        // ->first();

        $operational_times = OperationalTimes::find($id);

        if(empty($operational_times)){

            $status = "Data doesn't exist";
            return response()->json(compact('status'));
        }

        $status = "Delete successfull";

        $operational_times->delete();

        return response()->json(compact(['operational_times', 'status']));

    }
}
