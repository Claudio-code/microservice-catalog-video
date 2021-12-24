<?php

namespace App\Http\Controllers\Api\Category;

use App\Factories\CategoryDTOFactoryInterface;
use App\Http\Controllers\Controller as AppController;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\GetAllCategoriesService;
use App\Services\Category\GetOneCategoryService;
use App\Services\Category\RemoveCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Controller extends AppController
{
    public function index(GetAllCategoriesService $service): JsonResponse
    {
        return response()->json($service->execute());
    }

    /**
     * @throws UnknownProperties
     */
    public function store(CreateCategoryService $service, FormRequest $formRequest): JsonResponse
    {
        $category = $service->execute(CategoryDTOFactoryInterface::make($formRequest->all()));

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function show(string $category, GetOneCategoryService $service): JsonResponse
    {
        return response()->json($service->execute($category));
    }

    /**
     * @throws UnknownProperties
     */
    public function update(UpdateCategoryService $service, FormRequest $formRequest, string $category): JsonResponse
    {
        $category = $service->execute(
            categoryDTO: CategoryDTOFactoryInterface::make($formRequest->all()),
            categoryId: $category,
        );

        return response()->json($category, Response::HTTP_OK);
    }

    public function destroy(RemoveCategoryService $service, string $category): Response
    {
        $service->execute($category);

        return response()->noContent();
    }
}
