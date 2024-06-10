<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesItems extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales_items';

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Sales()
    {
        return $this->belongsTo(Sales::class, 'sale_id');
    }
}
