<?php

namespace App\Enums;

enum CouponTypeEnum:string
{
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';
    public static function all():array
    {
        return array_column(self::cases(),'value');
    }
}
