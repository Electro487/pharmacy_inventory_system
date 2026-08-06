<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Enums\OrderStatus;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'generic_name',
        'brand',
        'description',
        'category_id',
        'unit_id',
        'selling_price',
        'stock',
        'reorder_level',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function latestPurchasePrice()
    {
        return $this->hasOne(PurchaseItem::class)->latestOfMany('id');
    }

    public function getPurchasePriceAttribute()
    {
        $latest = $this->purchaseItems()->latest('id')->first();
        return $latest ? $latest->purchase_price : null;
    }

    public function getAvailableStockAttribute()
    {
        $reserved = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.medicine_id', $this->id)
            ->where('orders.status', OrderStatus::Pending)
            ->sum('order_items.quantity');

        return max(0, $this->stock - $reserved);
    }
}
