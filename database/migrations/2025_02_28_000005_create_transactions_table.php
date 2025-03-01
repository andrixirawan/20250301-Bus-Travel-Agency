<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_contact');
            $table->integer('quantity')->default(1);
            $table->integer('total_price');
            $table->string('payment_status')->default(PaymentStatus::PENDING->value);
            $table->string('transaction_status')->default(TransactionStatus::PENDING->value);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['payment_status', 'transaction_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
