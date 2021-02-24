<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = Facility::all();

        return response()->json(compact('facilities'));
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
            'status' => 'required'
        ]);

        $facility = Facility::create([
            'room_id' => $request->get('room_id'),
            'name' => $request->get('name'),
            'status' => $request->get('status')
        ]);
        
        return response()->json(compact('facility'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $facility = Facility::find($id);
        
        if (empty($facility)) {
            return response()->json([ 'message' => "Data Not Found"]); 
        } else {
            return response()->json(compact('facility'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(Facility $facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $facility = Facility::find($id);

        if ($request->get('room_id') != null) {
            $facility->update([
                'room_id' => $request->get('room_id')
            ]);
        }

        if ($request->get('name') != null) {
            $facility->update([
                'name' => $request->get('name')
            ]);
        }

        if ($request->get('status') != null) {
            $facility->update([
                'status' => $request->get('status')
            ]);
        }
        
        return response()->json([ 'message' => "Data Successfully Updated"]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility = Facility::find($id);

        if ($facility->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }      
    }
}
