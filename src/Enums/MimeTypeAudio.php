<?php

namespace Koderak\FileManager\Enums;

enum MimeTypeAudio: string
{
    case AUDIO_BASIC =   'audio/basic';
    case AUDIO_L24 =   'auido/L24';
    case AUDIO_MID =   'audio/mid';
    case AUDIO_MP4 =   'audio/mp4';
    case AUDIO_X_AIFF =   'audio/x-aiff';
    case AUDIO_X_MPEGURL =   'audio/x-mpegurl';
    case AUDIO_VND_RN_REALAUDIO =   'audio/vnd.rn-realaudio';
    case AUDIO_OGG =   'audio/ogg';
    case AUDIO_VORBIS =   'audio/vorbis';
    case AUDIO_VND_WAV =   'audio/vnd.wav';
    case AUDIO_MPEG =   'audio/mpeg';
}
