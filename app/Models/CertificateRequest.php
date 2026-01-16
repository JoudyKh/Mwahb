<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CertificateRequestStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'student_id' ,
        'course_id' ,
        'status' ,
        'file' ,
        'rejected_at' ,
        'accepted_at' ,
        'note' ,
    ] ;
    protected function casts(): array
    {
        return [
           'status' => CertificateRequestStatusEnum::class
        ];
    }

    // todo created at
    
    // public function getCreatedAtAttribute($value)
    // {
    //     if (is_null($value)) {
    //         return null;
    //     }

    //     return Carbon::parse($value)->format('Y-m-d');
    // }

    public function student():BelongsTo
    {
        return $this->belongsTo(User::class , 'student_id') ;
    }
    
    public function course():BelongsTo
    {
        return $this->belongsTo(Section::class , 'course_id') ;
    }
}