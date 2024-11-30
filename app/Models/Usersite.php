<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usersite extends Model
{
    use HasFactory;
    use SoftDeletes; 

    protected $guarded = [];

    # SITES IN TREE STRUCTURE
    public static function getSiteTree($filterOptions = [])
    {
        $siteArray = [];
        if(isset($filterOptions['parentId']))
        {
            $sites = self::where('parentid', '=', $filterOptions['parentId'])->orderBy('ordernr', 'ASC')->get();
        }
        else
        {
            $sites = self::whereNull('parentid')->orderBy('ordernr', 'ASC')->get();
        }
        foreach($sites as $site)
        {
            $filterOptions['parentId'] = $site->id;
            $siteArray[$site->id] = 
            [
                'siteData' => $site->toArray(),
                'subSites' => self::getSiteTree($filterOptions)
            ];
        }
        return $siteArray;
    }
    ############################################
    public function content(): BelongsTo
    {
        return $this->BelongsTo(Content::class);
    }
    public function siteblocks(): HasMany
    {
        return $this->HasMany(Siteblock::class)->orderBy('sort');;
    }
    public function team(): BelongsTo
    {
        return $this->BelongsTo(Team::class);
    }
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
