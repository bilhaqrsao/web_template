<?php

namespace App\Models\Core;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';
    protected $fillable = ['title', 'slug', 'description', 'images', 'status', 'user_id'];

    public function Author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
