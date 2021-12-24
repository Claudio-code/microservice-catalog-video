<?php

namespace App\Http\Controllers\Api\Video;

use App\DTO\VideoDTO;
use App\Factories\VideoDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Video\CreateVideoService;
use App\Services\Video\GetAllVideoService;
use App\Services\Video\GetOneVideoService;
use App\Services\Video\RemoveVideoService;
use App\Services\Video\UpdateVideoService;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class Controller extends AbstractController
{
    #[Pure]
    public function __construct(
        GetAllVideoService  $indexService,
        GetOneVideoService  $showService,
        CreateVideoService  $createService,
        UpdateVideoService  $updateService,
        RemoveVideoService  $deleteService,
    ) {
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
        );
    }

    #[ArrayShape([
        'title' => "string",
        'description' => "string",
        'opened' => "string",
        'rating' => "string",
        'duration' => "string",
        'year_launched' => "string",
        'categories_ids' => "string",
        'genres_ids' => "string"
    ])]
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'opened' => 'boolean',
            'rating' => 'numeric',
            'duration' => 'numeric',
            'year_launched' => 'numeric',
            'categories_ids' => 'array|exists:categories,id,deleted_at,NULL',
            'genres_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
    }

    public function factoryDTO(array $data): VideoDTO
    {
        return VideoDTOFactory::make($data);
    }
}
