<?php

namespace App\Http\Requests\Api\App\Payment\SyriatelCash;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Section;
use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;



class ResendTransactionOTPRequest extends FormRequest
{
    private bool $sectionIsFree = false;
    // public function prepareForValidation(): void
    // {
    //     $section = Section::where('id', $this->get('section_id'))->first();

    //     if ($section) {
    //         $this->sectionIsFree = $section->is_free;

    //         $sectionPriceAfterDiscount = ($section?->price ?? 0) - (($section?->price ?? 0) * (($section->discount ?? 0) / 100));

    //         if ($sectionPriceAfterDiscount == 0) {
    //             $this->sectionIsFree = true;
    //         } else {
    //             $coupon = Coupon::where('coupon', $this->get('coupon'))->first();
    //             $this->merge([
    //                 'coupon' => $coupon,
    //             ]);
    //             if ($coupon) {
    //                 $sectionPriceAfterCouponDiscount = $coupon->result($sectionPriceAfterDiscount);

    //                 if ($sectionPriceAfterCouponDiscount == 0) {
    //                     $this->sectionIsFree = true;
    //                 }
    //             }
    //         }
    //     }
    // }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id' => 'required',
        ];
    }
}
