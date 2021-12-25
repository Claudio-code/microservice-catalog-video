<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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

        self::assertTrue((bool) preg_match(self::REGEX_TO_TEST_UUID4, $genre->id));
        self::assertEquals('teste', $genre->name);
        self::assertTrue($genre->is_active);
    }

    public function testUpdate(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();
        $genre->update([
            'name' => 'teste2',
        ]);

        self::assertEquals('teste2', $genre->name);
    }
}
