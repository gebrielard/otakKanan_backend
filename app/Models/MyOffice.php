<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyOffice extends Model
{
    use HasFactory;
    
    protected $table = 'my_office';
    protected $fillable = [
        'user_id',
        'room_id'
    ];
    public $timestamps = true;
}
