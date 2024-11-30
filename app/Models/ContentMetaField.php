<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentMetaField extends Model
{
    use HasFactory;
    public function content2_meta_fields(): HasMany
    {
        return $this->HasMany(Content2MetaField::class)->orderBy('sort', 'asc');
    }
}
