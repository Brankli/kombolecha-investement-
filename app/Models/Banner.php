<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    protected $fillable = ['image'];

    use HasFactory;
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
