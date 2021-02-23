<?php

namespace App\Http\Controllers\Api\Genre;

use App\Http\Controllers\Controller as AppController;
use App\Models\Genre;
use Catalog\Genre\DeleteGenreFeature;
use Catalog\Genre\ListAllGenreFeature;
use Catalog\Genre\UpdateGenreFeature;
use CreateGenreFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends AppController
{
    public function index(ListAllGenreFeature $listAllGenreFeature): JsonResponse
    {
        return response()->json($listAllGenreFeature->execute());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(
        FormRequest $formRequest,
        CreateGenreFeature $createGenreFeature,
    ): JsonResponse {
        $genre = $createGenreFeature->execute($formRequest->all());

        return response()->json($genre, 201);
    }

    public function show(Genre $genre): JsonResponse
    {
        return response()->json($genre);
    }

    public function update(
        UpdateGenreFeature $updateGenreFeature,
        FormRequest $formRequest,
        Genre $genre,
    ): JsonResponse {
        $genre = $updateGenreFeature->execute($formRequest->all(), $genre);

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
