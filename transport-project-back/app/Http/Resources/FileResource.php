<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->file_id,
            'name' => $this->file_name,
            'type' => $this->file_type,
            'size' => $this->file_size,
            'size_formatted' => $this->formatBytes($this->file_size),
            'uploaded_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'url' => url("/api/v1/files/{$this->file_id}/download"),
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}