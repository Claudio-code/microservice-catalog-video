<?php

namespace App\Http\Controllers\Api\Genre;

use App\DTO\GenreDTO;
use App\Http\Controllers\Controller as AppController;
use App\Services\CreateGenreService;
use App\Services\GetAllGenreService;
use App\Services\GetOneGenreService;
use App\Services\RemoveGenreService;
use App\Services\UpdateGenreService;
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
        $genre = $service->execute(GenreDTO::factory($formRequest->all()));

        return response()->json($genre, Response::HTTP_CREATED);
    }

    public function update(UpdateGenreService $service, FormRequest $formRequest, string $genre): JsonResponse
    {
        $genre = $service->execute(
            GenreDTO::factory($formRequest->all()),
            $genre
        );

        return response()->json($genre, Response::HTTP_CREATED);
    }

    public function destroy(RemoveGenreService $service, string $genre): Response
    {
        $service->execute($genre);

        return response()->noContent();
    }
}
