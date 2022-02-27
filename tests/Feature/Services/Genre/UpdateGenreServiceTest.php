<?php

namespace Tests\Feature\Services\Genre;

use App\DTO\DataTransferObject;
use App\DTO\GenreDTO;
use App\Factories\GenreDTOFactory;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\GenreRepository;
use App\Services\Genre\UpdateGenreService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tests\Traits\FactoriesToCreateEntities;
use Tests\Traits\TestValidations;

class UpdateGenreServiceTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;
    use FactoriesToCreateEntities;

    private Genre $genre;
    private UpdateGenreService $service;
    private GenreRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = Genre::factory()->create();
        $this->repository = new GenreRepository(new Genre());
        $this->service = new UpdateGenreService(new Genre());
        $this->data = new Request();
        $this->data->merge([
            "name" => "nonsense",
            "is_active" => true,
            "videos_ids" => ["4f3f-a46d-f4561bed29da"],
            "categories_ids" => ["-a46d-f4561bed29da"],
        ]);
    }

    private function buildFactory(): DataTransferObject
    {
        $factory = new GenreDTOFactory();
        return $factory->make($this->data);
    }

    public function testRollbackInGenreUpdateIfVideoIdIsInvalid(): void
    {
        $this->factoryValidCategory();
        try {
            $this->service->execute($this->buildFactory(), $this->genre->id);
        } catch (QueryException) {
            /** @var Genre $newGenre */
            $newGenre = $this->repository->all()->first();
            self::assertNull($newGenre->videos()->first());
            self::assertEmpty($newGenre->videos()->count());
        }
    }

    public function testRollbackInGenreUpdateIfCategoryIdIsInvalid(): void
    {
        $this->factoryValidVideo();
        try {
            $this->service->execute($this->buildFactory(), $this->genre->id);
        } catch (QueryException) {
            /** @var Genre $newGenre */
            $newGenre = $this->repository->all()->first();
            self::assertNull($newGenre->categories()->first());
            self::assertEmpty($newGenre->categories()->count());
        }
    }

    public function testRollbackInGenreUpdateIfVideoIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidCategory();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory(), $this->genre->id);
    }

    public function testRollbackInGenreUpdateIfCategoryIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidVideo();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory(), $this->genre->id);
    }

    public function testGenreUpdateIfCategoryIdAndVideoIdIsValid(): void
    {
        $this->factoryValidVideo();
        $this->factoryValidCategory();
        $this->service->execute($this->buildFactory(), $this->genre->id);

        /** @var Genre $newGenre */
        $newGenre = $this->repository->all()->first();

        /** @var Video $video */
        $video = $newGenre->videos()->first();
        $videosIds = $newGenre->videos()->allRelatedIds();

        /** @var Category $category */
        $category = $newGenre->categories()->first();
        $categoriesIds = $newGenre->categories()->allRelatedIds();

        self::assertEquals($video::class, Video::class);
        self::assertEquals($this->data->get('videos_ids')[0], $video->id);
        self::assertEquals($this->data->get('videos_ids'), $videosIds->toArray());

        self::assertEquals($category::class, Category::class);
        self::assertEquals($this->data->get('categories_ids')[0], $category->id);
        self::assertEquals($this->data->get('categories_ids'), $categoriesIds->toArray());
    }
}
