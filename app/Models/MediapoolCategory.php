<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediapoolCategory extends Model
{
    use HasFactory;

    public function organisation(): BelongsTo
    {
        return $this->BelongsTo(Organisation::class);
    }

}
