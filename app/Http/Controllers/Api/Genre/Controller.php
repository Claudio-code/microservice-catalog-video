<?php

namespace App\Http\Controllers\Api\Genre;

use App\DTO\GenreDTO;
use App\Factories\GenreDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\Genre\CreateGenreService;
use App\Services\Genre\GetAllGenreService;
use App\Services\Genre\GetOneGenreService;
use App\Services\Genre\RemoveGenreService;
use App\Services\Genre\UpdateGenreService;
use JetBrains\PhpStorm\ArrayShape;

class Controller extends AbstractController
{
    public function __construct(
        GetAllGenreService   $indexService,
        GetOneGenreService   $showService,
        CreateGenreService   $createService,
        UpdateGenreService   $updateService,
        RemoveGenreService   $deleteService,
    ) {
        parent::__construct(
            indexService:        $indexService,
            showService:         $showService,
            createService:       $createService,
            updateService:       $updateService,
            deleteService:       $deleteService,
        );
    }

    #[ArrayShape([
        'name' => "string",
        'is_active' => "string",
        'categories_ids' => "string",
        'videos_ids' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'categories_ids' => 'array|exists:genres,id,deleted_at,NULL',
            'videos_ids' => 'array|exists:genres,id,deleted_at,NULL',
        ];
    }

    public function factoryDTO(array $data): GenreDTO
    {
        return GenreDTOFactory::make($data);
    }
}
