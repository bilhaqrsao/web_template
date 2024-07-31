<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkTerkait extends Model
{
    use HasFactory;

    protected $table = 'link_terkaits';
    protected $fillable = ['title', 'slug', 'url', 'icon'];
}
