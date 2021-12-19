<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbstractCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return new UserCollection(
            User::paginate((int)$request->query->get(AbstractCollection::PER_PAGE_PARAM_NAME)
                ?? AbstractCollection::DEFAULT_ITEMS_NUMBER_PER_PAGE)
        );
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return new UserResource($user);
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
