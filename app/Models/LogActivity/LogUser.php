<?php

namespace App\Models\LogActivity;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogUser extends Model
{
    use HasFactory;

    protected $table = 'log_users';

    protected $fillable = [
        'user_id',
        'activity',
        'description'
    ];

    public function User()
    {
        return $this->belongsTo(xUser::class);
    }
}
