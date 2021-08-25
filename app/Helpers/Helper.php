<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Source;

function unique_str($lenght)
{
    $uniqueStr = Str::random($lenght);
    while (Source::where('token', $uniqueStr)->exists()) {
        $uniqueStr = Str::random($lenght);
    }
    return $uniqueStr;
}
