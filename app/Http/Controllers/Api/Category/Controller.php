<?php

namespace App\Http\Controllers\Api\Category;

use App\Factories\CategoryDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\GetAllCategoriesService;
use App\Services\Category\GetOneCategoryService;
use App\Services\Category\RemoveCategoryService;
use App\Services\Category\UpdateCategoryService;
use JetBrains\PhpStorm\Pure;

class Controller extends AbstractController
{
    #[Pure]
    public function __construct(
        GetAllCategoriesService $indexService,
        GetOneCategoryService   $showService,
        CreateCategoryService   $createService,
        UpdateCategoryService   $updateService,
        RemoveCategoryService   $deleteService,
        CategoryDTOFactory $categoryDTOFactory,
    ) {
        $rules = [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'genres_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'videos_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
            abstractFactory: $categoryDTOFactory,
            rules: $rules,
        );
    }
}
