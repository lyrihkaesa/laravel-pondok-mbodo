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

    public static function getImageHelperText(string $prefix = ''): HtmlString
    {
        return str($prefix . 'File harus berformat **.jpg**, **.jpeg**, **.png** dan berukuran maksimal **500KB**. Untuk backgorund warna merah gunakan **#DB1514** dan biru gunakan **#0090FF**.')->inlineMarkdown()->toHtmlString();
    }

    public static function getPdfHelperText(string $prefix = ''): HtmlString
    {
        return str($prefix . 'File harus berformat **.pdf** dan berukuran maksimal **500KB**.')->inlineMarkdown()->toHtmlString();
    }

    public static function generateFileName(string $uniqueValue, string $fileNameWithExtension, ?string $suffixLabel): string
    {
        $extension = pathinfo($fileNameWithExtension, PATHINFO_EXTENSION);
        $suffixLabel = $suffixLabel ? '-' . $suffixLabel : '';

        return $uniqueValue . $suffixLabel . '.' . $extension;
    }
}
