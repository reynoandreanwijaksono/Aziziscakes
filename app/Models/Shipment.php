<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id', 'courier', 'service', 'tracking_number',
        'cost', 'estimated_days', 'status', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'shipped_at'   => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending'    => ['color' => '#f59e0b', 'label' => 'Pending'],
            'processing' => ['color' => '#3b82f6', 'label' => 'Diproses'],
            'shipped'    => ['color' => '#8b5cf6', 'label' => 'Dikirim'],
            'delivered'  => ['color' => '#10b981', 'label' => 'Terkirim'],
            default      => ['color' => '#888888', 'label' => ucfirst($this->status ?? 'Unknown')],
        };
    }

    public function getEstimatedDeliveryAttribute(): ?string
    {
        if (!$this->estimated_days) return null;
        $val = $this->estimated_days;
        // Avoid double "hari" if value already contains it
        if (!str_contains($val, 'hari')) {
            $val .= ' hari kerja';
        }
        return $val;
    }
}