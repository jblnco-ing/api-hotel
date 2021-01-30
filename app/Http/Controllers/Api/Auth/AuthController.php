<?php

/**
 * @OA\Tag(
 *   name="Auth",
 *   description="Operaciones sobre signup, login y logout.",
 * )
 *
 * @OA\Schema(
 *   schema="token",
 *   @OA\Property(
 *     property="access_token",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="token_type",
 *     type="string"
 *   ),
 *   @OA\Property(
 *     property="expires_at",
 *     type="string"
 *   )
 * )
 *
 * @OA\Schema(
 *   schema="message",
 *   @OA\Property(
 *     property="message",
 *     type="string"
 *   )
 * )
 */
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends ApiController
{

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/api/auth/signup",
     *     summary="Un usuario puede registrarse como cliente.",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name","email","password"},
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "Jon Doe", "email": "jon@doe.com", "password": "secret"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registra el usuario y muestra un mensaje.",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/message"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Un error a ocurrido."
     *     )
     * )
     */
    
     /**
     * Store a newly created user with role client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole('Client');

        return $this->showOneData([
            'message' => 'Successfully created user!'
        ]);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     path="/api/auth/login",
     *     summary="Un usuario puede iniciar sección.",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"email","password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "jon@doe.com", "password": "secret"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicia la sección del usuario y devuelve un token, su tipo y tiempo de expiración.",
     *          @OA\JsonContent(
     *               @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/token"
     *              ),             
     *         ) 
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos invalidos.",
     *        @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/error"
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Un error a ocurrido."
     *     )
     * )
     */

    /**
     * Login a user and get a token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return $this->errorResponse([
                'message' => 'The email or password is incorrect'
            ], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return $this->showOneData([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * @OA\Get(
     *     tags={"Auth"},
     *     path="/api/auth/logout",
     *     summary="Un usuario puede cerrar sección.",
     *      security={{"bearerAuth":{}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="Cierra la sección del usuario y muestra un mensaje.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                    ref="#/components/schemas/message"
     *              ), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No esta Autenticado.",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/message"
     *         )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Un error a ocurrido."
     *     )
     * )
     */
    
     /**
     * Close a user session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
   */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->showOneData([
            'message' => 'Successfully logged out'
        ]);
    }
}