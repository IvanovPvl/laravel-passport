<?php

namespace App\Models;

/**
 * Class Post
 * @package App\Models
 */
class Post extends BaseModel
{
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * @param  bool $forUpdate
     * @return array
     */
    public function getValidationRules(bool $forUpdate = false): array
    {
        $createRule = [
            'title'   => 'required|max:200',
            'content' => 'required',
            'user_id' => 'required|integer',
        ];

        $updateRule = [
            'title'   => 'required|max:200',
            'content' => 'required',
            'user_id' => 'required|integer',
        ];

        return $forUpdate ? $updateRule : $createRule;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }
}