<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\PaymentStatus;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'invoice_no',
        'sale_date',
        'total_amount',
        'subtotal',
        'vat_rate',
        'vat_amount',
        'payment_status',
        'remarks',
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class,
        'subtotal' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}