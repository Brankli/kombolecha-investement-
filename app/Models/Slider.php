<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image',
    
        'order',
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
