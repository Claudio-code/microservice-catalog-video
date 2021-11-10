<?php

namespace Tests\Traits;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;

trait FactoriesToCreateEntities
{
    /** @var array<string, mixed> */
    private array $data;

    private function factoryValidVideo(): void
    {
        $video = Video::factory()->create();
        $this->data['videos_ids'] = [$video->id];
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
