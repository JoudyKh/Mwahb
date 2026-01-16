<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSyRequest extends Model
{
    use HasFactory;
    protected $table = 'transaction_sy_requests';
    protected $fillable = [
        'transaction_id',
        'api',
        'response',
        'payload',
        'via_cron',
    ];
    public function transaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}
