<?php
namespace App\Traits;

use App\Models\Bundel;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
trait bundelsCache
{

    public static function setBundelsToCache()
    {

        if (Cache::get('bundels') == null) {
            Cache::remember('bundels', 60 * 60 * 24, function () {
                return Bundel::with(["expediteur:id,name", "livreur:id,name"])->get()->chunk(500);
            });
        }

    }

    public static function getBundelsCache()
    {
        bundelsCache::setBundelsToCache();
        $bundels = Cache::get("bundels") != null ? Cache::get('bundels') : [];

        return $bundels;
    }

    public static function removeBundelsCache()
    {
        Cache::forget('bundels');
    }
}
