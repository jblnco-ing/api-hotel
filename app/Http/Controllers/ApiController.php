<?php
/**
* @OA\Info(title="API Auth", version="1.0")
* @OA\Server(
*      url="http://127.0.0.1:8000/",
*      description="Local Server"
* )
* @OA\Server(
*    url="http://127.0.0.1:8000/",
*    description="Heroku Server"
* )
*/

/** @OA\SecurityScheme(
*      securityScheme="bearerAuth",
*      in="header",
*      name="bearerAuth",
*      type="http",
*      scheme="bearer",
*      bearerFormat="JWT",
* ),
*/
/**
 *     @OA\Response(
 *         response="InvalidData",
 *         description="Datos invalidos.",
 *        @OA\JsonContent(
 *              @OA\Property(
 *                  property="data",
 *                  ref="#/components/schemas/error"
 *              ),
 *         )
 *     ),
 *     @OA\Response(
 *         response="Unauthenticated",
 *         description="No esta Autenticado.",
 *          @OA\JsonContent(
 *              ref="#/components/schemas/message"
 *         )
 *     ),
 *     @OA\Response(
 *         response="Default",
 *         ref="#/components/responses/Default"
 *     )
 */
namespace App\Http\Controllers;

use App\Traits\ApiResponser;

class ApiController extends Controller
{
    use ApiResponser;
}
