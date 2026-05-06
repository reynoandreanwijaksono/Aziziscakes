<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'user_id', 'subtotal', 'shipping_cost',
        'discount_amount', 'total', 'promo_code', 'status',
        'shipping_address', 'shipping_city', 'shipping_province',
        'shipping_postal_code', 'shipping_phone', 'notes', 'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->invoice_number = 'INV-' . strtoupper(uniqid());
            $order->ordered_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending'    => ['label' => 'Menunggu', 'color' => 'yellow'],
            'processing' => ['label' => 'Diproses', 'color' => 'blue'],
            'shipped'    => ['label' => 'Dikirim', 'color' => 'indigo'],
            'completed'  => ['label' => 'Selesai', 'color' => 'green'],
            'cancelled'  => ['label' => 'Dibatalkan', 'color' => 'red'],
            default      => ['label' => 'Unknown', 'color' => 'gray'],
        };
    }
}
