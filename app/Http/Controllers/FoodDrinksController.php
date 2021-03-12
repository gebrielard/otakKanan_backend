<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodDrinks;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class FoodDrinksController extends Controller
{
    public function index() {

        $food_drinks = DB::table('$food_drinks')
        ->where('user_id', '=', $user->id)
        ->get();

        if (empty($food_drinks)) {
            $status = "data tidak tersedia";
        }

        $status = "data tersedia";

        return response()->json(compact(['food_drinks', 'status']));

    }

    public function store(Request $request, $id) {

        $user = JWTAuth::parseToken()->authenticate();

        $this->validate($request,[
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required'
        ]);

        try {

            $food_drinks = FoodDrinks::create([
                'room_id' => $id,
                'user_id' => $user->id,
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'price' => $request->get('price')
            ]);
        }
        catch(\Exception $e){
            return response()->json(['status'=>$e->getMessage()]);
        }

        $status = "data berhasil dibuat";
        
        return response()->json(compact(['food_drinks', 'status']));

    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $food_drinks = DB::table('food_drinks')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($food_drinks)){

            $status = "data tidak tersedia";
            return response()->json(compact('status'));
        }

        if($request->get('name')==NULL){

            $name = $food_drinks->name;

        } else{

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('name');

        }

        if($request->get('description')==NULL){

            $description = $food_drinks->description;

        } else{

            $validator = Validator::make($request->all(), [
                'description' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $description = $request->get('description');

        }

        if($request->get('price')==NULL){

            $price = $food_drinks->price;

        } else{

            $validator = Validator::make($request->all(), [
                'price' => 'required|string|max:255'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('price');

        }

        $food_drinks->update([
            'name'=>$name,
            'description'=>$description,
            'price' => $price
        ]);

        $status = "update successfull";

        return response()->json(compact(['food_drinks', 'status']));

    }

    public function destroy($id) {

        $user = JWTAuth::parseToken()->authenticate();
        $food_drinks = DB::table('food_drinks')
        ->where('user_id', '=', $user->id)
        ->where('id', '=', $id)
        ->first();

        if(empty($food_drinks)){

            $status = "data tidak tersedia";
            return response()->json(compact('status'));
        }

        $status = "delete successfull";

        $food_drinks->delete();

        return response()->json(compact(['food_drinks', 'status']));

    }

}
