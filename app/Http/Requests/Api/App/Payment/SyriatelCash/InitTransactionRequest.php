<?php

namespace App\Http\Requests\Api\App\Payment\SyriatelCash;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Section;
use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

class InitTransactionRequest extends FormRequest
{
    protected bool $sectionIsFree = false;
    protected ?Coupon $internalCoupon = null;
    protected ?float $sectionPrice = null;
    protected ?float $sectionPriceAfterCouponDiscount = null;
    protected ?float $couponDiscount = null;
    protected ?float $couponId = null;


    public function validationData(): array
    {
        $data = parent::validationData();

        unset(
            $data['internalCoupon'],
            $data['sectionIsFree'],
            $data['sectionPriceAfterCouponDiscount'],
            $data['coupon_discount'],
            $data['section_price'],
            $data['coupon_id'],
        );

        return $data;
    }

    /**
     * Prepare the data for validation by computing additional values.
     */
    public function prepareForValidation(): void
    {
        $section = Section::find($this->get('section_id'));

        if ($section) {
            $this->sectionPrice = $section->price ?? 0;
            $this->sectionIsFree = $section->is_free;

            $discount = $section->discount ?? 0;
            $priceAfterDiscount = $this->sectionPrice - ($this->sectionPrice * ($discount / 100));

            if ($priceAfterDiscount == 0) {
                $this->sectionIsFree = true;
            } else {
                $couponCode = $this->input('coupon');
                $coupon = Coupon::where('coupon', $couponCode)->first();

                if ($coupon) {
                    $this->couponId=$coupon->id;
                    $this->internalCoupon = $coupon;
                    if ($coupon) {
                        $priceAfterCoupon = $coupon->result($priceAfterDiscount);
                        $this->couponDiscount = $priceAfterDiscount - $priceAfterCoupon;
                        if ($priceAfterCoupon == 0) {
                            $this->sectionIsFree = true;
                        }
                        $this->sectionPriceAfterCouponDiscount = $priceAfterCoupon;
                    }
                }
            }
            if (is_null($this->sectionPriceAfterCouponDiscount)) {
                $this->sectionPriceAfterCouponDiscount = $priceAfterDiscount;
            }
        }
    }

    /**
     * Getter for section price.
     */
    public function getSectionPrice(): ?float
    {
        return $this->sectionPrice;
    }
    /**
     * Getter for coupon id .
     */
    public function getCouponId(): ?float
    {
        return $this->couponId;
    }

    /**
     * Getter for the section price after coupon discount.
     */
    public function getSectionPriceAfterCouponDiscount(): ?float
    {
        return $this->sectionPriceAfterCouponDiscount;
    }

    /**
     * Getter for coupon discount.
     */
    public function getCouponDiscount(): ?float
    {
        return $this->couponDiscount;
    }

    /**
     * Getter for section free flag.
     */
    public function isSectionFree(): bool
    {
        return $this->sectionIsFree;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'phone_number' => 'required|digits:10',
            'section_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $course = Section::where([
                        'id' => $value,
                        'type' => Constants::SECTION_TYPE_COURSES,
                    ])->first();

                    if (!$course) {
                        $fail("Course with id $value does not exist.");
                        return;
                    }

                    if (!$course->lessons()->first()) {
                        $fail(__('messages.section_has_no_lessons'));
                        return;
                    }
                    
                    if(auth('sanctum')->user()->sections()->where('sections.id',$value)->exists()){
                        $fail(__('messages.already_subscribed'));
                        return;
                    }

                }
            ],
            'coupon' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // If a coupon code is provided but wasn't found internally.
                    if ($value && !$this->internalCoupon) {
                        $fail(__('messages.coupon_does_not_exists'));
                        return;
                    }

                    if ($this->internalCoupon) {
                        if (
                            $this->internalCoupon->expires_at !== null &&
                            Carbon::parse($this->internalCoupon->expires_at)->isPast()
                        ) {
                            $fail(__('messages.coupon_is_expired'));
                            return;
                        }
                        if (
                            $this->internalCoupon->usage_limit !== null &&
                            $this->internalCoupon->usage_limit <= 0
                        ) {
                            $fail(__('messages.coupon_limit_is_done'));
                            return;
                        }
                    }
                }
            ]
        ];
    }
}
