<?php

namespace App\Models\Core;

use App\Models\Utility\Tag;
use App\Models\Utility\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumen';
    protected $fillable = ['title','image','slug','content'];

    public function getThumbnailAttribute($value)
    {
        return $value ? asset('storage/pengumuman' . $value) : null;
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
