<?php

namespace App\Modules\Tag\Models;

use App\Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validated)
 */
class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name'];

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag_relations', 'tag_id', 'post_id');
    }
}
