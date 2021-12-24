<?php

namespace Tests\Feature\Services\Video;

use App\Factories\VideoDTOFactory;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Services\Video\UpdateVideoService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class UpdateVideoServiceTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

    private Video $video;
    private UpdateVideoService $service;
    private VideoRepository $repository;
    /** @var array<string, mixed> */
    private array $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->video = Video::factory()->create();
        $this->repository = new VideoRepository(new Video());
        $this->service = new UpdateVideoService(new Video());
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

    public function testRollbackInVideoUpdateIfCategoryIdIsInvalid(): void
    {
        $this->factoryValidGenre();

        try {
            $dto = VideoDTOFactory::make($this->data);
            $this->service->execute($dto, $this->video->id);
        } catch (QueryException) {
            /** @var Video $newVideo */
            $newVideo = $this->repository->all()->get(0);
            self::assertNull($newVideo->categories()->first());
            self::assertEmpty($newVideo->categories()->count());
        }
    }

    public function testRollbackInVideoUpdateIfCategoryIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidGenre();

        $this->expectException(QueryException::class);
        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto, $this->video->id);
    }

    public function testRollbackInVideoUpdateIfGenreIdIsInvalid(): void
    {
        $this->factoryValidCategory();

        try {
            $dto = VideoDTOFactory::make($this->data);
            $this->service->execute($dto, $this->video->id);
        } catch (QueryException) {
            /** @var Video $newVideo */
            $newVideo = $this->repository->all()->get(0);
            self::assertNull($newVideo->genres()->first());
            self::assertEmpty($newVideo->genres()->count());
        }
    }

    public function testRollbackInVideoUpdateIfGenreIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidCategory();

        $this->expectException(QueryException::class);
        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto, $this->video->id);
    }

    public function testRollbackInVideoUpdateIfGenreIdAndCategoryIdIsValid(): void
    {
        $this->factoryValidGenre();
        $this->factoryValidCategory();

        $dto = VideoDTOFactory::make($this->data);
        $this->service->execute($dto, $this->video->id);

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


    private function factoryValidCategory(): void
    {
        $category = Category::factory()->create();
        $this->data['categories_ids'] = [$category->id];
    }

    private function factoryValidGenre(): void
    {
        $genre = Genre::factory()->create();
        $this->data['genres_ids'] = [$genre->id];
    }
}
