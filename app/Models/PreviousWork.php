<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreviousWork extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'category'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
