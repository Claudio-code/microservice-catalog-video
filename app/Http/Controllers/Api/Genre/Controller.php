<?php

namespace App\Http\Controllers\Api\Genre;

use App\DTO\GenreDTO;
use App\Factories\GenreDTOFactory;
use App\Http\Controllers\Controller as AppController;
use App\Services\Genre\CreateGenreService;
use App\Services\Genre\GetAllGenreService;
use App\Services\Genre\GetOneGenreService;
use App\Services\Genre\RemoveGenreService;
use App\Services\Genre\UpdateGenreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends AppController
{
    public function index(GetAllGenreService $service): JsonResponse
    {
        return response()->json($service->execute());
    }

    public function show(string $genre, GetOneGenreService $service): JsonResponse
    {
        return response()->json($service->execute($genre));
    }

    public function store(FormRequest $formRequest, CreateGenreService $service): JsonResponse
    {
        $genre = $service->execute(GenreDTOFactory::make($formRequest->all()));

        return response()->json($genre, Response::HTTP_CREATED);
    }

    public function update(UpdateGenreService $service, FormRequest $formRequest, string $genre): JsonResponse
    {
        $genre = $service->execute(
            genreDTO: GenreDTOFactory::make($formRequest->all()),
            genreId: $genre,
        );

        return response()->json($genre, Response::HTTP_OK);
    }

    public function destroy(RemoveGenreService $service, string $genre): Response
    {
        $service->execute($genre);

        return response()->noContent();
    }
}
