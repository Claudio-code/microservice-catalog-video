<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList(): void
    {
        Category::create([
            'name' => 'casas12'
        ]);

        $categories = Category::all();
        $this->assertCount(1, $categories);
    }

    public function testSoftDelete(): void
    {
        $category = Category::create([
            'name' => 'casas212'
        ]);
        Category::destroy([$category->id]);
        $categories = Category::onlyTrashed()->get()->toArray();

        $this->assertCount(1, $categories);
    }

    public function testCreate(): void
    {
        $category = Category::create([
            'name' => 'casas12',
            'is_active' => true
        ]);

        $this->assertEquals('casas12', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
    }
}
