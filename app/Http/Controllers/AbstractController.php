<?php

namespace App\Http\Controllers;

use App\DTO\DataTransferObject;
use App\Exceptions\ValidateException;
use App\Services\AbstractService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

abstract class AbstractController extends Controller
{
    public function __construct(
        private AbstractService $indexService,
        private AbstractService $showService,
        private AbstractService $createService,
        private AbstractService $updateService,
        private AbstractService $deleteService,
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
        $entity = $this->createService->execute($this->factoryDTO($request->all()));

        return response()->json($entity, Response::HTTP_CREATED);
    }

    /** @throws ValidateException */
    public function update(Request $request, string $entityName): JsonResponse
    {
        $this->validateRequest($request);
        $entity = $this->updateService->execute(
            $this->factoryDTO($request->all()),
            $entityName
        );

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
        $isInvalid = Validator::make($request->all(), $this->rules());
        if ($isInvalid->fails()) {
            throw new ValidateException($isInvalid);
        }
    }

    abstract public function rules(): array;

    abstract public function factoryDTO(array $data): DataTransferObject;
}
