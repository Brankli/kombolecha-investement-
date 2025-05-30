<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'about', 'email', 'adress', 'phone_no', 'mission', 'vision'];
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
