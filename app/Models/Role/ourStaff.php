<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ourStaff extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];
}
