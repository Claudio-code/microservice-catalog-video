<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller as AppController;
use App\Models\Category;
use Catalog\Category\CreateCategory\CategoryDTO;
use Catalog\Category\CreateCategory\CreateCategoryFeature;
use Catalog\Category\DeleteCategoryFeature;
use Catalog\Category\ListAllCategoryFeature;
use Catalog\Category\UpdateCategory\UpdateCategoryFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends AppController
{
    public function index(ListAllCategoryFeature $listAllCategory): JsonResponse
    {
        return response()
            ->json($listAllCategory->execute());
    }

    public function store(
        CreateCategoryFeature $createCategory,
        FormRequest $formRequest,
    ): JsonResponse {
        $category = $createCategory->execute(CategoryDTO::factory(
            $formRequest->all()
        ));

        return response()->json($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    public function update(
        UpdateCategoryFeature $updateCategory,
        FormRequest $formRequest,
        Category $category,
    ): JsonResponse {
        $category = $updateCategory->execute(
            CategoryDTO::factory($formRequest->all()),
            $category,
        );

        return response()->json($category);
    }

    public function destroy(
        DeleteCategoryFeature $deleteCategory,
        Category $category,
    ): Response {
        $deleteCategory->execute($category);

        return response()->noContent();
    }
}