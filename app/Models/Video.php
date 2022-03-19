<?php

namespace App\Models;

use App\DTO\VideoDTO;
use App\Models\AbstractModels\FileUpload;
use App\Models\Traits\Uuid;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Video extends FileUpload
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    protected array $filesFields = [
        'video_file',
        'banner_file',
        'thumb_file',
        'trailer_file',
    ];

    protected string $pathToSaveFiles = "/video/";

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
        'video_file',
        'thumb_file',
        'banner_file',
        'trailer_file',
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
        $data = $videoDTO->toCollection();
        $filesToSave = $this->extractFiles($data);
        try {
            DB::beginTransaction();
            $object = static::create($data->toArray());
            static::matchRelationship($object, $videoDTO);
            $this->uploadFiles($filesToSave);
            $object->refresh();
            DB::commit();
            return $object;
        } catch (Exception $exception) {
            $this->deleteFiles($filesToSave);
            DB::rollBack();
            throw $exception;
        }
    }

    /** @throws Exception */
    public function updateVideo(VideoDTO $videoDTO): bool
    {
        $data = $videoDTO->toCollection();
        $filesToSave = $this->extractFiles($data);
        $oldFileName = $this->video_file ?? "";
        try {
            DB::beginTransaction();
            $updated = parent::update($data->toArray());
            if ($updated) {
                $this->uploadFiles($filesToSave);
            }
            $this->refresh();
            static::matchRelationship($this, $videoDTO);
            DB::commit();
            if ($oldFileName !== $videoDTO->video_file?->hashName()) {
                $this->deleteFile($oldFileName);
            }
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
