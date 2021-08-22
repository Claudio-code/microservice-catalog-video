<?php

namespace Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList(): void
    {
        Category::factory()->create();
        $categories = Category::all();

        self::assertCount(1, $categories);
    }

    public function testSoftDelete(): void
    {
        $category = Category::factory()->create();
        $category->refresh();
        Category::destroy([$category->id]);
        $categories = Category::onlyTrashed()->get()->toArray();

        self::assertCount(1, $categories);
    }

    public function testCreate(): void
    {
        /** @var Category */
        $category = Category::factory(['name' => 'casas12'])->create();
        $category->refresh();

        // regex to validadate uuid v4
        $regex = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

        self::assertTrue((bool) preg_match($regex, $category->id));
        self::assertEquals('casas12', $category->name);
        self::assertTrue($category->is_active);
    }

    public function testUpdate(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $category->refresh();
        $category->update([
            'name' => 'testando',
            'is_active' => false
        ]);

        self::assertEquals('testando', $category->name);
        self::assertFalse($category->is_active);
    }

    public function testDelete(): void
    {
        /** @var Category */
        $category = Category::factory()->create();
        $category->refresh();
        $category->delete();
        $categories = Category::all()->toArray();

        self::assertEquals(0, count($categories));
    }
}
