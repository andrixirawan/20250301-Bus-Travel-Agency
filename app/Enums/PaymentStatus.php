<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu Pembayaran',
            self::PAID => 'Sudah Dibayar',
            self::EXPIRED => 'Kadaluarsa',
            self::FAILED => 'Gagal',
            self::REFUNDED => 'Dikembalikan'
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::PAID => 'green',
            self::EXPIRED => 'gray',
            self::FAILED => 'red',
            self::REFUNDED => 'blue'
        };
    }
} 