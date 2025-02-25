<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use App\Models\level;
use App\Models\Question;
use Illuminate\Support\Facades\Schema;
class User extends  Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getTableColumns()
    {
        return Schema::getColumnListing((new self())->getTable());
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }



    public function getJWTCustomClaims()
    {
        return [];
    }
    public function role(){
        return $this ->belongsTo('App\Models\Role','role_id');
    }

    public function levels()
    {
        return $this->hasMany(level::class,'user_id');
    }

    public function Questions()
    {
        return $this->hasMany(Question::class,'user_id');
    }
}
