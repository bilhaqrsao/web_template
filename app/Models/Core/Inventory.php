<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';
    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'purchase_date',
        'store_id',
        'user_id',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Sales()
    {
        return $this->hasMany(Sales::class);
    }
}
