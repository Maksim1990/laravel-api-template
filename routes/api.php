<?php

use App\Http\Resources\AbstractCollection;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/{id}', function ($id){
   return new UserResource(User::findOrFail($id));
});

Route::get('/users', function (Request $request){
    return new UserCollection(User::paginate((int)$request->query->get(AbstractCollection::PER_PAGE_PARAM_NAME) ??
        AbstractCollection::DEFAULT_ITEMS_NUMBER_PER_PAGE));
});
