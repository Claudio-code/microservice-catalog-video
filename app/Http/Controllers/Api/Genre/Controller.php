<?php

namespace App\Http\Controllers\Api\Genre;

use App\Http\Controllers\Controller as AppController;
use App\Models\Genre;
use Catalog\Genre\DeleteGenreFeature;
use Catalog\Genre\FindOneGenre\FindOneGenreFeature;
use Catalog\Genre\ListAllGenreFeature;
use Catalog\Genre\CreateGenre\CreateGenreFeature;
use Catalog\Genre\CreateGenre\GenreDTO;
use Catalog\Genre\UpdateGenre\UpdateGenreFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends AppController
{
    public function index(ListAllGenreFeature $listAllGenreFeature): JsonResponse
    {
        return response()->json($listAllGenreFeature->execute());
    }

    public function store(
        FormRequest $formRequest,
        CreateGenreFeature $createGenreFeature,
    ): JsonResponse {
        $genre = $createGenreFeature->execute(GenreDTO::factory($formRequest->all()));

        return response()->json($genre, 201);
    }

    public function show(
        string $genre,
        FindOneGenreFeature $feature,
    ): JsonResponse {
        return response()->json($feature->execute($genre));
    }

    public function update(
        UpdateGenreFeature $updateGenreFeature,
        FormRequest $formRequest,
        Genre $genre,
    ): JsonResponse {
        $genre = $updateGenreFeature->execute(
            GenreDTO::factory($formRequest->all()),
            $genre
        );

        return response()->json($genre, 202);
    }

    public function destroy(
        DeleteGenreFeature $deleteGenreFeature,
        Genre $genre,
    ): Response {
        $deleteGenreFeature->execute($genre);

        return response()->noContent();
    }
}
