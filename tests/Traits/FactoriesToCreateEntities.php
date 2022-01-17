<?php

namespace Tests\Traits;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use Illuminate\Http\Request;

trait FactoriesToCreateEntities
{
    private Request $data;

    private function factoryValidVideo(): void
    {
        $video = Video::factory()->create();
        $this->data->merge(['videos_ids' => [$video->id]]);
    }

    private function factoryValidCategory(): void
    {
        $category = Category::factory()->create();
        $this->data->merge(['categories_ids' => [$category->id]]);
    }

    private function factoryValidGenre(): void
    {
        $genre = Genre::factory()->create();
        $this->data->merge(['genres_ids' => [$genre->id]]);
    }
}
