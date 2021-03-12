<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonRegulations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class CommonRegulationsController extends Controller
{

    public function index() {

        $common_regulations = DB::table('$common_regulations')
        ->where('user_id', '=', $user->id)
        ->get();

        if (empty($common_regulations)) {
            $status = "data tidak tersedia";
        }

        $status = "data tersedia";

        return response()->json(compact(['common_regulations', 'status']));

    }

    public function store(Request $request, $id) {

        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);

        try {

            $common_regulations = CommonRegulations::create([
                'room_id' => $id,
                'user_id' => $user->id,
                'name' => $request->get('name')
            ]);
        }
        catch(\Exception $e){
            return response()->json(['status'=>$e->getMessage()]);
        }
        
        return response()->json(compact('common_regulations'));

    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $common_regulations = DB::table('common_regulations')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($common_regulations)){

            $status = "data tidak tersedia";
            return response()->json(compact('status'));
        }

        if($request->get('name')==NULL){

            $name = $common_regulations->name;

        } else{

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('name');

        }

        $common_regulations->update([
            'name'=>$name
        ]);

        $status = "update successfull";

        return response()->json(compact(['common_regulations', 'status']));

    }

    public function destroy($id) {

        $user = JWTAuth::parseToken()->authenticate();
        $common_regulations = DB::table('common_regulations')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($common_regulations)){

            $status = "data tidak tersedia";
            return response()->json(compact('status'));
        }

        $status = "delete successfull";

        $common_regulations->delete();

        return response()->json(compact(['common_regulations', 'status']));

    }

}
