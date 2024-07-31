<?php

namespace App\Models\Core;

use App\Models\User;
use App\Models\Utility\Tag;
use App\Models\Utility\Action;
use App\Models\Utility\PivotTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';
    protected $fillable = ['title', 'image', 'slug', 'content'];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'pivot_tags', 'taggable_id', 'tag_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function action()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function Tag()
    {
        return $this->hasMany(PivotTags::class,'article_id','id');
    }

    public function getTags()
    {
        return $this->belongsToMany('App\Models\Utility\Tag','pivot_tags','taggable_id','tag_id')->withPivot('taggable_id', 'tag_id');
    }
}
