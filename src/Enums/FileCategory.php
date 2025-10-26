<?php

namespace Koderak\FileManager\Enums;

enum FileCategory: string
{
    case BOOK = 'book';
    case AUDIO = 'audio';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case SOFTWARE = 'software';
    case APPLICATION = 'application';

    public static function findCategory(string $mimeType) : self
    {
        if (MimeTypeAudio::tryFrom($mimeType)) {
            return self::AUDIO;
        }

        if (MimeTypeVideo::tryFrom($mimeType)) {
            return self::VIDEO;
        }

        if (MimeTypeSoftware::tryFrom($mimeType)) {
            return self::SOFTWARE;
        }

        if (MimeTypeApplication::tryFrom($mimeType)) {
            return self::APPLICATION;
        }

        if (MimeTypeBook::tryFrom($mimeType)) {
            return self::BOOK;
        }

        if (MimeTypeImage::tryFrom($mimeType)) {
            return self::IMAGE;
        }

        return null;
    }
}
