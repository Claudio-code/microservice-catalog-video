<?php

namespace Tests\Feature\Api\Http\Controller;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;
use Tests\Traits\TestValidations;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;
    use TestValidations;

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
            'category' => $category->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson($category->toArray());
    }

    public function testInvalidationDataPut(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $response = $this->json('PUT', route('categories.update', [
            'category' => $category->id,
            'name' => str_repeat('a', 256),
            'is_active' => 'dq',
        ]));

        self::assertInvalidationJson(
            $response,
            ['name', 'is_active'],
            [
                trans('validation.boolean', ['attribute' => 'is active']),
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            ]
        );
    }

    public function testInvalidationDataPost(): void
    {
        $response = $this->json('POST', route('categories.store', [
            'name' => str_repeat('a', 256),
            'is_active' => 'dq',
        ]));

        self::assertInvalidationJson(
            $response,
            ['name', 'is_active'],
            [
                trans('validation.boolean', ['attribute' => 'is active']),
                trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
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

    public function testCreate(): void
    {
        $name = str_repeat('a1', 6);
        $response = $this->json('POST', route('categories.store', [
            'name' => $name,
            'description' => 'esse é um teste de novo.',
            'is_active' => false,
        ]));

        $response
            ->assertCreated()
            ->assertJsonFragment([
                'is_active' => false,
                'name' => $name,
            ]);
        self::assertKeysInResponseBody([
            'id',
            'name',
            'is_active',
        ], $response);
    }

    public function testUpdate(): void
    {
        $category = Category::factory()->create();
        $name = 'dwq qd q';

        $response = $this->json('PUT', route('categories.update', [
            'category' => $category->id,
            'description' => 'esse é um teste de novo.',
            'is_active' => true,
        ]), ['name' => $name]);

        $response
            ->assertok()
            ->assertJsonFragment([
                'is_active' => true,
                'name' => $name,
            ]);
        self::assertKeysInResponseBody([
            'id',
            'name',
            'is_active',
        ], $response);
    }

    public function testDelete(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $response = $this->json('DELETE', route('categories.destroy', [
            'category' => $category->id,
        ]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }

    public function testRemoveInvalidCategory(): void
    {
        $response = $this->json('DELETE', route('categories.destroy', [
            'category' => RamseyUuid::uuid4(),
        ]));

        $response->assertStatus(404);
    }
}
