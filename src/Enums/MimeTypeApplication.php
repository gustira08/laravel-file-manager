<?php

namespace Koderak\FileManager\Enums;

enum MimeTypeApplication: string
{
    case APPLICATION_VND_ANDROID_PACKAGE_ARCHIVE = 'application/vnd.android.package-archive';
    case APPLICATION_OCTET_STREAM_IPA = 'application/octet-stream-ipa';
    case APPLICATION_JAVA_ARCHIVE = 'application/java-archive';
    case APPLICATION_X_SILVERLIGHT_APP = 'application/x-silverlight-app';
}
