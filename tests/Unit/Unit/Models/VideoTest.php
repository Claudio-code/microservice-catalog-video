<?php

namespace Tests\Unit\Unit\Models;

use App\Models\Traits\Uuid;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

class VideoTest extends TestCase
{
    private Video $video;

    protected function setUp(): void
    {
        parent::setUp();
        $this->video = new Video();
    }

    public function testFillable(): void
    {
        $data = [
            'title',
            'description',
            'year_launched',
            'opened',
            'rating',
            'duration',
            'video_file',
        ];

        self::assertEquals($data, $this->video->getFillable());
    }

    public function testIfUseTraits(): void
    {
        $traits = [
            HasFactory::class, SoftDeletes::class, Uuid::class,
        ];
        $usedTraits = array_keys(class_uses(Video::class));
        self::assertEquals($traits, $usedTraits);
    }
}
