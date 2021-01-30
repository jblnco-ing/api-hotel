<?php

namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\ApiController;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $rooms=Room::all();
        return $this->showAll($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'code' => 'nullable|string',
            'capacity' => 'nullable|integer|max:5|min:1',
            'price' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);
        $room=Room::create($data);
        return $this->showOne($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        return $this->showOne($room);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=$request->user();
        $request->validate([
            'code' => 'nullable|string',
            'capacity' => 'nullable|integer|max:5|min:1',
            'price' => 'nullable|integer',
            'status' => 'nullable|bool',
        ]);
        $room=ROOM::find($id);  
        if ($request->exists('code') && $user->hasRole('Admin'))
        $room->code=$request->input('code');
        if ($request->exists('capacity'))
        $room->capacity=$request->input('capacity');
        if ($request->exists('price'))
        $room->price=$request->input('price');
        $room->status=$request->input('status',0);
        $room->save();
        return $this->showOne($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room=ROOM::find($id);
        $room->delete();
    }
}
