<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        "nama_resep",
        "deskripsi",
        "bahan",
        "langkah",
        "gambar",
    ];

    /**
     * image
     *
     * @return Attribute
     */

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => url('/storage/posts/' . $gambar),
        );
    }
}
