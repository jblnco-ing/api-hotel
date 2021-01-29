<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    const ROOM_DISABLED=false;
    const ROOM_ENABLED=true;
    const ROOM_MIN_CAPACITY=1;
    protected $fillable = [
        'code',
        'capacity',
        'price',
        'status',
    ];
    public function isEnabled()
    {
        return $this->status == Room::ROOM_ENABLED;
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
