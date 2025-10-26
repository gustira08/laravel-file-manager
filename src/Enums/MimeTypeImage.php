<?php

namespace Koderak\FileManager\Enums;

enum MimeTypeImage: string
{
    case IMAGE_JPEG = 'image/jpeg';
    case IMAGE_JPG = 'image/jpg';
    case IMAGE_PJPEG = 'image/pjpeg';
    case IMAGE_WEBP = 'image/webp';
    case IMAGE_X_WEBP = 'image/x-webp';
    case IMAGE_GIF = 'image/gif';
    case IMAGE_PNG = 'image/png';
    case IMAGE_X_PNG = 'image/x-png';
    case IMAGE_AVIF = 'image/avif';
    case IMAGE_X_AVIF = 'image/x-avif';
    case IMAGE_BMP = 'image/bmp';
    case IMAGE_MS_BMP = 'image/ms-bmp';
    case IMAGE_X_BITMAP = 'image/x-bitmap';
    case IMAGE_X_BMP = 'image/x-bmp';
    case IMAGE_X_MS_BMP = 'image/x-ms-bmp';
    case IMAGE_X_WINDOWS_BMP = 'image/x-windows-bmp';
    case IMAGE_X_WIN_BITMAP = 'image/x-win-bitmap';
    case IMAGE_X_XBITMAP = 'image/x-xbitmap';
    case IMAGE_TIFF = 'image/tiff';
    case IMAGE_JP2 = 'image/jp2';
    case IMAGE_JPX = 'image/jpx';
    case IMAGE_JPM = 'image/jpm';
    case IMAGE_HEIC = 'image/heic';
    case IMAGE_HEIF = 'image/heif';
}
