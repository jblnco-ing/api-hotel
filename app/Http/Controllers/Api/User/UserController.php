<?php
 /**
 * @OA\Tag(
 *   name="User",
 *   description="Operaciones relacionadas con el usuario",
 * )
 */
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * @OA\Get(
     *     tags={"User"},
     *     path="/api/auth/users/self",
     *     summary="Un usuario puede ver sus datos.",
     *      security={{"bearerAuth":{}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="Muestra los datos del usuario.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                    ref="#/components/schemas/user"
     *              ), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/Unauthenticated"
     *         
     *     ),
     *     @OA\Response(
     *         response="default",
     *         ref="#/components/responses/Default"
     *     )
     * )
     */
    /**
     * Display the user of the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function self(Request $request)
    {
        return $this->showOne($request->user());
    }
    /**
     * @OA\Get(
     *     tags={"User"},
     *     path="/api/auth/users/",
     *     summary="Un usuario admin o empleado puede ver los usuarios.",
     *     operationId="user.index",
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="Muestra todos usuarios.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                    @OA\Items(
     *                      ref="#/components/schemas/user"
     *                    )
     *                  ),                 
     *              ), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/Unauthenticated"
     * 
     *     ),
     *     @OA\Response(
     *         response="default",
     *         ref="#/components/responses/Default"
     *     )
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return $this->showAll($users);
    }

    /**
     * @OA\Post(
     *     tags={"User"},
     *     path="/api/auth/users/",
     *     summary="Un usuario admin o empleado puede crear empleados.",
     *      security={{"bearerAuth":{}}},
     *     operationId="user.store",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 ref="#/components/schemas/new_user",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Crea un nuevo empleado.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                      ref="#/components/schemas/user"
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
        // if($user->hasRole('Employee'))

        $rules=[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ];
        $data = $request->validate($rules);
        $data['password'] = bcrypt($data['password']);

        $user=User::create($data);
        $user->assignRole('Employee');
        return $this->showOneData('Successfully created user!');
    }

    /**
     * @OA\Get(
     *     tags={"User"},
     *     path="/api/auth/users/{id}",
     *     summary="Un usuario admin o empleado puede ver los datos de un usuario.",
     *     security={{"bearerAuth":{}}}, 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id del usuario",
     *         required=true,
     *         @OA\Schema(
     *              type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Muestra el dato del usuario.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                      ref="#/components/schemas/user"
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
        $user=User::find($id);
        return $this->showOne($user);
    }

}
