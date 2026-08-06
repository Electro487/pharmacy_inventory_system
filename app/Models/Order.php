<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'order_no',
        'order_date',
        'total_amount',
        'status',
        'remarks',
        'approved_by',
        'approved_at',
        'sale_id',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'approved_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
    }