<?php

namespace App\Http\Controllers\Api\Video;

use App\Factories\VideoDTOFactory;
use App\Http\Controllers\Controller as AppController;
use App\Services\Video\CreateVideoService;
use App\Services\Video\GetAllVideoService;
use App\Services\Video\GetOneVideoService;
use App\Services\Video\RemoveVideoService;
use App\Services\Video\UpdateVideoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Controller extends AppController
{
    public function index(GetAllVideoService $service): JsonResponse
    {
        return response()->json($service->execute());
    }

    public function show(string $video, GetOneVideoService $service): JsonResponse
    {
        return response()->json($service->execute($video));
    }

    public function store(FormRequest $formRequest, CreateVideoService $service): JsonResponse
    {
        $video = $service->execute(VideoDTOFactory::make($formRequest->all()));

        return response()->json($video, Response::HTTP_CREATED);
    }

    public function update(UpdateVideoService $service, FormRequest $formRequest, string $video): JsonResponse
    {
        $videoSalved = $service->execute(
            videoDTO: VideoDTOFactory::make($formRequest->all()),
            videoId: $video,
        );

        return response()->json($videoSalved);
    }

    public function destroy(RemoveVideoService $service, string $video): Response
    {
        $service->execute($video);

        return response()->noContent();
    }
}
