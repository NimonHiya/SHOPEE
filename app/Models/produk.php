<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Fields that are mass assignable
    protected $fillable = ['kode_produk', 'nama', 'harga', 'stok', 'id_kategori', 'photo'];

    // Define relationship with Kategori model
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Optionally, add an accessor or mutator for the photo
    public function getPhotoUrlAttribute()
    {
        return asset('storage/' . $this->photo);
    }
}
