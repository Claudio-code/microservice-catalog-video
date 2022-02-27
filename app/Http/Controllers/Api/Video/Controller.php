<?php

namespace App\Http\Controllers\Api\Video;

use App\Factories\VideoDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Video\CreateVideoService;
use App\Services\Video\GetAllVideoService;
use App\Services\Video\GetOneVideoService;
use App\Services\Video\RemoveVideoService;
use App\Services\Video\UpdateVideoService;
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
        VideoDTOFactory $videoDTOFactory,
    ) {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'opened' => 'boolean',
            'rating' => 'numeric',
            'duration' => 'numeric',
            'year_launched' => 'numeric',
            'categories_ids' => 'array|exists:categories,id,deleted_at,NULL',
            'genres_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'video_file' => 'mimetypes:video/mp4|max:12'
        ];
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
            abstractFactory: $videoDTOFactory,
            rules: $rules,
        );
    }
}
