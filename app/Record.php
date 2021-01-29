<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'date_in',
        'date_out',
        'update_by',
        'user_id',
        'room_id',
    ];

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
