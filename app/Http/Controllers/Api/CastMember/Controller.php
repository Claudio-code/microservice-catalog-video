<?php

namespace App\Http\Controllers\Api\CastMember;

use App\DTO\CastMemberDTO;
use App\Http\Controllers\Controller as AppController;
use App\Services\CreateCastMemberService;
use App\Services\GetAllCastMemberService;
use App\Services\GetOneCastMemberService;
use App\Services\RemoveCastMemberService;
use App\Services\UpdateCastMemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class Controller extends AppController
{
    public function index(GetAllCastMemberService $service): JsonResponse
    {
        return response()->json($service->execute(), Response::HTTP_OK);
    }

    /**
     * @throws UnknownProperties
     */
    public function store(CreateCastMemberService $service, FormRequest $formRequest): JsonResponse
    {
        $castMember = $service->execute(CastMemberDTO::factory($formRequest->all()));

        return response()->json($castMember, Response::HTTP_CREATED);
    }

    public function show(string $castMember, GetOneCastMemberService $service): JsonResponse
    {
        return response()->json($service->execute($castMember), Response::HTTP_OK);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(UpdateCastMemberService $service, FormRequest $formRequest, string $castMember): JsonResponse
    {
        $castMember = $service->execute(CastMemberDTO::factory($formRequest->all()), $castMember);

        return response()->json($castMember, Response::HTTP_OK);
    }

    public function destroy(RemoveCastMemberService $service, string $castMember): Response
    {
        $service->execute($castMember);

        return response()->noContent();
    }
}
