<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Fields that are mass assignable
    protected $fillable = ['nama'];

    // Define relationship with Produk model
    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
