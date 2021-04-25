<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->get(route('genre.index'));
        $response
            ->assertStatus(200)
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
            ->assertStatus(200)
            ->assertJson($genre->toArray());
    }

    public function testCreate(): void
    {
        $response = $this->json('POST', route('genre.store', [
            'name' => str_repeat('a1', 6),
            'is_active' => true,
        ]));

        $response->assertStatus(201);
    }

    public function testCreateInvalidJson(): void
    {
        $response = $this->json('POST', route('genre.store', [
            'name' => str_repeat('a1', 326),
            'is_active' => 'dqw dwqw2',
        ]));

        $response->assertStatus(422);
    }

    public function testUpdate(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->json('PUT', route('genre.update', [
            'genre' => $genre->id,
        ]), ['name' => 'dwq qd q']);

        $genre->name = 'dwq qd q';
        $response
            ->assertStatus(202)
            ->assertJson($genre->toArray());
    }

    public function testDelete(): void
    {
        $genre = Genre::factory()->create();
        assert($genre instanceof Genre);

        $response = $this->json('DELETE', route('genre.destroy', [
            'genre' => $genre->id,
        ]));

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
