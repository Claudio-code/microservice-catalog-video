<?php

namespace Tests\Feature\Models;

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

        self::assertTrue((bool) preg_match(self::REGEX_TO_TEST_UUID4, $category->id));
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
            'is_active' => false,
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
