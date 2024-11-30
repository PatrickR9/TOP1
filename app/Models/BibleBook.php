<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibleBook extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bibleVersion()
    {
        return $this->belongsTo(BibleVersion::class);
    }

    public function bibleChapters()
    {
        return $this->hasMany(BibleChapter::class);
    }
}
