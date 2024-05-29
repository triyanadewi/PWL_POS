<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\URL;

class UserModel extends Authenticatable implements JWTSubject
{

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = [ 
        'username', 
        'nama', 
        'password', 
        'level_id', 
        'image'//tambahan 
    ]; 
 
    public function level() 
    { 
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id'); 
    } 
    // protected function image(): Attribute
    // { 
    //     return Attribute::make( 
    //         get: fn ($image) => url('/storage/posts/' . $image), 
    //     ); 
    // }
}
