<?php

namespace App\Modules\Tag\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Modules\Tag\Models\Tag;
use Illuminate\Http\Request;

class TagApiController extends Controller
{
    public function tags(): \Illuminate\Database\Eloquent\Collection
    {
        return Tag::all();
    }
}
