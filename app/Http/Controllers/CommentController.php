<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Api;
use App\Models\Comment;
use App\Data\Repository;

/**
 * Class CommentController
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    use Api;

    /** @var Repository */
    protected $model;

    /**
     * CommentController constructor.
     *
     * @param $comment
     */
    public function __construct(Comment $comment)
    {
        $this->model = new Repository($comment);
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $postId
     * @return \Illuminate\Http\Response|mixed
     */
    public function index($postId)
    {
        return $this->model
            ->where('post_id', $postId)
            ->with('user')
            ->latest()
            ->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int $postId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $postId)
    {
            $this->beforeCreate($request);
            $fillable = $this->model->getModel()->fillable;

            $attributes = $request->only($fillable);
            $attributes['post_id'] = $postId;
            $attributes['user_id'] = $request->user()->id;

            /** @var Comment $newComment */
            $newComment = $this->model->create($attributes);
            return $this->model->with('user')->find($newComment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $postId
     * @param int     $commentId
     * @return \Illuminate\Http\Response|mixed
     */
    public function destroy(Request $request, int $postId, int $commentId)
    {
        if (!$request->user()->comments()->find($commentId)) {
            return $this->errorNotFound('Comment not found for this user.');
        }

        $postRepository = new Repository(new Post());
        if (!$postRepository->find($postId)->comments()->find($commentId)) {
            return $this->errorNotFound('Comment not found for this post.');
        }

        return $this->model->delete($commentId) ? $this->noContent() : $this->errorBadRequest();
    }
}