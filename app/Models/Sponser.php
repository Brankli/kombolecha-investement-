<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sponser extends Model
{
    use HasFactory;
    protected $fillable = ['CompanyName', 'image',];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
