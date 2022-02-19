<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use DatabaseMigrations;

    public function testRelationshipWithGenre(): void
    {
        /** @var Genre */
        $genre = Genre::factory()->create();
        $genre->refresh();

        /** @var Video $video */
        $video = Video::factory()->create();
        $video->refresh();

        $video->syncGenres([$genre->id]);
        $video->refresh();

        self::assertEquals($genre->name, $video->genres()->first()->name);
    }

    public function testRelationshipWithCategory(): void
    {
        /** @var Category $category */
        $category = Category::factory()->create();
        $category->refresh();

        /** @var Video $video */
        $video = Video::factory()->create();
        $video->refresh();

        $video->syncCategories([$category->id]);
        $video->refresh();

        self::assertEquals($category->name, $video->categories()->first()->name);
    }

    public function testList(): void
    {
        Video::factory()->count(10)->create();
        $videos = Video::all();

        self::assertCount(10, $videos);
    }

    public function testSoftDelete(): void
    {
        /** @var Video $video */
        $video = Video::factory()->create();
        $video->refresh();
        $video->delete();
        $videosActives = Video::all();
        $videosTrashed = Video::onlyTrashed()->get()->toArray();

        self::assertCount(1, $videosTrashed);
        self::assertCount(0, $videosActives);
    }

    public function testCreate(): void
    {
        /** @var Video $video */
        $video = Video::factory([
            "title" => "lorem ipsolom",
            "description" => "qd qwd qwdq wdqwd qwdwqrgerr",
            "opened" => true,
            "rating" => 2,
            "duration" => 32,
            "year_launched" => 2001,
        ])->create();
        $video->refresh();

        self::assertTrue((bool) preg_match(self::REGEX_TO_TEST_UUID4, $video->id));
        self::assertEquals('lorem ipsolom', $video->title);
        self::assertTrue($video->opened);
    }

    public function testUpdate(): void
    {
        /** @var Video $video */
        $video = Video::factory()->create();
        $video->refresh();
        $video->update([
            "title" => "lorem ipsolom",
        ]);

        self::assertEquals('lorem ipsolom', $video->title);
    }
}
