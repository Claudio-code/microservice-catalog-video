<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\VideoFileUpdateTrait;

class VideoTest extends TestCase
{
    use DatabaseMigrations;
    use VideoFileUpdateTrait;

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

    public function testIfCreateTrailerFile(): void
    {
        $trailer = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory()->create();
        $video->uploadFile($trailer);

        Storage::assertExists("video/{$trailer->hashName()}");
    }

    public function testIfUpdateTrailerFile(): void
    {
        $trailerCreate = $this->getValidFileVideo();
        $trailerUpdate = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory()->create();

        $video->uploadFile($trailerCreate);
        Storage::assertExists("video/{$trailerCreate->hashName()}");

        $video->deleteFile($trailerCreate);
        Storage::assertMissing("video/{$trailerCreate->hashName()}");

        $video->uploadFile($trailerUpdate);
        Storage::assertExists("video/{$trailerUpdate->hashName()}");
    }

    public function testIfCreateVideoFile(): void
    {
        $videoFile = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory()->create();
        $video->uploadFile($videoFile);
        Storage::assertExists("video/{$videoFile->hashName()}");
    }

    public function testIfUpdateVideoFile(): void
    {
        $videoToCreate = $this->getValidFileVideo();
        $videoToUpdate = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory()->create();

        $video->uploadFile($videoToCreate);
        Storage::assertExists("video/{$videoToCreate->hashName()}");

        $video->deleteFile($videoToCreate);
        Storage::assertMissing("video/{$videoToCreate->hashName()}");

        $video->uploadFile($videoToUpdate);
        Storage::assertExists("video/{$videoToUpdate->hashName()}");
    }

    public function testIfDeleteVideoFile(): void
    {
        $videoFile = $this->getValidFileVideo();
        /** @var Video $video */
        $video = Video::factory()->create();

        $video->uploadFile($videoFile);
        Storage::assertExists("video/{$videoFile->hashName()}");

        $video->deleteFiles(Collection::make([$videoFile]));
        Storage::assertMissing("video/{$videoFile->hashName()}");
    }
}
