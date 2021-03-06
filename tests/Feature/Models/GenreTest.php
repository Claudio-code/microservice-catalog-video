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

        $this->assertCount(10, $genres);
    }

    public function testSoftDelete(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();
        $genre->delete();
        $genresActives = Genre::all();
        $genres = Genre::onlyTrashed()->get()->toArray();

        $this->assertCount(1, $genres);
        $this->assertCount(0, $genresActives);
    }

    public function testCreate(): void
    {
        /** @var Genre */
        $genre = Genre::factory(['name' => 'teste'])->create();
        $genre->refresh();

        // regex to validadate uuid v4
        $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        $this->assertTrue((bool) preg_match($regex, $genre->id));
        $this->assertEquals('teste', $genre->name);
        $this->assertTrue($genre->is_active);
    }

    public function testUpdate(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();
        $genre->update([
            'name' => 'teste2'
        ]);

        $this->assertEquals('teste2', $genre->name);
    }
}
