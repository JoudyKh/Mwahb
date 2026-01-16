<?php

namespace App\Console\Commands;

use App\Models\PaymentTransaction;
use App\Services\General\Payment\SyriatelCash\SyriatelCashService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class RetryFailedSYTransactions extends Command
{
    public function __construct(protected SyriatelCashService $syriatelCashService)
    {
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:retry-failed-sy-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'retry any transaction otp check response if any network issue happened';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $transactions = PaymentTransaction::
            where('status', PaymentTransaction::PENDING_STATUS)
            ->whereNotNull('otp')
            ->take(50)
            ->get();

        foreach ($transactions as $key => $transaction) {
            $otp = Crypt::decryptString($transaction->otp);
            $this->syriatelCashService->confirmPaymentTransaction($otp, $transaction, true);
        }

    }
}
