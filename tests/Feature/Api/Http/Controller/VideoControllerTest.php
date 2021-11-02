<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class VideoControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

    public function testIndex(): void
    {
        $video = Video::factory()->create();
        $response = $this->get(route('video.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([$video->toArray()]);
    }

    public function testShow(): void
    {
        $video = Video::factory()->create();
        $response = $this->get(route('video.show', [
            'video' => $video->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($video->toArray());
    }

    public function testInvalidationDataPut(): void
    {
        $video = Video::factory()->create();
        $response = $this->json(method: 'PUT', uri: route('video.update', [
            'video' => $video->id,
            'title' => str_repeat(string: 'w', times: 300),
        ]));

        self::assertInvalidationJson(
            response: $response,
            jsonValidationsErrorsFields: ['title'],
            jsonFragmentValidations: [
                trans('validation.max.string', ['attribute' => 'title', 'max' => 255]),
            ],
        );
    }

    public function testInvalidationDataPost(): void
    {
        $response = $this->json(method: 'POST', uri: route('video.store', [
            'title' => str_repeat(string: 'w', times: 300),
        ]));

        self::assertInvalidationJson(
            response: $response,
            jsonValidationsErrorsFields: ['title'],
            jsonFragmentValidations: [
                trans('validation.max.string', ['attribute' => 'title', 'max' => 255]),
            ],
        );
    }

    public function testInvalidationJson(): void
    {
        $response = $this->json(method: 'POST', uri: route('video.store', []));

        self::assertInvalidationJson(
            response: $response,
            jsonValidationsErrorsFields: ['title'],
            jsonFragmentValidations: [],
        );
    }

    public function testCreate(): void
    {
        $title = str_repeat(string: 'w', times: 12);
        $description = str_repeat(string: 'wds ', times: 12);
        $opened = rand(0, 1);
        $rating = rand(0, 5);
        $duration = rand(21, 40);
        $year_launched = rand(2000, 2022);

        $response = $this->json(method: 'POST', uri: route('video.store', [
            'title' => $title,
            'description' => $description,
            'opened' => $opened,
            'rating' => $rating,
            'duration' => $duration,
            'year_launched' => $year_launched,
        ]));

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'title' => $title,
                'duration' => $duration,
            ]);
        self::assertKeysInResponseBody([
            'title',
            'description',
            'opened',
            'rating',
            'duration',
        ], $response);
    }

    public function testUpdate(): void
    {
        $video = Video::factory()->create();
        $title = str_repeat(string: 'dw', times: 12);
        $description = str_repeat(string: 'wds ', times: 12);
        $opened = rand(0, 1);
        $rating = rand(0, 5);
        $duration = rand(21, 40);
        $year_launched = rand(2000, 2022);

        $response = $this->json(
            method: 'PUT',
            uri: route('video.update', ['video' => $video->id]),
            data: [
                'title' => $title,
                'description' => $description,
                'opened' => $opened,
                'rating' => $rating,
                'duration' => $duration,
                'year_launched' => $year_launched,
            ],
        );

        $response
            ->assertOk()
            ->assertJsonFragment(['title' => $title]);
        self::assertKeysInResponseBody([
            'title',
            'description',
            'opened',
            'rating',
            'duration',
        ], $response);
    }

    public function testDelete(): void
    {
        $video = Video::factory()->create();
        $response = $this->json(method: 'DELETE', uri: route('video.destroy', [
            'video' => $video->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }

    public function testDeleteInvalid(): void
    {
        $response = $this->json(method: 'DELETE', uri: route('video.destroy', [
            'video' => RamseyUuid::uuid4(),
        ]));


        $response->assertStatus(404);
    }
}
