<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPrice extends Model
{
    use HasFactory;
    
    protected $table = 'category_price';
    protected $fillable = [
        'room_id',
        'user_id',
        'name'
    ];
    public $timestamps = true;
    
}
