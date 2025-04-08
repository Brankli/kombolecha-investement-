<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncEvent extends Model
{
    use HasFactory;
    protected $fillable = ['event','image','type'];
}
