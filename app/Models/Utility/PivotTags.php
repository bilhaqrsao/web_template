<?php

namespace App\Models\Utility;

use App\Models\Core\Page;
use App\Models\Core\Article;
use App\Models\Core\Pengumuman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PivotTags extends Model
{
    use HasFactory;

    protected $table = 'pivot_tags';

    protected $fillable = [
        'taggable_type',
        'taggable_id',
        'tag_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function taggable()
    {
        return $this->morphTo();
    }

    public function getArticles()
    {
        return $this->belongsTo(Article::class, 'taggable_id');
    }

    public function getPages()
    {
        return $this->belongsTo(Page::class, 'taggable_id');
    }

    public function getPengumumans()
    {
        return $this->belongsTo(Pengumuman::class, 'taggable_id');
    }

    public function getTags()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
