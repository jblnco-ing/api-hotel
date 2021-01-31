<?php
 /**
 * @OA\Tag(
 *   name="Room.Record",
 *   description="Operaciones relacionadas con las habitaciones",
 * )
 */
namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\ApiController;
use App\Room;
use Illuminate\Http\Request;

class RoomRecordController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"Room.Record"},
     *     path="/api/auth/room/{$room}/records",
     *     summary="Un usuario admin o empleado puede ver los records de una habitación",
     *     @OA\Parameter(
     *         name="$room",
     *         in="path",
     *         description="Id de la habitación",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra los records de la habitación.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                    @OA\Items(
     *                      ref="#/components/schemas/record"
     *                    )
     *                  ),
     *              ), 
     *         )
     *     ),
     * )
     */
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
     * @OA\Get(
     *     tags={"Room.Record"},
     *     path="/api/auth/room/{$room}/records/{record}",
     *     summary="Un usuario admin o empleado puede ver un record de una habitación",
     *     @OA\Parameter(
     *         name="$room",
     *         in="path",
     *         description="Id de la habitación",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="$record",
     *         in="path",
     *         description="Id del record",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra el record de la habitación.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                      ref="#/components/schemas/record"
     *                  ),
     *              ), 
     *         )
     *     ),
     * )
     */
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
