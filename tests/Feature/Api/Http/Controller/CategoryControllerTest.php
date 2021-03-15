<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex(): void
    {
        /** @var Collection */
        $catagories = Category::factory()->create();
        $response = $this->get(route('categories.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$catagories->toArray()]);
    }

    public function testShow(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', [
            'category' => $category->id
        ]));

        $response
            ->assertStatus(200)
            ->assertJson($category->toArray());
    }

    public function testInvalidationDataPut(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $response = $this->json('PUT', route('categories.update', [
            'category' => $category->id,
            'name' => str_repeat('a', 256),
            'is_active' => 'dq'
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([
                trans('validation.boolean', ['attribute' => 'is active'])
            ])
            ->assertJsonFragment([
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255])
            ]);
    }

    public function testInvalidationDataPost(): void
    {
        $response = $this->json('POST', route('categories.store', [
            'name' => str_repeat('a', 256),
            'is_active' => 'dq'
        ]));

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonFragment([
                trans('validation.boolean', ['attribute' => 'is active'])
            ])
            ->assertJsonFragment([
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255])
            ]);
    }

    public function testInvalidationJson(): void
    {
        $response = $this->json('POST', route('categories.store', []));
        $response
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonValidationErrors(['name']);
    }
}
