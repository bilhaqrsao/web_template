<?php

namespace App\Models\Core;

use App\Models\User;
use App\Models\Utility\Tag;
use App\Models\Utility\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'pivot_tags', 'taggable_id', 'tag_id');
    }

    public function action()
    {
        return $this->morphMany(Action::class, 'actionable');
    }
}
