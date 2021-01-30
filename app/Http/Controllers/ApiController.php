<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
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

class ApiController extends Controller
{
    use ApiResponser;
}
