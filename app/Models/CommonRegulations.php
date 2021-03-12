<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonRegulations extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_id';
    protected $table = 'common_regulations';
    protected $fillable = [
        'room_id',
        'user_id',
        'filename'
    ];
    public $timestamps = true;
}
