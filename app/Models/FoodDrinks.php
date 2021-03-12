<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodDrinks extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_id';
    protected $table = 'food_drinks';
    protected $fillable = [
        'room_id',
        'user_id',
        'filename',
        'description',
        'price'
    ];
    public $timestamps = true;
}
