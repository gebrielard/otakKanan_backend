<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonRegulations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class CommonRegulationsController extends Controller
{

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

    public function update($id) {

        

    }

}
