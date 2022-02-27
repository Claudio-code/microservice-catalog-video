<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;
use Tests\Traits\TestValidations;
use Tests\Traits\VideoFileUpdateTrait;

class VideoControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;
    use VideoFileUpdateTrait;

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
            'opened' => true,
            'duration' => 332,
            'year_launched' => 2020,
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

    public function testInvalidFieldsInPost(): void
    {
        // categories_ids
        $data = ['categories_ids' => 'w'];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'array'
        );
        $data = ['categories_ids' => [12]];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'exists'
        );

        // genres_ids
        $data = ['genres_ids' => 'w'];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'array'
        );
        $data = ['genres_ids' => [12]];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'exists'
        );

        // title
        $data = ['title' => 21];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'string'
        );

        // description
        $data = ['description' => 21];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'string'
        );

        // opened
        $data = ['opened' => 21];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'boolean'
        );

        // rating
        $data = ['rating' => 'wdq'];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'numeric'
        );

        // year_launched
        $data = ['year_launched' => 'wdq'];
        $this->assertInvalidationInStoreAction(
            data: $data,
            method: 'POST',
            route: 'video.store',
            rule: 'numeric'
        );
    }

    public function testCreate(): void
    {
        $title = str_repeat(string: 'w', times: 12);
        $description = str_repeat(string: 'wds', times: 12);
        $opened = (bool)rand(0, 1);
        $rating = rand(0, 5);
        $duration = rand(21, 40);
        $year_launched = rand(2000, 2022);
        $video = $this->getValidFileVideo();
        $response = $this->json(method: 'POST', uri: route('video.store', [
            'title' => $title,
            'description' => $description,
            'opened' => $opened,
            'rating' => $rating,
            'duration' => $duration,
            'year_launched' => $year_launched,
        ]), data: ['video_file' => $video]);
        $response
            ->assertCreated()
            ->assertJsonFragment([
                'title' => $title,
                'duration' => $duration,
                'description' => $description,
                'opened' => $opened,
                'year_launched' => $year_launched,
                'video_file' => $video->hashName(),
            ]);
        self::assertKeysInResponseBody([
            'title',
            'description',
            'opened',
            'rating',
            'duration',
            'video_file',
        ], $response);
    }

    public function testCreateWithInvalidFile(): void
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
        ]), data: ['video_file' => $this->getInvalidFilePhoto()]);

        self::assertInvalidationJson(
            response: $response,
            jsonValidationsErrorsFields: ['video_file'],
            jsonFragmentValidations: [],
        );
    }

    public function testUpdate(): void
    {
        $videoToCreate = $this->getValidFileVideo();
        $videoToUpdate = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory(['video_file' => $videoToCreate])->create();
        $video->uploadFiles([$videoToCreate]);

        $title = str_repeat(string: 'dw', times: 12);
        $description = str_repeat(string: 'wds ', times: 12);
        $opened = rand(0, 1);
        $rating = rand(0, 5);
        $duration = rand(21, 40);
        $year_launched = rand(2000, 2022);

        $response = $this->json(
            method: 'PUT',
            uri: route('video.update', [
                'video' => $video->id,
                'title' => $title,
                'description' => $description,
                'opened' => $opened,
                'rating' => $rating,
                'duration' => $duration,
                'year_launched' => $year_launched,]),
            data: ['video_file' => $videoToUpdate],
        );
        $response
            ->assertOk()
            ->assertJsonFragment([
                'title' => $title,
                'video_file' => $videoToUpdate->hashName(),
            ]);
        Storage::assertExists("video/{$videoToUpdate->hashName()}");
        self::assertKeysInResponseBody([
            'title',
            'description',
            'opened',
            'rating',
            'duration',
            'video_file',
        ], $response);
    }

    public function testDelete(): void
    {
        $videoFile = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory([
            'video_file' => $videoFile->hashName(),
        ])->create();
        $video->uploadFiles([$videoFile]);
        $video->refresh();
        $response = $this->json(method: 'DELETE', uri: route('video.destroy', [
            'video' => $video->id,
        ]));

        Storage::assertMissing("video/{$videoFile->hashName()}");
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
