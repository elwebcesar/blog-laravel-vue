<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['id', 'status', 'title', 'content', 'slug', 'path', 'fc', 'user_id'];


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
