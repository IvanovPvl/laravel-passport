<?php

namespace App\Http\Controllers;

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
}