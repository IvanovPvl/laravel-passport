<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('posts', 'Api\PostController', ['except' => ['create', 'edit']]);
Route::resource('posts.comments', 'Api\CommentController', ['except' => ['create', 'edit']]);
