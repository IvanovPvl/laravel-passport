<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 */
abstract class BaseModel extends Model
{
    /**
     * @param  bool $forUpdate
     * @return bool
     */
    public abstract function getValidationRules(bool $forUpdate = false): array;
}