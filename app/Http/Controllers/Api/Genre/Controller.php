<?php

namespace App\Http\Controllers\Api\Genre;

use App\Factories\GenreDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Genre\CreateGenreService;
use App\Services\Genre\GetAllGenreService;
use App\Services\Genre\GetOneGenreService;
use App\Services\Genre\RemoveGenreService;
use App\Services\Genre\UpdateGenreService;
use JetBrains\PhpStorm\Pure;

class Controller extends AbstractController
{
    #[Pure]
    public function __construct(
        GetAllGenreService   $indexService,
        GetOneGenreService   $showService,
        CreateGenreService   $createService,
        UpdateGenreService   $updateService,
        RemoveGenreService   $deleteService,
        GenreDTOFactory $genreDTOFactory,
    ) {
        $rules = [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'categories_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'videos_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
            abstractFactory: $genreDTOFactory,
            rules: $rules,
        );
    }
}
