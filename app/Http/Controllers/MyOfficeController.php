<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\CommonRegulations;
use App\Models\Facility;
use App\Models\FoodDrinks;
use App\Models\Gallery;
use App\Models\OperationalTimes;
use App\Models\RoomCategoryPrice;
use App\Models\RoomFunction;
use App\Models\RoomType;
use App\Models\Users;
use App\Models\CategoryPrice;
use App\Models\MyOffice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class MyOfficeController extends Controller
{
    public function index() {
        $user = JWTAuth::parseToken()->authenticate();
        
        $my_office = DB::table('my_office')
        ->where('user_id', 'like', $user->id)
        ->get();

        $rooms = array();

        foreach ($my_office as $key) {
            $temp = Room::find($key->room_id);

            array_push($room, $temp);
        }

        return response()->json(compact('rooms')); 

    }

    public function show($id)
    {

        $user = JWTAuth::parseToken()->authenticate();

        $my_office = DB::table('my_office')
        ->where('user_id', 'like', $user->id)
        ->where('room_id', '=', $id)
        ->first();
        
        $room = Room::find($my_office->room_id);
        
        if (empty($room)) {
            return response()->json([ 'status' => "Data Not Found"]); 
        }

        $roomType = DB::table('room_type')
        ->where('room_id', 'like', $room->id)
        ->get();

        $roomFunction = DB::table('room_functions')
        ->where('room_id', 'like', $room->id)
        ->get();

        $gallery = DB::table('galleries')
        ->where('room_id', 'like', $room->id)
        ->get();

        $facility = DB::table('facilities')
        ->where('room_id', 'like', $room->id)
        ->get();

        $common_regulations = DB::table('common_regulations')
        ->where('room_id', 'like', $room->id)
        ->get();

        $operational_times = DB::table('operational_times')
        ->where('room_id', 'like', $room->id)
        ->get();

        $room_category_price = DB::table('room_category_price')
        ->where('room_id', 'like', $room->id)
        ->get();

        $category_price = DB::table('category_price')
        ->where('id', 'like', $room_category_price->category_price_id)
        ->get();

        $user = DB::table('users')
        ->where('id', 'like', $room_category_price->user_id)
        ->first();

        $detail_room['id'] = $room->id;
        $detail_room['name'] = $room->name;
        $detail_room['address'] = $room->address;
        $detail_room['description'] = $room->description;
        $detail_room['latitude'] = $room->latitude;
        $detail_room['longitude'] = $room->longitude;
        $detail_room['room_type'] = array();

        foreach ($roomType as $key) {
            $temp['id'] =$key->id;
            $temp['name'] = $key->name;
            $temp['capacity'] = $key->capacity;
            $temp['layout'] = $key->layout;
            array_push($detail_room['room_type'], $temp);
        }

        $detail_room['room_function'] = array();

        foreach ($roomFunction as $key) {
            $temp['id'] =$key->id;
            $temp['name'] = $key->name;
            array_push($detail_room['room_function'], $temp);
        }

        $detail_room['gallery'] = array();

        foreach ($gallery as $key) {
            $temp['id'] =$key->id;
            $temp['filename'] = $key->filename;
            array_push($detail_room['gallery'], $temp);
        }

        $detail_room['facility'] = array();

        foreach ($facility as $key) {
            $temp['id'] =$key->id;
            $temp['name'] = $key->name;
            $temp['status'] = $key->status;
            array_push($detail_room['facility'], $temp);
        }

        $detail_room['common_regulations'] = array();

        foreach ($common_regulations as $key) {
            $temp['id'] =$key->id;
            $temp['name'] = $key->name;
            array_push($detail_room['common_regulations'], $temp);
        }

        $detail_room['operational_times'] = array();

        foreach ($operational_times as $key) {
            $temp['id'] =$key->id;
            $temp['day'] = $key->day;
            $temp['open_times'] = $key->open_times;
            $temp['close_times'] = $key->close_times;
            array_push($detail_room['operational_times'], $temp);
        }

        $detail_room['category_price'] = array();

        foreach ($category_price as $key) {
            $temp['id'] = $key->id;
            $temp['name'] = $key->name;
            $temp['price'] = $key->price;
            array_push($detail_room['category_price'], $temp);
        }

        $detail_room['created_by'] = $user->name;

        return response()->json(compact('detail_room'));

    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude'=> 'required',
            'capacity' => 'required',
            'layout' => 'required',
            'room_type_name' => 'required',
            'room_function_name' => 'required',
            'filename' => 'required|image|mimes:png,jpeg,jpg',
            'facility_name' => 'required|max:255',
            'facility_status' => 'required|max:255',
            'regulation_name' => 'required|max:255',
            'day' => 'required',
            'open_times' => 'required',
            'close_times' => 'required',
            'category_price_name' => 'required',
            'price' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => $validator->errors()->toJson()], 400);
        }

        try {
            $room = Room::create([
                'user_id' => $user->id,
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'description' => $request->get('description'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }
        

        try {
            $roomType = RoomType::create([
                'room_id' => $room->id,
                'user_id' => $user->id,
                'name' => $request->get('room_type_name'),
                'capacity' => $request->get('capacity'),
                'layout' => $request->get('layout')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $roomFunction = RoomFunction::create([
                'room_id' => $room->id,
                'user_id' => $user->id,
                'name' => $request->get('room_function_name')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $gallery = Gallery::create([
                'room_id' => $room->id,
                'user_id' => $user->id,
                'filename' => $request->get('filename')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try{
            $facility = Facility::create([
                'room_id' => $room->id,
                'user_id' => $user->id,
                'name' => $request->get('facility_name'),
                'status' => $request->get('facility_status')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $common_regulations = CommonRegulations::create([
                'room_id' => $id,
                'user_id' => $user->id,
                'name' => $request->get('regulation_name')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $operational_times = OperationalTimes::create([
                'room_id' => $id,
                'user_id' => $user->id,
                'day' => $request->get('day'),
                'open_times' => $request->get('open_times'),
                'close_times' => $request->get('close_times')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $category_price = CategoryPrice::create([
                'user_id' => $user->id,
                'name' => $request->get('category_price_name'),
                'price' => $request->get('price')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $room_category_price = RoomCategoryPrice::create([
                'room_id' => $id,
                'user_id' => $user->id,
                'category_price' => $category_price->id
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }

        try {
            $my_office = MyOffice::create([
                'room_id' => $room->id,
                'user_id' => $user->id
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => $th]);
        }


        
        return response()->json(compact('room', 'roomType', 'roomFunction', 'gallery', 'facility', 'common_regulations', 'operational_times', 'category_price', 'room_category_price', 'my_office'));

    }

    public function update() {

        $user = JWTAuth::parseToken()->authenticate();

        $room_id = $request->get('room_id');

        $my_office = DB::table('my_office')
        ->where('user_id', '=', $user->id)
        ->where('room_id', '=', $room_id)
        -first();

        $room = Room::find($my_office->room_id);

        if (empty($room)) {
            return response()->json([ 'status' => "Data Not Found"]); 
        }

        $name = $request->get('name');
        $address = $request->get('address');
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');


        $room->update([
            'user_id' => $user->id,
            'name' => $name,
            'address' => $address,
            'description' => $description,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json([ 'status' => "Update Success"]);

    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $my_office = DB::table('my_office')
        ->where('user_id', '=', $user->id)
        ->where('room_id', '=', $id)
        ->first();

        $room = Room::find($my_office->room_id);

        if (empty($room)) {
            return response()->json([ 'status' => "Data Not Found"]); 
        }

        $room->delete();

        return response()->json([ 'status' => "Delete Success"]); 
             
    }

}
