<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
