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
            'pending'  => ['label' => 'Menunggu', 'color' => '#f59e0b'],
            'paid'     => ['label' => 'Lunas', 'color' => '#10b981'],
            'failed'   => ['label' => 'Gagal', 'color' => '#ef4444'],
            'refunded' => ['label' => 'Dikembalikan', 'color' => '#8b5cf6'],
            default    => ['label' => 'Unknown', 'color' => '#6b7280'],
        };
    }
}
