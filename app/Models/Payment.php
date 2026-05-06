<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'method', 'bank_name', 'account_number',
        'account_name', 'amount', 'proof_image', 'status', 'paid_at', 'notes',
    ];

    protected $casts = ['paid_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'  => ['label' => 'Menunggu', 'color' => 'yellow'],
            'paid'     => ['label' => 'Lunas', 'color' => 'green'],
            'failed'   => ['label' => 'Gagal', 'color' => 'red'],
            'refunded' => ['label' => 'Dikembalikan', 'color' => 'purple'],
            default    => ['label' => 'Unknown', 'color' => 'gray'],
        };
    }
}
