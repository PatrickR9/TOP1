<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organisation extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    
     protected $guarded = [];

     public function contents(): HasMany
     {
         return $this->HasMany(Content::class);
     }
     public function contracts(): HasMany
     {
         return $this->HasMany(Contract::class);
     }
     public function editorials(): HasMany
     {
         return $this->HasMany(Editorial::class);
     }
     public function mediapool_categories(): HasMany
     {
         return $this->HasMany(MediapoolCategory::class);
     }
     public function organisation_categories(): HasMany
     {
         return $this->HasMany(OrganisationCategory::class);
     }
}
