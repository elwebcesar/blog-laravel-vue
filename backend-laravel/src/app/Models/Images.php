<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['id', 'path', 'name', 'desc', 'ext', 'mime', 'from_table', 'from_id', 'user_id'];


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
