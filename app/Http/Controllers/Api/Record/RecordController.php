<?php

namespace App\Http\Controllers\Api\Record;

use App\Http\Controllers\ApiController;
use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecordController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'room_id' => 'required|integer',
            'date_in' => 'required|date',
            'date_out' => 'required|date',
            'user_id' => 'required|array',
            'user_id.*' => 'integer',
            'status' => 'boolean',
        ]);

        $date_in=Carbon::parse($request->input('date_in'));
        $date_out=Carbon::parse($request->input('date_out'));
        $room_id=$request->input('room_id');
        
        if (Carbon::now()->gte($date_in))
        return $this->errorResponse('The check-in date must be greater than or equal to the current date',400);
        if ($date_in->gt($date_out))
        return $this->errorResponse('Check-out date must be greater than check-in date',400);
        
        $exist=Record::where('room_id','=',$room_id)
        ->where(function ($query) use($date_in,$date_out) {
            $query
            ->whereDate('date_in','<=',$date_in)
            ->whereDate('date_out','>=',$date_out)
            ->orWhereBetween('date_in',[
                $date_in,
                $date_out
            ])
            ->orWhereBetween('date_out',[
                $date_in,
                $date_out
            ]);
        })->get();
        if ($exist->isNotEmpty())
            return $this->errorResponse('this room is not available for those dates',400);
        $record=Record::create([
            'room_id' => $request->input('room_id'),
            'date_in' => $request->input('date_in'),
            'date_out' => $request->input('date_out'),
            'status' => $request->input('status',1)
        ]);
        $record->users()->attach($request->input('user_id'));
        $record=Record::with('users')->find($record->id);
        return $this->showOne($record);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $record)
    {
        $record=Record::find($record);
        $request->validate([
            'room_id' => 'required|integer',
            'date_in' => 'required|date',
            'date_out' => 'required|date',
            'user_id' => 'required|array',
            'user_id.*' => 'integer',
            'status' => 'boolean',
        ]);
        
        $date_in=Carbon::parse($request->input('date_in'));
        $date_out=Carbon::parse($request->input('date_out'));
        $room_id=$request->input('room_id');
        
        if (Carbon::now()->gte($date_in))
        return $this->errorResponse('The check-in date must be greater than or equal to the current date',400);
        if ($date_in->gt($date_out))
        return $this->errorResponse('Check-out date must be greater than check-in date',400);
        
        $exist=Record::where('room_id','=',$room_id)
        ->where('id','!=',$record->id)
        ->where(function ($query) use($date_in,$date_out) {
            $query
            ->whereDate('date_in','<=',$date_in)
            ->whereDate('date_out','>=',$date_out)
            ->orWhereBetween('date_in',[
                $date_in,
                $date_out
            ])
            ->orWhereBetween('date_out',[
                $date_in,
                $date_out
            ]);
        })->get();
        if ($exist->isNotEmpty())
            return $this->errorResponse('this room is not available for those dates',400);
        $record->update([
            'room_id' => $request->input('room_id'),
            'date_in' => $request->input('date_in'),
            'date_out' => $request->input('date_out'),
            'status' => $request->input('status',1)
        ]);
        $record->users()->sync($request->input('user_id'));
        $record=Record::with('users')->find($record->id);
        return $this->showOneData($record);
    }
}
