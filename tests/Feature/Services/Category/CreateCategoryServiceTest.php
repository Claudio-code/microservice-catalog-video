<?php

namespace Tests\Feature\Services\Category;

use App\DTO\DataTransferObject;
use App\Factories\CategoryDTOFactory;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Services\Category\CreateCategoryService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tests\Traits\FactoriesToCreateEntities;
use Tests\Traits\TestValidations;

class CreateCategoryServiceTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;
    use FactoriesToCreateEntities;

    private CreateCategoryService $service;
    private CategoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CategoryRepository(new Category());
        $this->service = new CreateCategoryService(new Category());
        $this->data = new Request();
        $this->data->merge([
            "name" => "ação",
            "description" => "esse é um teste de novo.",
            "is_active" => true,
            "videos_ids" => ["4f3f-a46d-f4561bed29da"],
            "genres_ids" => ["-a46d-f4561bed29da"],
        ]);
    }

    private function buildFactory(): DataTransferObject
    {
        $factory = new CategoryDTOFactory();
        return $factory->make($this->data);
    }

    public function testRollbackInCategoryCreateIfVideoIdIsInvalid(): void
    {
        $this->factoryValidGenre();
        try {
            $this->service->execute($this->buildFactory());
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInCategoryCreateIfGenreIdIsInvalid(): void
    {
        $this->factoryValidVideo();
        try {
            $this->service->execute($this->buildFactory());
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInCategoryCreateIfVideoIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidGenre();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory());
    }

    public function testRollbackInCategoryCreateIfGenreIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidVideo();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory());
    }

    public function testCategoryCreateIfGenreIdAndVideoIdIsValid(): void
    {
        $this->factoryValidVideo();
        $this->factoryValidGenre();
        $this->service->execute($this->buildFactory());

        /** @var Category $newCategory */
        $newCategory = $this->repository->all()->get(0);
        $videosIds = $newCategory->videos()->allRelatedIds();
        /** @var Video $video */
        $video = $newCategory->videos()->first();
        $genresIds = $newCategory->genres()->allRelatedIds();
        /** @var Genre $genre */
        $genre = $newCategory->genres()->first();

        self::assertEquals($video::class, Video::class);
        self::assertEquals($this->data->get('videos_ids')[0], $video->id);
        self::assertEquals($this->data->get('videos_ids'), $videosIds->toArray());

        self::assertEquals($genre::class, Genre::class);
        self::assertEquals($this->data->get('genres_ids')[0], $genre->id);
        self::assertEquals($this->data->get('genres_ids'), $genresIds->toArray());
    }
}
