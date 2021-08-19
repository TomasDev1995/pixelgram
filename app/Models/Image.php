<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    public function comments(){
        return $this->hasMany(Comment::class, 'image_id')->orderBy('id','desc');
    }

    public function like(){
        return $this->hasMany(Like::class, 'image_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
