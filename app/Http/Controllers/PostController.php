<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Api;
use App\Models\Post;
use App\Data\Repository;

/**
 * Class PostController
 * @package App\Http\Controllers
 */
class PostController extends Controller
{
    use Api;

    /** @var Repository */
    protected $model;

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
    public function index()
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
    public function store(Request $request)
    {
        $this->beforeCreate($request);
        $fillable = $this->model->getModel()->fillable;

        return $request->user()
            ->posts()
            ->create($request->only($fillable));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model->with('user')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
    public function destroy(Request $request, $id)
    {
        if (!$request->user()->posts()->find($id)) {
            return $this->errorNotFound('Post not found for this user.');
        }

        return $this->model->delete($id) ? $this->noContent() : $this->errorBadRequest();
    }
}
