<?php

namespace Tests\Feature\Services\Video;

use App\DTO\DataTransferObject;
use App\Factories\VideoDTOFactory;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Services\Video\CreateVideoService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\TestCase;
use Tests\Traits\FactoriesToCreateEntities;
use Tests\Traits\TestValidations;

class CreateVideoServiceTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;
    use FactoriesToCreateEntities;

    private CreateVideoService $service;
    private VideoRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new VideoRepository(new Video());
        $this->service = new CreateVideoService(new Video());
        $this->data = new Request();
        $this->data->merge([
            "title" => "lorem ipsolom",
            "description" => "qd qwd qwdq wdqwd qwdwqrgerr",
            "opened" => false,
            "rating" => 0,
            "duration" => 32,
            "year_launched" => 2001,
            "categories_ids" => ["4f3f-a46d-f4561bed29da"],
            "genres_ids" => ["-a46d-f4561bed29da"],
        ]);
    }

    private function buildFactory(): DataTransferObject
    {
        $factory = new VideoDTOFactory();
        return $factory->make($this->data);
    }

    public function testRollbackInVideoCreateIfCategoryIdIsInvalid(): void
    {
        $this->factoryValidGenre();
        try {
            $this->service->execute($this->buildFactory());
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfCategoryIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidGenre();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory());
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalid(): void
    {
        $this->factoryValidCategory();
        try {
            $this->service->execute($this->buildFactory());
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidCategory();
        $this->expectException(QueryException::class);
        $this->service->execute($this->buildFactory());
    }

    public function testVideoCreateIfGenreIdAndCategoryIdIsValid(): void
    {
        $this->factoryValidGenre();
        $this->factoryValidCategory();
        $this->service->execute($this->buildFactory());

        /** @var Video $newVideo */
        $newVideo = $this->repository->all()->get(0);
        $categoriesIds = $newVideo->categories()->allRelatedIds();
        /** @var Category $category */
        $category = $newVideo->categories()->first();
        $genresIds = $newVideo->genres()->allRelatedIds();
        /** @var Genre $genre */
        $genre = $newVideo->genres()->first();

        self::assertEquals($category::class, Category::class);
        self::assertEquals($this->data->get('categories_ids')[0], $category->id);
        self::assertEquals($this->data->get('categories_ids'), $categoriesIds->toArray());

        self::assertEquals($genre::class, Genre::class);
        self::assertEquals($this->data->get('genres_ids')[0], $genre->id);
        self::assertEquals($this->data->get('genres_ids'), $genresIds->toArray());
    }
}
