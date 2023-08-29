<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    //table
    protected $table = 'posts';
    //primary keys
    public $primaryKey = 'id';

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
