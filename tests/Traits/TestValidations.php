<?php

namespace Tests\Traits;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

trait TestValidations
{
    protected function assertInvalidationJson(
        TestResponse $response,
        array $jsonValidationsErrorsFields,
        array $jsonFragmentValitations,
        array $jsonMissingValidationErrorsFields = [],
    ): void {
        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors($jsonValidationsErrorsFields)
            ->assertJsonMissingValidationErrors($jsonMissingValidationErrorsFields);

        foreach ($jsonFragmentValitations as $valitation) {
            $response->assertJsonFragment([$valitation]);
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
