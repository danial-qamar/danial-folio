<?php

namespace App\Models;

use Awcodes\Curator\Models\Media as CuratorMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends CuratorMedia
{
    public function getSignedUrl(array $params = [], bool $force = false): string
    {
        return $this->url;
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $cleanPath = Str::after($this->path, 'public/');

                return Storage::disk($this->disk ?? 'public')->url($cleanPath);
            },
        );
    }
}
