<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbstractCollection;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return new PostCollection(
            Post::paginate((int)$request->query->get(AbstractCollection::PER_PAGE_PARAM_NAME)
                ?? AbstractCollection::DEFAULT_ITEMS_NUMBER_PER_PAGE)
        );
    }

    public function store(Request $request)
    {

    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
