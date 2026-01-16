<?php

namespace App\Models;

use App\Constants\EliteInfo;
use App\Constants\TheqaInfo;
use App\Constants\MawahbInfo;
use App\Constants\KhrejeenInfo;
use Illuminate\Support\Facades\App;
use SebastianBergmann\Type\VoidType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'super_key',
        'key',
        'value',
    ];

    public static function initialize()
    {
        self::$imageKeys = MawahbInfo::$imageKeys;
        self::$videoKeys = MawahbInfo::$videoKeys;
        self::$fileKeys = MawahbInfo::$fileKeys;
        self::$info = MawahbInfo::$infos;
        self::$rules = MawahbInfo::$rules;
        self::$translatableKeys = MawahbInfo::$translatableKeys;
        self::$commaSepratadKeys = MawahbInfo::$commaSepratadKeys;
    }

    public static array $info = [];
    public static array $rules = [];
    public static array $imageKeys = [];
    public static array $videoKeys = [];
    public static array $fileKeys = [];
    public static array $translatableKeys = [];
    public static array $commaSepratadKeys = [];

    public function value(): Attribute
    {
        return Attribute::make(

            get: function (mixed $value, array $attributes) {

                if (in_array($attributes['key'], static::$commaSepratadKeys)) {
                    return explode(',', $value);
                }
                if (in_array($attributes['super_key'] . '-' . $attributes['key'], static::$translatableKeys)) {
                    return json_decode($value, true);
                }
                return $value;
            },

            set: function (mixed $value, array $attributes) {

                if (in_array($attributes['key'], static::$commaSepratadKeys)) {
                    return implode(',', $value);
                }
                if (in_array($attributes['key'], static::$translatableKeys)) {
                    return json_encode($value, true) ?? $value;
                }
                return $value;
            }
        );
    }
}
