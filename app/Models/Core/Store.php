<?php

namespace App\Models\Core;

use App\Models\LogActivity\LogStore;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $fillable = [
        'banner',
        'name',
        'slug',
        'description',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'logo',
        'website',
        'facebook',
        'twitter',
        'instagram',
        'status',
        'google_id',
    ];

    public function Products()
    {
        return $this->hasMany(Product::class);
    }

    public function LogActivity()
    {
        return $this->hasMany(LogStore::class);
    }
}
