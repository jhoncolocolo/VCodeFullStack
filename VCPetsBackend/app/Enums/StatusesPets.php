<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum StatusesPets: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function getValues() : Array
    {
        return [
            self::AVAILABLE->value,
            self::PENDING->value,
            self::SOLD->value
        ];
    }


    public static function IsValidOption($option) : bool
    {
        return in_array($option, self::getValues());
    }
}