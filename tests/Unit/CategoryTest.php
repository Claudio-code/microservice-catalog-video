<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testFillable(): void
    {
        $category = new Category();
        $data = [
            'name',
            'description',
            'is_active',
        ];

        $this->assertEquals($data, $category->getFillable());
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
