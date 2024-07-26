<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityWeb extends Model
{
    use HasFactory;

    protected $table = 'identity_webs';
    protected $fillable = [
        'name_website',
        'heads_name',
        'moto',
        'description',
        'favicon',
        'logo',
        'email',
        'address',
        'phone',
        'whatsapp',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'map'
    ];
}
