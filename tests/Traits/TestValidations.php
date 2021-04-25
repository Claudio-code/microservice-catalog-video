<?php

namespace Tests\Traits;

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
            ->assertStatus(422)
            ->assertJsonValidationErrors($jsonValidationsErrorsFields)
            ->assertJsonMissingValidationErrors($jsonMissingValidationErrorsFields);

        foreach ($jsonFragmentValitations as $valitation) {
            $response->assertJsonFragment([$valitation]);
        }
    }
}
