<?php

namespace Koderak\FileManager\Models;

use Database\Factory\FileFactory;
use Illuminate\Database\Eloquent\Model;
use Koderak\FileManager\Enums\FileCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;

class FileModel extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'meta' => 'array',
            'type' => AsEnumCollection::of(FileCategory::class),
        ];
    }

    public function fileable() : MorphTo
    {
        return $this->morphTo();
    }

    protected static function newFactory(): Factory
    {
        return FileFactory::new();
    }
}
