<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getValidationRules($forUpdate = false)
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
}