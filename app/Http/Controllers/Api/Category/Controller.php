<?php

namespace App\Http\Controllers\Api\Category;

use App\DTO\DataTransferObject;
use App\Factories\CategoryDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\GetAllCategoriesService;
use App\Services\Category\GetOneCategoryService;
use App\Services\Category\RemoveCategoryService;
use App\Services\Category\UpdateCategoryService;
use JetBrains\PhpStorm\ArrayShape;

class Controller extends AbstractController
{
    public function __construct(
        GetAllCategoriesService $indexService,
        GetOneCategoryService   $showService,
        CreateCategoryService   $createService,
        UpdateCategoryService   $updateService,
        RemoveCategoryService   $deleteService,
    ) {
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
        );
    }

    public function factoryDTO(array $data): DataTransferObject
    {
        return  CategoryDTOFactory::make($data);
    }

    #[ArrayShape([
        'name' => "string",
        'is_active' => "string",
        'genres_ids' => "string",
        'videos_ids' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'genres_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'videos_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
    }
}
