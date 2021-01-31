<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @OA\Schema(
*  schema="record",
*  @OA\Property(
*     property="room_id",
*     type="integer",
*     example=1
*   ),
*   @OA\Property(
*     property="date_in",
*     type="string",
*     example="2021/02/26"
*   ),
*   @OA\Property(
*     property="date_out",
*     type="string",
*     example="2021/02/26"
*   ),
*   @OA\Property(
*     property="status",
*     type="boolean",
*     example=true
*   ),
*   @OA\Property(
*     property="users",
*     type="array",
*     @OA\Items(
*       ref="#/components/schemas/user"
*     )
*   ),
* )
*/
class Record extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date_in',
        'date_out',
        'update_by',
        'room_id',
    ];

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Return true if date_in and date_out is available for the room.
     *
     * @param  int  $record_id
     * @param  int  $room_id
     * @param  string  $date_out
     * @param  string  $date_in
     * @return boolean
     */
    public static function areAvailableDates($date_in, $date_out, $room_id, $record_id=null)
    {
        $query = self::where('room_id','=',$room_id);
        
        if (isset($record_id))
        $query->where('id','!=',$record_id);
        
        return $query->where(function ($query) use($date_in,$date_out) {
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
        })->get()->isEmpty();
    }
}
