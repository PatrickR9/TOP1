<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibleVersion extends Model
{
    use HasFactory;

    public function bibleBooks()
    {
        return $this->hasMany(BibleBook::class);
    }
}
