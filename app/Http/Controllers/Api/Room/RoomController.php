<?php
 /**
 * @OA\Tag(
 *   name="Room",
 *   description="Operaciones relacionadas con las habitaciones",
 * )
 */
namespace App\Http\Controllers\Api\Room;

use App\Http\Controllers\ApiController;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"Room"},
     *     path="/api/rooms/",
     *     summary="Cualquiera puede ver las habitaciones.",
     *     operationId="room.index",
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todas las habitciones.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                    @OA\Items(
     *                      ref="#/components/schemas/room"
     *                    )
     *                  ),
     *              ), 
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         ref="#/components/responses/Default"
     *     ),
     * )
     */
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
     * @OA\Post(
     *     tags={"Room"},
     *     path="/api/auth/rooms/",
     *     summary="Un usuario admin puede crear una habitación.",
     *      security={{"bearerAuth":{}}},
     *     operationId="room.store",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/new_room",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Crea una nueva habitación.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                      ref="#/components/schemas/room"
     *                  ),                 
     *              ), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         ref="#/components/responses/InvalidData"
     *     ),
     * )
     */
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
     * @OA\Get(
     *     tags={"Room"},
     *     path="/api/rooms/{id}",
     *     summary="Cualquiera puede ver una habitación",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la habitación",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra el dato de la habitación.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                      ref="#/components/schemas/room"
     *                  ),                 
     *              ), 
     *         )
     *     ),
     * )
     */
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
     * @OA\Put(
     *     tags={"Room"},
     *     path="/api/auth/rooms/{id}",
     *     summary="Un usuario admin o empleado puede actualizar la habitación.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la habitación",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  ref="#/components/schemas/new_room"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Actualiza la habitación.",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/room"
     *              ),             
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=400,
     *         ref="#/components/responses/InvalidData"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         ref="#/components/responses/Default"
     *     )
     * )
     */    
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
     * @OA\Delete(
     *     tags={"Room"},
     *     path="/api/auth/rooms/{id}",
     *     summary="Un usuario admin puede eiminar una habitación.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id de la habitación",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  ref="#/components/schemas/new_room"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Elimina la habitación.", 
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         ref="#/components/responses/Default"
     *     )
     * )
     */
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
