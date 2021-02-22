<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Catalog\Category\CreateCategory;
use Catalog\Category\DeleteCategory;
use Catalog\Category\ListAllCategory;
use Catalog\Category\UpdateCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct(
        private ListAllCategory $listAllCategory,
        private CreateCategory $createCategory,
        private UpdateCategory $updateCategory,
        private DeleteCategory $deleteCategory,
    ) {
    }

    public function index(): JsonResponse
    {
        return response()
            ->json($this->listAllCategory->execute())
        ;
    }

    public function store(CategoryCreateRequest $categoryCreateRequest): JsonResponse
    {
        $category = $this->createCategory->execute($categoryCreateRequest->all());

        return response()->json($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function update(CategoryCreateRequest $categoryCreateRequest, Category $category): JsonResponse
    {
        $category = $this->updateCategory->execute($categoryCreateRequest->all(), $category);

        return response()->json($category);
    }

    public function destroy(Category $category): Response
    {
        $this->deleteCategory->execute($category);

        return response()->noContent();
    }
}
