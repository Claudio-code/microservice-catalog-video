<?php

namespace App\Http\Controllers\Api\CastMember;

use App\Factories\CastMemberDTOFactoryInterface;
use App\Http\Controllers\Controller as AppController;
use App\Services\CastMember\CreateCastMemberService;
use App\Services\CastMember\GetAllCastMemberService;
use App\Services\CastMember\GetOneCastMemberService;
use App\Services\CastMember\RemoveCastMemberService;
use App\Services\CastMember\UpdateCastMemberService;
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
        $castMember = $service->execute(CastMemberDTOFactoryInterface::make($formRequest->all()));

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
        $castMember = $service->execute(
            castMemberDTO: CastMemberDTOFactoryInterface::make($formRequest->all()),
            castMemberId: $castMember
        );

        return response()->json($castMember, Response::HTTP_OK);
    }

    public function destroy(RemoveCastMemberService $service, string $castMember): Response
    {
        $service->execute($castMember);

        return response()->noContent();
    }
}
