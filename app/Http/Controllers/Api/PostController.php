<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\{
    Request,
    Response
};

use App\Helpers\Api;
use App\Models\Post;
use App\Data\Repository;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends ApiController
{
    use Api;

    /**
     * PostController constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = new Repository($post);
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return $this->model
            ->with('user')
            ->latest()
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): Response
    {
        $this->beforeCreate($request);
        $fillable = $this->model->getModel()->fillable;

        $newPost = $request->user()
            ->posts()
            ->create($request->only($fillable));

        return $this->model->with('user')->find($newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): Response
    {
        return $this->model->with(['user', 'comments.user'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): Response
    {
        $this->beforeUpdate($request);
        $fillable = $this->model->getModel()->fillable;

        if (!$this->model->update($id, $request->only($fillable))) {
            return $this->errorBadRequest('Unable to update.');
        }

        return $this->model->find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int     $id
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id): Response
    {
        if (!$request->user()->posts()->find($id)) {
            return $this->errorNotFound('Post not found for this user.');
        }

        return $this->model->delete($id) ? $this->noContent() : $this->errorBadRequest();
    }
}
