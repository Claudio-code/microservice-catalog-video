<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var mixed[]
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $e): SymfonyResponse | JsonResponse | Response
    {
        if ($e instanceof ValidationException) {
            return \response()->json(
                [
                    'error' => ValidationException::class,
                    'fields' => $this->getErrorsFromValidator($e->validator),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return parent::render($request, $e);
    }

    /** @return array<string> */
    private function getErrorsFromValidator(Validator $validator): array
    {
        return array_map(
            fn ($messages) => implode(',', $messages),
            $validator->errors()->messages()
        );
    }
}
