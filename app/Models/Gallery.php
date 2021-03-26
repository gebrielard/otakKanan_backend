<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $fillable = [
        'room_id',
        'user_id',
        'filename'
    ];
    public $timestamps = true;
}
