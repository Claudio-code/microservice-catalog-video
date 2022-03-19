<?php

namespace App\Models\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

abstract class FileUpload extends Model
{
    /** @var string[] */
    protected array $filesFields = [];
    protected string $pathToSaveFiles = "/";

    public function changePath(string $newPath): void
    {
        if (empty($newPath)) {
            return;
        }

        $this->pathToSaveFiles = $newPath;
    }

    /** @param Collection<UploadedFile> $files */
    public function uploadFiles(Collection $files): void
    {
        $files->each($this->uploadFile(...));
    }

    public function uploadFile(UploadedFile $file): void
    {
        $file->store($this->pathToSaveFiles);
    }

    /** @param Collection<string|UploadedFile> $files */
    public function deleteFiles(Collection $files): void
    {
        $files->each($this->deleteFile(...));
    }

    public function deleteFile(string|UploadedFile $file): void
    {
        if (empty($file)) {
            return;
        }
        $pathOfThisFile = "{$this->pathToSaveFiles}/{$this->getFileName($file)}";
        Storage::delete($pathOfThisFile);
    }

    /**
     * @param Collection<UploadedFile|string|int|bool> $attributes
     * @return Collection<UploadedFile>
     */
    public function extractFiles(Collection &$attributes): Collection
    {
        return $attributes->reduce(function (Collection $accumulate, mixed $field, mixed $key) use (&$attributes) {
            $attributeField = $attributes->get($key);
            if ($attributeField instanceof UploadedFile === false) {
                return $accumulate;
            }
            $accumulate->push($attributeField);
            $attributes->put($key, $attributeField->hashName());
            return $accumulate;
        }, Collection::empty());
    }

    private function getFileName(string|UploadedFile $file): string
    {
        return match (is_string($file)) {
            true => $file,
            default => $file->hashName(),
        };
    }
}
