<?php

namespace Koderak\FileManager;

class Utility
{
    public static function generateFilename(
        string $filename,
        string $extension,
        int $length = 100
    ) : string {
        $filename = self::filterFilename($filename);

        $trimmedFileName = str()->substr(
            trim(pathinfo($filename, PATHINFO_FILENAME)),
            0,
            $length
        );

        return sprintf('%s-%s.%s', time(), $trimmedFileName, strtolower($extension));
    }

    public static function filterFilename(string $filename): string
    {
        // sanitize filename
        $filename = preg_replace(
            '~
            [<>:"/\\\|?*]|            # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
            [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
            [#\[\]@!$&\'()+,;=]|     # URI reserved https://www.rfc-editor.org/rfc/rfc3986#section-2.2
            [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
            ~x',
            '-',
            $filename
        );

        // avoids ".", ".." or ".hiddenFiles"
        $filename = ltrim($filename, '.-');

        $filename = self::beautifyFilename($filename);

        // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = mb_strcut(
            pathinfo($filename, PATHINFO_FILENAME),
            0,
            255 - ($ext ? strlen($ext) + 1 : 0),
            mb_detect_encoding($filename)
        ) . ($ext ? '.' . $ext : '');

        return $filename;
    }

    public static function beautifyFilename($filename): string
    {
        // reduce consecutive characters
        $filename = preg_replace(array(
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file---name.zip" becomes "file-name.zip"
            '/-+/',
        ), '-', $filename);
        $filename = preg_replace(array(
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/',
        ), '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');

        return $filename;
    }

    public static function buildPath(string $path, string $filename) : string
    {
        $path = self::trimDirectorySeparator($path);
        $filename = self::trimDirectorySeparator($filename);
        $path = DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR;

        return $path.$filename;
    }

    public static function trimDirectorySeparator(string $path): string
    {
        $path = trim($path, DIRECTORY_SEPARATOR);

        return $path;
    }

    public static function incrementName(string $name, array $existingName): string
    {
        if (in_array($name, $existingName)) {
            $ext = (string) self::splitLast($name,".")[1];
            $baseFileName= (string) self::splitLast(self::splitLast($name,".")[0],"(")[0];
            $num = (int) intval(self::splitLast(self::splitLast($name,"(")[1],")")[0]) + 1;

            $filename = "$baseFileName($num)";

            if ($ext) {
                $filename = "$filename.$ext";
            }

            return self::incrementName($filename, $existingName);
        }

        return $name;
    }

    protected static function splitLast($string,$delim): array
    {
        $parts = explode($delim, $string);
        if (!$parts || count($parts) === 1) {
            $before=$string;
            $after="";
        } else {
            $after = array_pop($parts);
            $before=implode($delim, $parts);
        }

        return array($before,$after);
    }
}
