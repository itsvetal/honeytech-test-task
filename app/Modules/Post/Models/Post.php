<?php

namespace App\Modules\Post\Models;

use App\Modules\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Array_;

/**
 * @method static create(array $validated)
 */
class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'thumbnail',
    ];

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag_relations', 'post_id', 'tag_id');
    }

    public function getThumbnailUrlAttribute(): string {
        return $this->thumbnail ? Storage::url($this->thumbnail) : asset('images/default-thumbnail.png');
    }
}
