<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Support\Str;

class LinkService
{
    /**
     * Recursively generates unique hash.
     */
    public static function generateRandomUniqueHash(int $length = 8): string
    {
        $randomString = Str::random($length);
        $hashIsNotUnique = Link::where('hash', $randomString)->exists();

        return $hashIsNotUnique
            ? self::generateRandomUniqueHash()
            : $randomString;
    }
}
