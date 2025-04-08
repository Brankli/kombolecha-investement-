<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepartmentContent extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'profile', 'email', 'phone_no', 'mission', 'vision', 'goal', 'position'];
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
