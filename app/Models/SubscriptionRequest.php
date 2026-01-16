<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'section_id',
        'user_id' , // student_id
        'status',
        'coupon_id',
        'reject_reason'
    ];
    
    protected $with = ['section' , 'student' , 'coupon'] ;

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class ,'section_id');
    }
    public function coupon():BelongsTo
    {
        return $this->belongsTo(Coupon::class,'coupon_id');
    }
}
