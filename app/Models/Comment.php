<?php

namespace App\Models;

/**
 * Class Comment
 * @package App\Models
 */
class Comment extends BaseModel
{
    protected $fillable = ['content', 'post_id', 'user_id'];

    /**
     * @param  bool $forUpdate
     * @return array
     */
    public function getValidationRules(bool $forUpdate = false): array
    {
        $createRule = [
            'content' => 'required',
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];

        $updateRule = [
            'content' => 'required',
            'post_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];

        return $forUpdate ? $updateRule : $createRule;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}