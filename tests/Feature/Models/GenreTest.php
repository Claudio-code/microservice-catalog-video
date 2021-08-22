<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList(): void
    {
        Genre::factory()->count(10)->create();
        $genres = Genre::all();

        self::assertCount(10, $genres);
    }

    public function testSoftDelete(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();
        $genre->delete();
        $genresActives = Genre::all();
        $genres = Genre::onlyTrashed()->get()->toArray();

        self::assertCount(1, $genres);
        self::assertCount(0, $genresActives);
    }

    public function testCreate(): void
    {
        /** @var Genre */
        $genre = Genre::factory(['name' => 'teste'])->create();
        $genre->refresh();

        // regex to validadate uuid v4
        $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        self::assertTrue((bool) preg_match($regex, $genre->id));
        self::assertEquals('teste', $genre->name);
        self::assertTrue($genre->is_active);
    }

    public function testUpdate(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();
        $genre->update([
            'name' => 'teste2'
        ]);

        self::assertEquals('teste2', $genre->name);
    }
}
