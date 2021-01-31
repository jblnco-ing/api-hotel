<?php
/**
* @OA\Schema(
*  schema="new_room",
*   @OA\Property(
*     property="code",
*     type="string",
*     example="N-1"
*   ),
*   @OA\Property(
*     property="capacity",
*     type="integer",
*     example=4
*   ),
*   @OA\Property(
*     property="price",
*     type="integer",
*     example=170
*   ),
*   @OA\Property(
*     property="status",
*     type="boolean",
*     example=true
*   ),
* ),
* @OA\Schema(
*  schema="room",
*  @OA\Property(
*     property="id",
*     type="integer",
*     example=1
*   ),
*   @OA\Property(
*     property="code",
*     type="string",
*     example="N-1"
*   ),
*   @OA\Property(
*     property="capacity",
*     type="integer",
*     example=4
*   ),
*   @OA\Property(
*     property="price",
*     type="integer",
*     example=170
*   ),
*   @OA\Property(
*     property="status",
*     type="boolean",
*     example=true
*   ),
*   @OA\Property(
*     property="created_at",
*     type="string",
*     example="2021-01-29T23:21:13.000000Z"
*   ),
*   @OA\Property(
*     property="updated_at",
*     type="string",
*     example="2021-01-29T23:21:13.000000Z"
*   ),
* )
*/
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
