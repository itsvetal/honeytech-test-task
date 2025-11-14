<?php

namespace App\Modules\Post\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Modules\Post\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function posts(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        $query = Post::with('tags');
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }
        return $query->get();
    }
}
