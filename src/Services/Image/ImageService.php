<?php

namespace Koderak\FileManager\Services\Image;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Intervention\Image\Format;
use Intervention\Image\MediaType;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Exceptions\EncoderException;
use Koderak\FileManager\Interfaces\FilterInterface;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Koderak\FileManager\Interfaces\ImageServiceInterface;

/**
 * ImageService
 *
 * The class that handle image processing. This class
 * have 2 main funcitonality.
 *     1. Image Editing
 *        - Greyscale
 *        - Blur
 *        - Crop
 *        - Smartcrop
 *        - Widen
 *        - Heighten
 *     2. Image Creating And Saving
 *        - Generate Image
 *        - Save Image
 *
 * NOTE: add functionality for custom image quality
 *       while encoding image
 *
 */
class ImageService implements ImageServiceInterface
{
    protected string $disk;

    protected string $path;

    protected array $filters;

    protected array $builderOption;

    protected string $outputFilename;

    protected string $encoder;

    protected Format $format;

    protected string $destinationDisk;

    protected string $destinationPath;

    protected EncodedImageInterface $renderedImage;

    protected $filenamePrefix;

    protected $filenameSuffix;

    public function __construct(array $config)
    {
        $this->setDisk($config['disk']);
        $this->setDestinationDisk($config['destinationDisk']);
        $this->setDestinationPath($config['destinationPath']);
        $this->encoder = $config['encoder'];
        $this->filters = $config['filters'];
    }

    public function setDisk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    public function setDestinationDisk(string $destinationDisk): self
    {
        $this->destinationDisk = $destinationDisk;

        return $this;
    }

    public function setDestinationPath(string $destinationPath): self
    {
        $this->destinationPath = $destinationPath;

        return $this;
    }

    public function generateImage(
        string $path,
        array $option = []
    ): self {
        $this->path = $path;
        $this->builderOption = array_merge($this->builderOption, $option);
        $this->renderImage();

        return $this;
    }

    public function save(
        string $path,
        array $option = [],
        string $prefix = null,
        string $suffix = null
    ): string {
        $this->generateImage($path, $option)
            ->setFormat()
            ->generateOutputFilename(
                prefix: $prefix,
                suffix: $suffix
            );

        Storage::disk($this->destinationDisk)
            ->put(
                $this->destinationPath.'/'.$this->outputFilename,
                $this->renderedImage
            );

        return $this->destinationPath.'/'.$this->outputFilename;
    }

    public function delete(string $path): bool
    {
        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        throw new Exception('File not found', Response::HTTP_NOT_FOUND);
    }

    protected function renderImage(): self
    {
        ini_set('memory_limit', '1024M');

        $image = Image::read($this->getImage());

        foreach ($this->filters as $filter) {
            $filter = app()->make($filter);

            if ($filter instanceof FilterInterface) {
                $image = $filter->handle($image, $this->builderOption);
            } else {
                throw new Exception('filter must be instanceof FilterInterface, given filter: "' . $filter . '"');
            }
        }

        $this->renderedImage = $this->encodeImage($image);

        return $this;
    }

    protected function encodeImage(ImageInterface $image): EncodedImageInterface
    {
        if ($this->encoder === 'auto' || $this->encoder === null) {
            $encodedImage = $image->encode();
        } elseif ($this->encoder) {
            // NOTE: need to add build quality for some image
            //       format's
            $encoder = app()->make($this->encoder);
            $encodedImage = $image->encode($encoder);
        }

        return $encodedImage;
    }

    protected function setFormat(string|MediaType $format = null): self
    {
        if ($format) {
            try {
                $mediaType = is_string($format) ? MediaType::from($format) : $format;
            } catch (Error) {
                throw new EncoderException('No encoder found for media type (' . $mediaType . ').');
            }
        } else {
            $mediaType = MediaType::from($this->renderedImage->mediaType());
        }

        $this->format = $mediaType->format();

        return $this;
    }

    protected function generateOutputFilename(?string $path = null, ?string $prefix = null, ?string $suffix = null): self
    {
        $path = $path ?? $this->path;
        $paths = explode(DIRECTORY_SEPARATOR, $path);
        $filename = (string) Arr::last($paths);
        $filenameParts = (array) explode('.', $filename);
        array_pop($filenameParts);

        // arra
        $flatFilename = implode(DIRECTORY_SEPARATOR, $filenameParts);

        $outputFilename = $flatFilename;
        if ($prefix) {
            $outputFilename = "$prefix-$outputFilename";
        }

        if ($suffix) {
            $outputFilename = "$outputFilename-$suffix";
        }

        $extension = $this->format->fileExtensions()[0]->value;
        $this->outputFilename = "$outputFilename.$extension";

        return $this;
    }

    protected function getImage(): string
    {
        return Storage::disk($this->disk)->get($this->path);
    }


    // Image Processing

    public function greyscale(): self
    {
        return $this->builderAddOption('greyscale', '1');
    }

    /**
     * NOTE: Blur with large images takes long
     */
    public function blur(int $amount = 1): self
    {
        return $this->builderAddOption('blur', $amount);
    }

    public function smartcrop(int $width, int $height): self
    {
        return $this->builderAddOption('smartcrop', $width . 'x' . $height);
    }

    public function crop(int $width, int $height): self
    {
        return $this->builderAddOption('crop', $width . 'x' . $height);
    }

    public function widen(int $width): self
    {
        return $this->builderAddOption('widen', $width);
    }

    public function heighten(int $height): self
    {
        return $this->builderAddOption('heighten', $height);
    }

    public function builderAddOption(string $key, string|array|int $value): self
    {
        $this->builderOption[$key] = $value;

        return $this;
    }
}
