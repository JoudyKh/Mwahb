<?php

namespace App\Http\Controllers\Api\General\Course;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Services\Admin\Section\SectionService;
use App\Services\General\Payment\SyriatelCash\SyriatelCashService;
use App\Http\Requests\Api\App\Payment\SyriatelCash\CheckTransactionOTPRequest;
use App\Http\Requests\Api\App\Payment\SyriatelCash\InitTransactionRequest;
use App\Http\Requests\Api\App\Payment\SyriatelCash\ResendTransactionOTPRequest;

class CoursePurchaseController extends Controller
{
    public function __construct(protected SyriatelCashService $syriatelCashService)
    {
    }

    /**
     * @OA\Get(
     *     path="/admin/payment/syriatel/transactions",
     *     summary="Get all courses",
     *     tags={"Admin", "Admin - Payment - SyriatelCash"},
     *     security={{ "bearerAuth": {} ,"lmsAuth": {}, "Accept": "application/json" }},
     *     @OA\Parameter(
     *         name="student_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="Filter  by student id "
     *     ),
     *      @OA\Parameter(
     *         name="section_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="Filter  by section id "
     *     ),
     *      @OA\Parameter(
     *         name="phone_number",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="Filter by phone number"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        return success($this->syriatelCashService->getAllTransactions());
    }

    /**
     * @OA\Post(
     *     path="/courses/buy/otp",
     *     summary="Send OTP for SyriatelCash user",
     *     tags={"App", "App - Payment - SyriatelCash"},
     *     security={{ "bearerAuth": {} ,"lmsAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone_number",
     *                 type="string",
     *                 description="User phone number",
     *                 example="0967213544"
     *             ),
     *             @OA\Property(
     *                 property="section_id",
     *                 type="string",
     *                 description="The course id to buy",
     *                 example="9"
     *             ),
     *             @OA\Property(
     *                 property="coupon",
     *                 type="string",
     *                 description="Coupon code if applicable",
     *                 example="1234567dw"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function sendSyriatelCashOTP(InitTransactionRequest $request)
    {
        try {
            $result = $this->syriatelCashService->initiatePaymentTransaction([
                'user_id' => auth('sanctum')->id(),
                'phone_number' => $request->phone_number,
                'section_id' => $request->section_id,
                'coupon_id' => $request->getCouponId(),
                'amount' => $request->getSectionPrice(),// main price 
                'total_amount' => $request->getSectionPriceAfterCouponDiscount(),//paid final price
                'coupon_discount' => $request->getCouponDiscount(),
            ]);
            return success($result);
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/courses/buy/otp/check",
     *     summary="Check OTP for SyriatelCash payment confirmation",
     *     tags={"App", "App - Payment - SyriatelCash"},
     *     security={{ "bearerAuth": {} ,"lmsAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="otp",
     *                 type="string",
     *                 description="OTP received by the user",
     *                 example="123456"
     *             ),
     *             @OA\Property(
     *                 property="transaction_id",
     *                 type="string",
     *                 description="Transaction ID returned by the payment request",
     *                 example="4"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function checkSyriatelCashOTP(CheckTransactionOTPRequest $request)
    {
        try {
            $transaction = PaymentTransaction::where('transaction_id', $request->transaction_id)->first();
            $result = $this->syriatelCashService->confirmPaymentTransaction($request->otp, $transaction);
            return success($result);

        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }

    /**
     * @OA\Post(
     *     path="/courses/buy/otp/resend",
     *     summary="Resend OTP for SyriatelCash payment",
     *     tags={"App", "App - Payment - SyriatelCash"},
     *     security={{ "bearerAuth": {} ,"lmsAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="transaction_id",
     *                 type="string",
     *                 description="Transaction ID for which OTP needs to be resent",
     *                 example="4"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function resendSyriatelCashOTP(ResendTransactionOTPRequest $request)
    {
        try {
            $this->syriatelCashService->resendSyriatelCashOTP($request->transaction_id);
            return success();
        } catch (\Exception $e) {
            return error($e->getMessage(), [$e->getMessage()], $e->getCode());
        }
    }
}
