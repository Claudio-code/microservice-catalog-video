<?php

namespace App\Models\AbstractModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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

    /** @param UploadedFile[] $files */
    public function uploadFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->uploadFile($file);
        }
    }

    public function uploadFile(UploadedFile $file): void
    {
        $file->store($this->pathToSaveFiles);
    }

    /** @param array<string|UploadedFile> $files */
    public function deleteFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
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
     * @param array<UploadedFile|string|int|bool> $attributes
     * @return UploadedFile[]
     */
    public function extractFiles(array &$attributes = []): array
    {
        return array_reduce(array: $this->filesFields, callback: function ($accumulate, $field) use ($attributes) {
            if (!isset($attributes[$field])) {
                return $accumulate;
            }
            if (!($attributes[$field] instanceof UploadedFile)) {
                return $accumulate;
            }
            $accumulate[] = $attributes[$field];
            $attributes[$field] = $attributes[$field]->hashName();
            return $accumulate;
        }, initial: []);
    }

    private function getFileName(string|UploadedFile $file): string
    {
        return match (is_string($file)) {
            true => $file,
            default => $file->hashName(),
        };
    }
}
