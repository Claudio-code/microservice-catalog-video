<?php

namespace Tests\Feature\Services\Video;

use App\DTO\VideoDTO;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use App\Repositories\VideoRepository;
use App\Services\Video\CreateVideoService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class CreateVideoServiceTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

    private CreateVideoService $service;
    private VideoRepository $repository;
    /** @var array<string, mixed> */
    private array $data;

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
            $dto = VideoDTO::factory($this->data);
            $this->service->execute($dto);
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfCategoryIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidGenre();

        $this->expectException(QueryException::class);
        $dto = VideoDTO::factory($this->data);
        $this->service->execute($dto);
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalid(): void
    {
        $this->factoryValidCategory();

        try {
            $dto = VideoDTO::factory($this->data);
            $this->service->execute($dto);
        } catch (QueryException) {
            self::assertEmpty($this->repository->all()->toArray());
        }
    }

    public function testRollbackInVideoCreateIfGenreIdIsInvalidThrowQueryException(): void
    {
        $this->factoryValidCategory();

        $this->expectException(QueryException::class);
        $dto = VideoDTO::factory($this->data);
        $this->service->execute($dto);
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
