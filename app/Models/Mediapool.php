<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mediapool extends Model
{
    use HasFactory;
    public function mediapool_category(): BelongsTo
    {
        return $this->BelongsTo(MediapoolCategory::class);
    }
    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
