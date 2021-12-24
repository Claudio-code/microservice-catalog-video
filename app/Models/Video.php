<?php

namespace App\Models;

use App\DTO\VideoDTO;
use App\Models\Traits\Uuid;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    /** @var boolean */
    public $incrementing = false;

    /** @var string[] */
    protected $dates = ['deleted_at'];

    /** @var string[] */
    protected $fillable = [
        'title',
        'description',
        'year_launched',
        'opened',
        'rating',
        'duration',
    ];

    /** @var string[] */
    protected $casts = [
        'id' => 'string',
        'opened' => 'boolean',
        'year_launched' => 'integer',
        'duration' => 'integer',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(related: Category::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(related: Genre::class);
    }

    /** @throws Exception */
    public function createVideo(VideoDTO $videoDTO): ?self
    {
        try {
            DB::beginTransaction();
            $object = static::create($videoDTO->toArray());
            static::matchRelationship($object, $videoDTO);
            $object->refresh();
            DB::commit();

            return $object;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /** @throws Exception */
    public function updateVideo(VideoDTO $videoDTO): bool
    {
        try {
            DB::beginTransaction();
            $updated = parent::update($videoDTO->toArray());
            if ($updated) {
                // update file
            }
            static::matchRelationship($this, $videoDTO);
            DB::commit();

            return $updated;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    protected static function matchRelationship(Video $video, VideoDTO $videoDTO): void
    {
        $video->syncCategories($videoDTO->categories_ids);
        $video->syncGenres($videoDTO->genres_ids);
    }

    /** @param string[] $categoriesIds */
    public function syncCategories(array $categoriesIds): void
    {
        $this->categories()->sync($categoriesIds);
        $this->refresh();
    }

    /** @param string[] $genresIds */
    public function syncGenres(array $genresIds): void
    {
        $this->genres()->sync($genresIds);
        $this->refresh();
    }
}
