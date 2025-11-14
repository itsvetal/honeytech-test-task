<?php

namespace App\Modules\Post\Models;

use App\Modules\Tag\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'tumbnail',
    ];

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setThumbnailAttribute($value): void
    {
        if ($value && $value instanceof \Illuminate\Http\UploadedFile) {
            $path = $value->store('thumbnails', 'public');
            $this->attributes['thumbnail'] = $path;
        } else {
            $this->attributes['thumbnail'] = $value;  // Для update, якщо не змінюємо
        }
    }

    public function getThumbnailUrlAttribute(): string {
        return $this->thumbnail ? Storage::url($this->thumbnail) : '/default-thumbnail.jpg';
    }
}
