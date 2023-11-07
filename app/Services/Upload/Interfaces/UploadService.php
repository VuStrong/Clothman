<?php

namespace App\Services\Upload\Interfaces;

use Illuminate\Http\UploadedFile;

/**
 * Service Interface for Upload file
 */
interface UploadService
{
    /**
     * Upload a file
     */
    public function uploadFile(UploadedFile $file, array $options): array;

    /**
     * Delete a file
     */
    public function deleteFile(string $path): bool;
}