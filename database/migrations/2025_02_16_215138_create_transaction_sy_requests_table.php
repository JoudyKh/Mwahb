<?php

use App\Models\PaymentTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_sy_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaymentTransaction::class,'transaction_id')->constrained()->onDelete('cascade');
            $table->string('api');
            $table->text('payload')->nullable();
            $table->text('response')->nullable();
            $table->boolean('via_cron')->default(0);    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
