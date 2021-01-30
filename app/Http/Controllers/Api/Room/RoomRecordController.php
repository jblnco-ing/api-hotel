<?php

namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\ApiController;
use App\Room;
use Illuminate\Http\Request;

class RoomRecordController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $room
     * @return \Illuminate\Http\Response
     */
    public function index($room)
    {
        $room = Room::with(['records.users'])->find($room);
        return $this->showOne($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $room
     * @param  int $record
     * @return \Illuminate\Http\Response
     */
    public function show($room, $record)
    {
        $room = Room::with(['records'=>function($query) use($record){
            $query->where('id',$record);
        },'records.users'])->find($room);
        return $this->showOne($room);
    }

}
