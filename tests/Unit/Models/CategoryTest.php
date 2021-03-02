<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private Category $category;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testFillable(): void
    {
        $data = [
            'name',
            'description',
            'is_active',
        ];

        $this->assertEquals($data, $this->category->getFillable());
    }

    public function testIfUseTraits(): void
    {
        $traits = [
            HasFactory::class, SoftDeletes::class, Uuid::class,
        ];
        $usedTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits, $usedTraits);
    }
}
