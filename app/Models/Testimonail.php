<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonail extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'image','discribution'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
