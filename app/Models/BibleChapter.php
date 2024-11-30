<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibleChapter extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bibleBook()
    {
        return $this->belongsTo(BibleBook::class);
    }

    public function bibleVerses()
    {
        return $this->hasMany(BibleVerse::class);
    }
}
