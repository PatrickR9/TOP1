<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EditorialMember extends Model
{
    use HasFactory;
    use SoftDeletes;public function team(): BelongsTo
     {
         return $this->BelongsTo(Team::class);
     }
     public function editorial(): BelongsTo
     {
         return $this->BelongsTo(Editorial::class);
     }
     public function user(): BelongsTo
     {
         return $this->BelongsTo(Users::class);
     }
}
