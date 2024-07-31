<?php

namespace App\Models\Utility;

use App\Models\Core\Page;
use Illuminate\Support\Str;
use App\Models\Core\Article;
use App\Models\Core\Pengumuman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable', 'pivot_tags', 'tag_id', 'taggable_id');
    }

    public function pages(): MorphToMany
    {
        return $this->morphedByMany(Page::class, 'taggable', 'pivot_tags', 'tag_id', 'taggable_id');
    }

    public function pengumumen(): MorphToMany
    {
        return $this->morphedByMany(Pengumuman::class, 'taggable', 'pivot_tags', 'tag_id', 'taggable_id');
    }

    public function getTagsAttribute()
    {
        return $this->belongsToMany(Tag::class, 'pivot_tags', 'taggable_id', 'tag_id');
    }
}
