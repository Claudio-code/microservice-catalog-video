<?php

namespace Tests\Traits;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Lang;

trait TestValidations
{
    protected function assertInvalidationInStoreAction(
        array $data,
        string $method,
        string $route,
        string $rule,
        $ruleParams = []
    ) {
        $response = $this->json(
            method: $method,
            uri: route($route),
            data: $data,
        );
        $fields = array_keys($data);
        $this->assertInvalidationFields($response, $fields, $rule, $ruleParams);
    }

    protected function assertInvalidationFields(
        TestResponse $response,
        array $fields,
        string $rule,
        array $ruleParams = []
    ) {
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors($fields);

        foreach ($fields as $field) {
            $fieldName = str_replace('_', ' ', $field);
            $response->assertJsonFragment([
                Lang::get("validation.{$rule}", ['attribute' => $fieldName] + $ruleParams)
            ]);
        }
    }

    protected function assertInvalidationJson(
        TestResponse $response,
        array $jsonValidationsErrorsFields,
        array $jsonFragmentValidations,
        array $jsonMissingValidationErrorsFields = [],
    ): void {
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors($jsonValidationsErrorsFields)
            ->assertJsonMissingValidationErrors($jsonMissingValidationErrorsFields);

        foreach ($jsonFragmentValidations as $validation) {
            $response->assertJsonFragment([$validation]);
        }
    }

    protected static function assertKeysInResponseBody(array $keys, TestResponse $response): void
    {
        $responseArray = json_decode($response->content(), true);
        self::assertNotEmpty($responseArray);
        self::assertIsArray($responseArray);
        foreach ($keys as $key) {
            self::assertArrayHasKey($key, $responseArray);
        }
    }
}
