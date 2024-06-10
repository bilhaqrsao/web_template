<?php

namespace App\Models\Core;

use App\Models\User;
use App\Models\Core\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $fillable = [
        'invoice_number',
        'sale_date',
        'user_id',
        'total_amount',
        'discount',
        'store_id',
        'status',
        'note',
        'payment_method',
        'payment_status',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function salesItems()
    {
        return $this->hasMany(SalesItems::class, 'sale_id', 'id');
    }
}
