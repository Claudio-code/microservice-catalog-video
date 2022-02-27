<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidateException;
use App\Factories\AbstractFactory;
use App\Services\AbstractService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

abstract class AbstractController extends Controller
{
    /** @param array<string, string> $rules */
    public function __construct(
        private readonly AbstractService $indexService,
        private readonly AbstractService $showService,
        private readonly AbstractService $createService,
        private readonly AbstractService $updateService,
        private readonly AbstractService $deleteService,
        private readonly AbstractFactory $abstractFactory,
        private readonly array $rules = [],
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->indexService->execute());
    }

    public function show(string $entityName): JsonResponse
    {
        $entity = $this->showService->execute($entityName);
        return response()->json($entity);
    }

    /** @throws ValidateException */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $requestDTO = $this->abstractFactory->make($request);
        $entity = $this->createService->execute($requestDTO);
        return response()->json($entity, Response::HTTP_CREATED);
    }

    /** @throws ValidateException */
    public function update(Request $request, string $entityName): JsonResponse
    {
        $requestDTO = $this->abstractFactory->make($request);
        $this->validateRequest($request);
        $entity = $this->updateService->execute($requestDTO, $entityName);
        return response()->json($entity);
    }

    public function destroy(string $entityName): Response
    {
        $this->deleteService->execute($entityName);
        return response()->noContent();
    }

    /** @throws ValidateException */
    protected function validateRequest(Request $request): void
    {
        $isInvalid = Validator::make($request->all(), $this->rules);
        if ($isInvalid->fails()) {
            throw new ValidateException($isInvalid);
        }
    }
}
