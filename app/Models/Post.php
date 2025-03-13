<?php

namespace App\Models;

use App\Models\Scopes\IsActive;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([IsActive::class])]
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_active',
        'title',
        'content',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
