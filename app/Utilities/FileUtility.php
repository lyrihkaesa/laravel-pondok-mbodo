<?php

namespace App\Utilities;

use Illuminate\Support\HtmlString;

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
}
