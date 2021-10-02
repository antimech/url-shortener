<?php

namespace App\Services;

use App\Link;
use Illuminate\Support\Str;

class LinkService
{
    /**
     * Recursively generates unique hash.
     *
     * @param int $length
     * @return string
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
