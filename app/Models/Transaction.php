<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'customer_name',
        'customer_contact',
        'quantity',
        'total_price',
        'payment_status',
        'transaction_status',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'integer',
        'payment_status' => \App\Enums\PaymentStatus::class,
        'transaction_status' => \App\Enums\TransactionStatus::class
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
