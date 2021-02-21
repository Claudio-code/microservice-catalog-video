<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Catalog\Category\ListAllCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private ListAllCategory $listAllCategory
    ) {
    }

    public function index(): JsonResponse
    {
        return response()
            ->json($this->listAllCategory->execute())
        ;
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json();
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        return response()->json();
    }

    public function destroy(Category $category): JsonResponse
    {
        return response()->json();
    }
}
