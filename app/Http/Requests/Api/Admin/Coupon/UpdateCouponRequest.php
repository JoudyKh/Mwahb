<?php

namespace App\Http\Requests\Api\Admin\Coupon;

use App\Enums\CouponTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateCouponRequest",
 *     type="object",
 *     @OA\Property(property="type", type="string",enum={"percentage","fixed"}),
 *     @OA\Property(property="coupon", type="string", maxLength=255),
 *     @OA\Property(property="amount", type="integer", minimum=0, maximum=100),
 *     @OA\Property(property="expires_at", type="string", format="date-time"),
 *     @OA\Property(property="usage_limit", type="integer", minimum=1, description="Maximum number of times the coupon can be used"),
 * )
 */
class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['string', Rule::in(CouponTypeEnum::all())],
            'amount' => ['sometimes', 'integer', 'min:0', Rule::when($this->input('type') == CouponTypeEnum::PERCENTAGE->value , 'max:100')],
            'coupon' => ['sometimes', 'string', 'max:255', Rule::unique('coupons')->whereNull('deleted_at')->ignore($this->coupon)],
            'expires_at' => ['sometimes', 'date', 'after:today'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
