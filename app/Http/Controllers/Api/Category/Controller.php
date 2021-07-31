<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller as AppController;
use App\Services\CreateCategoryService;
use App\Services\GetAllCategoriesService;
use App\Services\GetOneCategoryService;
use App\Services\RemoveCategoryService;
use App\Services\UpdateCategoyService;
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
        $category = $service->execute(CategoryDTO::factory($formRequest->all()));

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function show(string $category, GetOneCategoryService $service): JsonResponse
    {
        return response()->json($service->execute($category));
    }

    /**
     * @throws UnknownProperties
     */
    public function update(UpdateCategoyService $service, FormRequest $formRequest, string $category): JsonResponse
    {
        $category = $service->execute(CategoryDTO::factory($formRequest->all()), $category);

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function destroy(RemoveCategoryService $service, string $category): Response
    {
        $service->execute($category);

        return response()->noContent();
    }
}
