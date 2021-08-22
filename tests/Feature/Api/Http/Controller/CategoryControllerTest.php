<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations;

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

        self::assertInvalidationJson(
            $response,
            ['name', 'is_active'],
            [
                trans('validation.boolean', ['attribute' => 'is active']),
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255])
            ]
        );
    }

    public function testInvalidationDataPost(): void
    {
        $response = $this->json('POST', route('categories.store', [
            'name' => str_repeat('a', 256),
            'is_active' => 'dq'
        ]));

        self::assertInvalidationJson(
            $response,
            ['name', 'is_active'],
            [
                trans('validation.boolean', ['attribute' => 'is active']),
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255])
            ]
        );
    }

    public function testInvalidationJson(): void
    {
        $response = $this->json('POST', route('categories.store', []));
        self::assertInvalidationJson(
            $response,
            ['name'],
            [],
            ['is_active']
        );
    }

    public function testRemoveCategory(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $response = $this->json('DELETE', route('categories.destroy', [
            'category' => $category->id
        ]));

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function testRemoveInvalidCategory(): void
    {
        $response = $this->json('DELETE', route('categories.destroy', [
            'category' => RamseyUuid::uuid4()
        ]));

        $response->assertStatus(404);
    }
}
