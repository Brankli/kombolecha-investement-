<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class staff extends Model
{
    use HasFactory,softDeletes;
    protected $fillable = [
        'name',
        'position',
        'phone',
        'email',
        'user_id',
        'dep_id',
        'image'
    ];
    public function department(){
        return $this->belongsTo(DepartmentContent::class,'dep_id');
    }
    public function admin(){
        return $this->belongsTo(User::class,'user_id');
    }
}
