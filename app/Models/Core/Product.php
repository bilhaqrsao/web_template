<?php

namespace App\Models\Core;

use App\Models\LogActivity\LogStore;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'category_id',
        'subcategory_id',
        'description',
        'image',
        'stock',
        'status',
        'store_id',
        'google_id',
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }

    public function LogStore()
    {
        return $this->hasMany(LogStore::class);
    }
}
