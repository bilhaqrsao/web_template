<?php

namespace App\Models\LogActivity;

use App\Models\User;
use App\Models\Core\Sales;
use App\Models\Core\Store;
use App\Models\Core\Product;
use App\Models\Core\SalesItems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogStore extends Model
{
    use HasFactory;

    protected $table = 'log_stores';

    protected $fillable = [
        'store_id',
        'user_id',
        'product_id',
        'sales_id',
        'sales_item_id',
        'activity',
        'description'
    ];

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function Sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function SalesItem()
    {
        return $this->belongsTo(SalesItems::class);
    }
}
