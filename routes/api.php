<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('posts', 'PostController', ['except' => ['create', 'edit']]);
Route::resource('comments', 'CommentController', ['except' => ['create', 'edit']]);
