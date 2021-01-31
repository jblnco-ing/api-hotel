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
}
