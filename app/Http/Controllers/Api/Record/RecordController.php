<?php
/**
 * @OA\Tag(
 *   name="Record",
 *   description="Operaciones para manejar los records de las habitaciones y los usuarios",
 * )
 * @OA\Schema(
 *   schema="error",
 *   @OA\Property(
 *     property="error",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="code",
 *     type="string"
 *   )
 * )
 */


namespace App\Http\Controllers\Api\Record;

use App\Http\Controllers\ApiController;
use App\Record;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
class RecordController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"Record"},
     *     path="/api/record/",
     *     summary="Usuario admin o empleado puede ver los records.",
     *     operationId="record.index",
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todos los records.",
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $record=Record::all();
        return $this->showAll($record);
    }

    /**
     * @OA\Post(
     *     tags={"Record"},
     *     path="/api/auth/record",
     *     summary="Un usuario admin o empleado puede crear el record de las habitaciones.",
     *     security={{"bearerAuth":{}}}, 
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"room_id","date_in","date_out","user_id"},
     *                 @OA\Property(
     *                    property="room_id",
     *                    type="integer",
     *                    example=1
     *                  ),
     *                  @OA\Property(
     *                    property="date_in",
     *                    type="string",
     *                    example="2021/02/26"
     *                  ),
     *                  @OA\Property(
     *                    property="date_out",
     *                    type="string",
     *                    example="2021/02/26"
     *                  ),
     *                  @OA\Property(
     *                    property="status",
     *                    type="boolean",
     *                    example=true
     *                  ),
     *                  @OA\Property(
     *                    property="user_id",
     *                    type="array",
     *                    @OA\Items(
     *                      type="integer",
     *                      example=4,
     *                      minimum=1
     *                    )
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Crea un record de una habitación con los usuarios que la ocuparan.",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/record"
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

        $message_error=$this->validateRequestRecord($request);
        
        if ($message_error)
        return $this->errorResponse($message_error,400);

        $record=Record::create([
            'room_id' => $request->input('room_id'),
            'date_in' => $request->input('date_in'),
            'date_out' => $request->input('date_out'),
            'status' => $request->input('status',1),
            'update_by' => $request->user()->id,
        ]);
        $record->users()->attach($request->input('user_id'));
        $record=Record::with('users')->find($record->id);
        return $this->showOne($record);
    }

    /**
     * @OA\Put(
     *     tags={"Record"},
     *     path="/api/auth/record/{record}",
     *     summary="Un usuario admin o empleado puede crear el record de las habitaciones.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="record",
     *         in="path",
     *         description="Id del record que se quiere actualizar",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"room_id","date_in","date_out","user_id"},
     *                 @OA\Property(
     *                    property="room_id",
     *                    type="integer",
     *                    example=1
     *                  ),
     *                  @OA\Property(
     *                    property="date_in",
     *                    type="string",
     *                    example="2021/02/26"
     *                  ),
     *                  @OA\Property(
     *                    property="date_out",
     *                    type="string",
     *                    example="2021/02/26"
     *                  ),
     *                  @OA\Property(
     *                    property="status",
     *                    type="boolean",
     *                    example=true
     *                  ),
     *                  @OA\Property(
     *                    property="user_id",
     *                    type="array",
     *                    @OA\Items(
     *                      type="integer",
     *                      example=4,
     *                      minimum=1
     *                    )
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Actualiza un record de una habitación con los usuarios que la ocuparan.",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/record"
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
        
        $message_error=$this->validateRequestRecord($request, $record->id);
        
        if ($message_error)
        return $this->errorResponse($message_error,400);
        
        $record->update([
            'room_id' => $request->input('room_id'),
            'date_in' => $request->input('date_in'),
            'date_out' => $request->input('date_out'),
            'status' => $request->input('status',1),
            'update_by' => $request->user()->id,
        ]);
        $record->users()->sync($request->input('user_id'));
        $record=Record::with('users')->find($record->id);
        return $this->showOneData($record);
    }
    
    /**
     * @OA\Delete(
     *     tags={"Record"},
     *     path="/api/auth/record/{record}",
     *     summary="Un usuario admin puede eiminar un record.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="record",
     *         in="path",
     *         description="Id del record",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Elimina el record.", 
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
     * @param  Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $record->delete();
        return response('',201);
    }

    /**
     * Returns a message if a condition is met else returns false.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $record_id
     * @return string
     */
    private function validateRequestRecord(Request $request, $record_id=null)
    {
        $room_id=$request->input('room_id');
        $user_id=$request->input('user_id');
        $date_in=Carbon::parse($request->input('date_in'));
        $date_in=Carbon::parse($request->input('date_in'));
        $date_out=Carbon::parse($request->input('date_out'));
        
        if (Carbon::now()->gte($date_in))
        return 'The check-in date must be greater than or equal to the current date';
        if ($date_in->gt($date_out))
        return 'Check-out date must be greater than check-in date';
        
        $room=Room::find($room_id);
        
        if ($room->capacity < sizeof($user_id))
        return "The room does not have the capacity for all users. Capacity: $room->capacity";

        $areAvailable=Record::areAvailableDates($date_in,$date_out,$room_id,$record_id);

        if (!$areAvailable)
        return 'this room is not available for those dates';

        return false;
    }

}
            