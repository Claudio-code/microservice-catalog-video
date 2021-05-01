<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

abstract class BasicCrudController extends Controller
{
    abstract protected function model(): Model;

    public function index(): JsonResponse
    {
        return response()->json($this->model()::all());
    }
}
