<?php

namespace Tests\Feature\Services\Video;

use App\Factories\VideoDTOFactory;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Services\Video\CreateVideoService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        $this->data = [
            "title" => "lorem ipsolom",
            "description" => "qd qwd qwdq wdqwd qwdwqrgerr",
            "opened" => false,
            "rating" => 0,
            "duration" => 32,
            "year_launched" => 2001,
            "categories_ids" => ["4f3f-a46d-f4561bed29da"],
            "genres_ids" => ["-a46d-f4561bed29da"],
        ];
    }

    public function testRollbackInVideoCreateIfCategoryIdIsInvalid(): void
    {
        $this->factoryValidGenre();

        try {
            $dto = VideoDTOFactory::make($this->data);
            $this->service->execute($dto);
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfCategoryIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidGenre();

        $this->expectException(QueryException::class);
        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto);
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalid(): void
    {
        $this->factoryValidCategory();

        try {
            $dto = VideoDTOFactory::make($this->data);
            $this->service->execute($dto);
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidCategory();

        $this->expectException(QueryException::class);
        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto);
    }

    public function testVideoCreateIfGenreIdAndCategoryIdIsValid(): void
    {
        $this->factoryValidGenre();
        $this->factoryValidCategory();

        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto);

        /** @var Video $newVideo */
        $newVideo = $this->repository->all()->get(0);
        $categoriesIds = $newVideo->categories()->allRelatedIds();
        /** @var Category $category */
        $category = $newVideo->categories()->first();
        $genresIds = $newVideo->genres()->allRelatedIds();
        /** @var Genre $genre */
        $genre = $newVideo->genres()->first();

        self::assertEquals($category::class, Category::class);
        self::assertEquals($this->data['categories_ids'][0], $category->id);
        self::assertEquals($this->data['categories_ids'], $categoriesIds->toArray());

        self::assertEquals($genre::class, Genre::class);
        self::assertEquals($this->data['genres_ids'][0], $genre->id);
        self::assertEquals($this->data['genres_ids'], $genresIds->toArray());
    }
}
