<?php

namespace Feature\Api\Http\Controller;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class GenreControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

    public function testIndex(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->get(route('genre.index'));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([$genre->toArray()]);
    }

    public function testShow(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->get(route('genre.show', [
            'genre' => $genre->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($genre->toArray());
    }

    public function testCreate(): void
    {
        $name = str_repeat('a1', 6);
        $response = $this->json('POST', route('genre.store', [
            'name' => $name,
            'is_active' => true,
        ]));

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'is_active' => true,
                'name' => $name,
            ]);
        self::assertKeysInResponseBody([
            'id',
            'name',
            'is_active',
        ], $response);
    }

    public function testCreateInvalidJson(): void
    {
        $response = $this->json('POST', route('genre.store', [
            'name' => str_repeat('a1', 326),
        ]));

        self::assertInvalidationJson(
            $response,
            ['name'],
            [],
            ['is_active'],
        );
    }

    public function testUpdate(): void
    {
        $genre = Genre::factory()->create();
        $name = 'dwq qd q';

        $response = $this->json('PUT', route('genre.update', [
            'genre' => $genre->id,
            'is_active' => true,
        ]), ['name' => $name]);

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'is_active' => true,
                'name' => $name,
            ]);
        self::assertKeysInResponseBody([
            'id',
            'name',
            'is_active',
        ], $response);
    }

    public function testDelete(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->json('DELETE', route('genre.destroy', [
            'genre' => $genre->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }
}
