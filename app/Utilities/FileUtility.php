<?php

namespace App\Utilities;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;

class FileUtility
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getImageHelperText(string $prefix = '', string $suffix = ''): HtmlString
    {
        $result = __('Image Helper Text', [
            'prefix' => $prefix === '' ? '' : $prefix,
            'suffix' => $suffix === '' ?  '' : $suffix,
            'file_size' => '500KB',
        ]);
        return str($result)->trim()->inlineMarkdown()->toHtmlString();
    }

    public static function getPdfHelperText(string $prefix = '', string $suffix = ''): HtmlString
    {
        // dd([$prefix === '' ? '' : $prefix, $suffix === '' ?  '' : $suffix]);
        $result = __('PDF Helper Text', [
            'prefix' => $prefix === '' ? '' : $prefix,
            'suffix' => $suffix === '' ?  '' : $suffix,
            'file_size' => '500KB',
        ]);
        return str($result)->trim()->inlineMarkdown()->toHtmlString();
    }

    public static function generateFileName(string $uniqueValue, string $fileNameWithExtension, ?string $suffixLabel = null): string
    {
        $extension = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);
        $suffixLabel = $suffixLabel ? '-' . $suffixLabel : '';

        return $uniqueValue . $suffixLabel . '.' . $extension;
    }

    public static function getFileName(string $name, string $fileNameWithExtension): string
    {
        $extension = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);
        return $name . '.' . $extension;
    }


    public static function getJsonUrlImages(array $images): string
    {
        $result = [];
        foreach ($images as $key => $value) {
            $result[] = Storage::disk(config('filament.default_filesystem_disk'))->url($value);
        }
        return json_encode($result);
    }
}
