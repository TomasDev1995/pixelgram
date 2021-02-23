<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    protected $table = 'coments';

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'images_id');
    }
}
