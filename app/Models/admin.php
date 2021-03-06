<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\admin as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class admin extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
        'email',
        'password',
        'emailverified',
        'mobilePhone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];


    public function getJWTIdentifier()
    {
        return $this->getKey();

    }//end getJWTIdentifier()


    public function getJWTCustomClaims()
    {
        return [];

    }//end getJWTCustomClaims()


    public function todos()
    {
        return $this->hasMany(Todo::class, 'created_by', 'id');

    }//end todos()


}//end class
