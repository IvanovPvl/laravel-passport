<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Data\Repository;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /** @var Repository  */
    protected $model;

    /**
     * @param Request $request
     */
    public function beforeCreate(Request $request): void
    {
        $this->validate($request, $this->model->getModel()->getValidationRules());
    }

    /**
     * @param Request $request
     */
    public function beforeUpdate(Request $request): void
    {
        $this->validate($request, $this->model->getModel()->getValidationRules(true));
    }
}