<?php

namespace App\Models;

use App\Enums\CouponTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Nette\NotImplementedException;

class Coupon extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'coupon',
        'amount',
        'expires_at',
        'usage_limit',
        'type',
    ];

    public function result(int|null $sectionPrice):float
    {
        if($sectionPrice === null)return 0;

        if($this->type == CouponTypeEnum::PERCENTAGE->value){
            return $sectionPrice - ($this->amount * $sectionPrice) / 100 ;
        }

        if($this->type == CouponTypeEnum::FIXED->value){
            return max( 0 , $sectionPrice - $this->amount) ;
        }

        throw new NotImplementedException();
    }
}
