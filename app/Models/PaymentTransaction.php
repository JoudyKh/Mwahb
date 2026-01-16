<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'phone_number',
        'section_id',
        'coupon_id',
        'amount',
        'total_amount',
        'status',
        'otp',
        'coupon_discount',
    ];
    const SUCCESS_STATUS = 'success';
    const FAILED_STATUS = 'failed';
    const PENDING_STATUS = 'pending';


    protected $appends = [
        'provider_response'
    ];

    public function getProviderResponseAttribute()
    {
        $response = $this->requests()->where('api', 'paymentConfirmation')->orderByDesc('id')
            ->first()?->response;
        if ($response) {
            return json_decode($response, true);
        }
        return null;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function requests()
    {
        return $this->hasMany(TransactionSyRequest::class, 'transaction_id');
    }
}
