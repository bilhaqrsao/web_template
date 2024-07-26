<?php

namespace App\Models\Core;

use App\Models\User;
use App\Models\Utility\Tag;
use App\Models\Utility\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'thumbnail',
        'content',
        'status',
        'user_id',
        'tags_id',
    ];

    public function Author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_id');
    }

    public function Action()
    {
        return $this->morphMany(Action::class, 'actionable_id');
    }

}
