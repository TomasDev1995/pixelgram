<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public function comments(){
        return $this->hasMany(Coment::class, 'images_id');
    }

    public function like(){
        return $this->hasMany(Like::class, 'images_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
