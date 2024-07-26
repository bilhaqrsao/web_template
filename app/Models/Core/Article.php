<?php

namespace App\Models\Core;

use App\Models\User;
use App\Models\Utility\Tag;
use App\Models\Utility\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $fillable = ['thumbnail', 'title', 'slug', 'description', 'meta_title', 'meta_description', 'content', 'status', 'user_id', 'tags', 'view_count'];

    public function Author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_id');
    }

    public function getTagsAttribute()
    {
        return $this->Tags->pluck('name');
    }

    public function setTagsAttribute($value)
    {
        $this->Tags()->sync($value);
    }

    public function Action()
    {
        return $this->morphMany(Action::class, 'actionable_id');
    }
}
