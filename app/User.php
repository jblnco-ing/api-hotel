<?php
/**
* @OA\Schema(
*  schema="user",
*  @OA\Property(
*     property="id",
*     type="integer",
*     example=1
*   ),
*   @OA\Property(
*     property="name",
*     type="string",
*     example="Emil Weimann"
*   ),
*   @OA\Property(
*     property="email",
*     type="string",
*     example="zena44@example.org"
*   ),
*   @OA\Property(
*     property="email_verified_at",
*     type="string",
*     example="2021-01-29T23:21:13.000000Z"
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

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function records()
    {
        return $this->belongsToMany(Record::class);
    }
}
