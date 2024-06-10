<?php

namespace App\Models\Utility;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'ip_address',
        'user_agent',
        'device',
        'platform',
        'browser',
        'language',
        'country',
        'city',
        'region',
        'postal_code',
        'latitude',
        'longitude',
        'timezone',
        'currency',
        'isp',
        'org',
        'as',
        'asname',
        'reverse',
        'mobile',
        'hosting',
        'proxy',
        'vpn',
        'tor',
        'active',
    ];
}
