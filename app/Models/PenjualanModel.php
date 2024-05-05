<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanModel extends Model
{
    use HasFactory;
    protected $table = 't_penjualan'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'penjualan_id'; //Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = [
        'penjualan_id',
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function detail(): HasMany
    {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }

    protected function image(): Attribute
    { 
        return Attribute::make( 
            get: fn ($image) => url('/storage/posts/' . $image), 
        ); 
    }
}